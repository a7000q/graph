<?php

namespace app\models;


use app\components\Queue;
use yii\base\BaseObject;

class Route
{
    private $_start;
    private $_end;

    private $_edges;
    private $_edgesArray;

    private $used = [];
    private $sum = [];
    private $path = [];

    const ERROR_MSG = "Невозможно построить маршрут!";

    private $is_normal = false;


    public function __construct(Points $start, Points $end)
    {
        $this->_start = $start;
        $this->_end = $end;
    }

    public function getShortRoute(){
        if ($this->_start->id == $this->_end->id)
            return [
                'sum' => 0,
                'path' => [$this->_start]
            ];

        $q = new Queue();
        $q->push($this->_start);

        /** @var Points $item */
        while ($item = $q->pop()){
            /** @var Edges $edge */
            foreach ($item->allFromEdges as $edge){
                if (isset($this->_edges[$edge->id]))
                    continue;

                $this->_edges[$edge->id] = $edge;
                $this->_edgesArray[$edge->from_point_id][$edge->to_point_id] = $edge->value;

                if ($edge->toPoint->id != $this->_end->id)
                    $q->push($edge->toPoint);
                else
                    $this->is_normal = true;
            }
        }

        if (!$this->_edgesArray || !$this->is_normal)
            return [
                'error' => self::ERROR_MSG
            ];

        $this->init();

        if (!isset($this->used[$this->_end->id]))
            return [
                'error' => self::ERROR_MSG
            ];

        $this->sum[$this->_start->id] = 0;

        while ($current_node = $this->findMinUnusedNode()){
            $this->handleNode($current_node);
        }

        return [
            'sum' => $this->sum[$this->_end->id],
            'path' => $this->getPathArray()
        ];
    }

    function init(){
        foreach ($this->getNodes() as $node)
        {
            $this->used[$node] = false;
            $this->sum[$node] = INF;
            $this->path[$node] = "";
        }

        $end_node = $this->_end->id;

        $this->used[$end_node] = false;
        $this->sum[$end_node] = INF;
        $this->path[$end_node] = "";
    }

    function getNodes(){
        foreach ($this->_edgesArray as $node => $edges){
            yield $node;
        }
    }

    function findMinUnusedNode(){
        $result_node = "";

        foreach ($this->getNodes() as $node){
            if (!$this->used[$node])
                if ($result_node == "" || $this->sum[$node] < $this->sum[$result_node])
                    $result_node = $node;
        }

        return $result_node;
    }

    private function handleNode($current_node)
    {
        $this->used[$current_node] = true;

        if (!isset($this->_edgesArray[$current_node]))
            return;

        foreach ($this->_edgesArray[$current_node] as $node => $value){
            if (isset($this->used[$node]) && !$this->used[$node]){
                $new_sum = $this->sum[$current_node] + $value;

                if ($new_sum < $this->sum[$node]){
                    $this->sum[$node] = $new_sum;
                    $this->path[$node] = $current_node;
                }
            }
        }
    }

    private function getPathArray(){
        $node = $this->_end->id;
        $result[] = Points::findOne($node);

        while ($node){
            $node = $this->path[$node];
            if ($node != "") {
                $result[] = Points::findOne($node);
            }
        }

        $result = array_reverse($result);

        return $result;
    }
}
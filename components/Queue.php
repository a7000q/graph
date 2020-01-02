<?php

namespace app\components;


class Queue
{
    private $_q = [];
    private $index_push = 0;
    private $index_pop = 0;

    public function push($item){
        $this->_q[$this->index_push] = $item;
        $this->index_push++;
    }

    public function pop(){
        $result = false;

        if (isset($this->_q[$this->index_pop]))
            $result = $this->_q[$this->index_pop];

        if ($result){
            unset($this->_q[$this->index_pop]);
            $this->index_pop++;
            return $result;
        }

        return false;
    }
}
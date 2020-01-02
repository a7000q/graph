<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Edges".
 *
 * @property int $id
 * @property int|null $graph_id
 * @property int|null $from_point_id
 * @property int|null $to_point_id
 * @property int|null $value
 *
 * @property Points $fromPoint
 * @property Graphs $graph
 * @property Points $toPoint
 */
class Edges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Edges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['graph_id', 'from_point_id', 'to_point_id', 'value'], 'required'],
            [['from_point_id', 'to_point_id'], 'unique', 'targetAttribute' => ['from_point_id', 'to_point_id'], 'message' => 'Данные точки уже связаны!'],
            [['graph_id', 'from_point_id', 'to_point_id', 'value'], 'integer'],
            [['from_point_id'], 'exist', 'skipOnError' => true, 'targetClass' => Points::className(), 'targetAttribute' => ['from_point_id' => 'id']],
            [['graph_id'], 'exist', 'skipOnError' => true, 'targetClass' => Graphs::className(), 'targetAttribute' => ['graph_id' => 'id']],
            [['to_point_id'], 'exist', 'skipOnError' => true, 'targetClass' => Points::className(), 'targetAttribute' => ['to_point_id' => 'id']],
            [['graph_id'], function($attribute){
                if ($this->fromPoint && $this->graph_id != $this->fromPoint->graph_id)
                    $this->addError("from_point_id", "Вершина должны быть из заданного графа!");

                if ($this->toPoint && $this->graph_id != $this->toPoint->graph_id)
                    $this->addError("to_point_id", "Вершина должны быть из заданного графа!");
            }]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'graph_id' => 'Graph ID',
            'from_point_id' => 'From Point ID',
            'to_point_id' => 'To Point ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromPoint()
    {
        return $this->hasOne(Points::className(), ['id' => 'from_point_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGraph()
    {
        return $this->hasOne(Graphs::className(), ['id' => 'graph_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToPoint()
    {
        return $this->hasOne(Points::className(), ['id' => 'to_point_id']);
    }
}

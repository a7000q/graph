<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Points".
 *
 * @property int $id
 * @property int|null $graph_id
 * @property string|null $name
 *
 * @property Graphs $graph
 */
class Points extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Points';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['graph_id'], 'required'],
            [['graph_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['graph_id'], 'exist', 'skipOnError' => true, 'targetClass' => Graphs::className(), 'targetAttribute' => ['graph_id' => 'id']],
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
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGraph()
    {
        return $this->hasOne(Graphs::className(), ['id' => 'graph_id']);
    }

    public function getAllFromEdges(){
        return $this->hasMany(Edges::class, ['from_point_id' => 'id']);
    }

    public function getAllToEdges(){
        return $this->hasMany(Edges::class, ['to_point_id' => 'id']);
    }

    public function beforeDelete()
    {
        foreach ($this->allFromEdges as $allFromEdge)
            $allFromEdge->delete();

        foreach ($this->allToEdges as $allToEdge)
            $allToEdge->delete();

        return parent::beforeDelete();
    }
}

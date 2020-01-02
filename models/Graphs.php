<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Graphs".
 *
 * @property int $id
 * @property string|null $name
 */
class Graphs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Graphs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function extraFields()
    {
        return [
            'points',
            'edges'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getPoints()
    {
        return $this->hasMany(Points::class, ['graph_id' => 'id']);
    }

    public function getEdges()
    {
        return $this->hasMany(Edges::class, ['graph_id' => 'id']);
    }
}

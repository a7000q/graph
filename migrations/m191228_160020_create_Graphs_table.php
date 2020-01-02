<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Graphs}}`.
 */
class m191228_160020_create_Graphs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Graphs}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Graphs}}');
    }
}

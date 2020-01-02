<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Points}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%Graphs}}`
 */
class m191228_161423_create_Points_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Points}}', [
            'id' => $this->primaryKey(),
            'graph_id' => $this->integer(),
            'name' => $this->string(),
        ]);

        // creates index for column `graph_id`
        $this->createIndex(
            '{{%idx-Points-graph_id}}',
            '{{%Points}}',
            'graph_id'
        );

        // add foreign key for table `{{%Graphs}}`
        $this->addForeignKey(
            '{{%fk-Points-graph_id}}',
            '{{%Points}}',
            'graph_id',
            '{{%Graphs}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%Graphs}}`
        $this->dropForeignKey(
            '{{%fk-Points-graph_id}}',
            '{{%Points}}'
        );

        // drops index for column `graph_id`
        $this->dropIndex(
            '{{%idx-Points-graph_id}}',
            '{{%Points}}'
        );

        $this->dropTable('{{%Points}}');
    }
}

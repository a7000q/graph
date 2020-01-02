<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Edges}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%Graphs}}`
 * - `{{%Points}}`
 * - `{{%Points}}`
 */
class m191228_170916_create_Edges_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Edges}}', [
            'id' => $this->primaryKey(),
            'graph_id' => $this->integer(),
            'from_point_id' => $this->integer(),
            'to_point_id' => $this->integer(),
            'value' => $this->integer(),
        ]);

        // creates index for column `graph_id`
        $this->createIndex(
            '{{%idx-Edges-graph_id}}',
            '{{%Edges}}',
            'graph_id'
        );

        // add foreign key for table `{{%Graphs}}`
        $this->addForeignKey(
            '{{%fk-Edges-graph_id}}',
            '{{%Edges}}',
            'graph_id',
            '{{%Graphs}}',
            'id',
            'CASCADE'
        );

        // creates index for column `from_point_id`
        $this->createIndex(
            '{{%idx-Edges-from_point_id}}',
            '{{%Edges}}',
            'from_point_id'
        );

        // add foreign key for table `{{%Points}}`
        $this->addForeignKey(
            '{{%fk-Edges-from_point_id}}',
            '{{%Edges}}',
            'from_point_id',
            '{{%Points}}',
            'id',
            'CASCADE'
        );

        // creates index for column `to_point_id`
        $this->createIndex(
            '{{%idx-Edges-to_point_id}}',
            '{{%Edges}}',
            'to_point_id'
        );

        // add foreign key for table `{{%Points}}`
        $this->addForeignKey(
            '{{%fk-Edges-to_point_id}}',
            '{{%Edges}}',
            'to_point_id',
            '{{%Points}}',
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
            '{{%fk-Edges-graph_id}}',
            '{{%Edges}}'
        );

        // drops index for column `graph_id`
        $this->dropIndex(
            '{{%idx-Edges-graph_id}}',
            '{{%Edges}}'
        );

        // drops foreign key for table `{{%Points}}`
        $this->dropForeignKey(
            '{{%fk-Edges-from_point_id}}',
            '{{%Edges}}'
        );

        // drops index for column `from_point_id`
        $this->dropIndex(
            '{{%idx-Edges-from_point_id}}',
            '{{%Edges}}'
        );

        // drops foreign key for table `{{%Points}}`
        $this->dropForeignKey(
            '{{%fk-Edges-to_point_id}}',
            '{{%Edges}}'
        );

        // drops index for column `to_point_id`
        $this->dropIndex(
            '{{%idx-Edges-to_point_id}}',
            '{{%Edges}}'
        );

        $this->dropTable('{{%Edges}}');
    }
}

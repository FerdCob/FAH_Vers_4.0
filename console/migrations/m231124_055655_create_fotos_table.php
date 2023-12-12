<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fotos}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%arrendamiento}}`
 */
class m231124_055655_create_fotos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fotos}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'arrendamiento_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `arrendamiento_id`
        $this->createIndex(
            '{{%idx-fotos-arrendamiento_id}}',
            '{{%fotos}}',
            'arrendamiento_id'
        );

        // add foreign key for table `{{%arrendamiento}}`
        $this->addForeignKey(
            '{{%fk-fotos-arrendamiento_id}}',
            '{{%fotos}}',
            'arrendamiento_id',
            '{{%arrendamiento}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%arrendamiento}}`
        $this->dropForeignKey(
            '{{%fk-fotos-arrendamiento_id}}',
            '{{%fotos}}'
        );

        // drops index for column `arrendamiento_id`
        $this->dropIndex(
            '{{%idx-fotos-arrendamiento_id}}',
            '{{%fotos}}'
        );

        $this->dropTable('{{%fotos}}');
    }
}

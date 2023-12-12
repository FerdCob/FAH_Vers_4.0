<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%arrendamiento}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%categoria}}`
 * - `{{%user}}`
 */
class m231124_060055_create_arrendamiento_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%arrendamiento}}', [
            'id' => $this->primaryKey(),
            'titulo' => $this->string()->notNull(),
            'descripcion' => $this->text()->notNull(),
            'precio' => $this->decimal()->notNull(),
            'categoria_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `categoria_id`
        $this->createIndex(
            '{{%idx-arrendamiento-categoria_id}}',
            '{{%arrendamiento}}',
            'categoria_id'
        );

        // add foreign key for table `{{%categoria}}`
        $this->addForeignKey(
            '{{%fk-arrendamiento-categoria_id}}',
            '{{%arrendamiento}}',
            'categoria_id',
            '{{%categoria}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-arrendamiento-user_id}}',
            '{{%arrendamiento}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-arrendamiento-user_id}}',
            '{{%arrendamiento}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%categoria}}`
        $this->dropForeignKey(
            '{{%fk-arrendamiento-categoria_id}}',
            '{{%arrendamiento}}'
        );

        // drops index for column `categoria_id`
        $this->dropIndex(
            '{{%idx-arrendamiento-categoria_id}}',
            '{{%arrendamiento}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-arrendamiento-user_id}}',
            '{{%arrendamiento}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-arrendamiento-user_id}}',
            '{{%arrendamiento}}'
        );

        $this->dropTable('{{%arrendamiento}}');
    }
}

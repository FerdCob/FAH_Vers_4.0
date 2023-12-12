<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%servicios}}`.
 */
class m231124_060241_create_servicios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%servicios}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%servicios}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%servicios_arrendamientos}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%servicio}}`
 * - `{{%arrendamiento}}`
 */
class m231124_060827_create_servicios_arrendamientos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%servicios_arrendamientos}}', [
            'id' => $this->primaryKey(),
            'servicio_id' => $this->integer()->notNull(),
            'arrendamiento_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `servicio_id`
        $this->createIndex(
            '{{%idx-servicios_arrendamientos-servicio_id}}',
            '{{%servicios_arrendamientos}}',
            'servicio_id'
        );

        // add foreign key for table `{{%servicio}}`
        $this->addForeignKey(
            '{{%fk-servicios_arrendamientos-servicio_id}}',
            '{{%servicios_arrendamientos}}',
            'servicio_id',
            '{{%servicio}}',
            'id',
            'CASCADE'
        );

        // creates index for column `arrendamiento_id`
        $this->createIndex(
            '{{%idx-servicios_arrendamientos-arrendamiento_id}}',
            '{{%servicios_arrendamientos}}',
            'arrendamiento_id'
        );

        // add foreign key for table `{{%arrendamiento}}`
        $this->addForeignKey(
            '{{%fk-servicios_arrendamientos-arrendamiento_id}}',
            '{{%servicios_arrendamientos}}',
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
        // drops foreign key for table `{{%servicio}}`
        $this->dropForeignKey(
            '{{%fk-servicios_arrendamientos-servicio_id}}',
            '{{%servicios_arrendamientos}}'
        );

        // drops index for column `servicio_id`
        $this->dropIndex(
            '{{%idx-servicios_arrendamientos-servicio_id}}',
            '{{%servicios_arrendamientos}}'
        );

        // drops foreign key for table `{{%arrendamiento}}`
        $this->dropForeignKey(
            '{{%fk-servicios_arrendamientos-arrendamiento_id}}',
            '{{%servicios_arrendamientos}}'
        );

        // drops index for column `arrendamiento_id`
        $this->dropIndex(
            '{{%idx-servicios_arrendamientos-arrendamiento_id}}',
            '{{%servicios_arrendamientos}}'
        );

        $this->dropTable('{{%servicios_arrendamientos}}');
    }
}

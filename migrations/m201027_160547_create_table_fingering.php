<?php

use yii\db\Migration;

/**
 * Class m201027_160547_create_table_fingering
 */
class m201027_160547_create_table_fingering extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fingering}}', [
            'id' => $this->primaryKey(),
            'tone_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'tune' => $this->smallInteger()->null(),
            'frets' => $this->string(20)->null(),
            'fingers' => $this->string(20)->null(),
            'code' => $this->string(20)->null(),
            'sort' => $this->integer()->null(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%fingering}}');
    }
}

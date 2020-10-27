<?php

use yii\db\Migration;

/**
 * Class m201027_160533_create_table_tone
 */
class m201027_160533_create_table_tone extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tone}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%tone}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ill`.
 */
class m180804_224901_create_ill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ('mysql' == $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('ill', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название болезние'),
        ], $tableOptions);

        $this->createIndex('idx-name', 'ill', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ill');
    }
}

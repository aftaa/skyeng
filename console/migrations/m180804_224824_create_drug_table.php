<?php

use yii\db\Migration;

/**
 * Handles the creation of table `drug`.
 */
class m180804_224824_create_drug_table extends Migration
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

        $this->createTable('drug', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование лекарства'),
            'expiration_date' => $this->date()->notNull()->comment('Срок годности лек-ва'),
        ], $tableOptions);

        $this->createIndex('idx-name', 'drug', 'name');
        $this->createIndex('idx-name', 'drug', 'expiration_date');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('drug');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `drug_ill`.
 */
class m180805_105231_create_drug_ill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    const TABLE_NAME = 'drug_ill';

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'drug_id' => $this->integer()->notNull(),
            'ill_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-drug-ill', self::TABLE_NAME, ['drug_id', 'ill_id'], true);
        $this->addForeignKey('fk-drug', self::TABLE_NAME, 'drug_id', 'drug', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-ill', self::TABLE_NAME, 'ill_id', 'ill', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}

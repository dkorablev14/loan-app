<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%loan_application}}`.
 */
class m240921_090833_create_loan_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('loan_application', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'term' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(0), // Значение по умолчанию
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('loan_application');
    }
}

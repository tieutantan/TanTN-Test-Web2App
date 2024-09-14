<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m240914_000001_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
public function safeUp()
{
    $this->createTable('users', [
        'id' => $this->primaryKey(),
        'username' => $this->string()->notNull()->unique(),
        'full_name' => $this->string()->notNull(),
        'password_hash' => $this->string()->notNull(),
        'access_token' => $this->string()->unique(),
        'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
    ]);
}

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}

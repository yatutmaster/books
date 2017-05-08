<?php

use yii\db\Migration;

/**
 * Handles the creation of table `books`.
 * Has foreign keys to the tables:
 *
 * - `users`
 * - `history`
 */
class m170507_114156_create_books_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'access' => $this->integer()->defaultValue(0)
        ]);

     
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('books');
    }
}

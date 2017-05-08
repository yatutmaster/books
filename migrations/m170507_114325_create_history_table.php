<?php

use yii\db\Migration;

/**
 * Handles the creation of table `history`.
 * Has foreign keys to the tables:
 *
 * - `users`
 * - `users`
 * - `books`
 */
class m170507_114325_create_history_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('history', [
            'id' => $this->primaryKey(),  
			'id_book' => $this->integer()->notNull(),
            'id_owner' => $this->integer()->notNull(),
            'active_ver' => $this->integer()->defaultValue(1),
            'year' => $this->integer()->notNull(),
            'book_name' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'author' => $this->string()->notNull(),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

       
        // creates index for column `id_owner`
        $this->createIndex(
            'idx-history-id_owner',
            'history',
            'id_owner'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-history-id_owner',
            'history',
            'id_owner',
            'users',
            'id',
            'CASCADE'
        );

        // creates index for column `id_book`
        $this->createIndex(
            'idx-history-id_book',
            'history',
            'id_book'
        );

        // add foreign key for table `books`
        $this->addForeignKey(
            'fk-history-id_book',
            'history',
            'id_book',
            'books',
            'id',
            'CASCADE'
        );
		
		
		   // creates index for column `id_user`
        $this->createIndex(
            'idx-books-id_user',
            'books',
            'id_user'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-books-id_user',
            'books',
            'id_user',
            'users',
            'id',
            'CASCADE'
        );

      
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		  // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-books-id_user',
            'books'
        );

        // drops index for column `id_user`
        $this->dropIndex(
            'idx-books-id_user',
            'books'
        );

      
        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-history-id_owner',
            'history'
        );

        // drops index for column `id_owner`
        $this->dropIndex(
            'idx-history-id_owner',
            'history'
        );

        // drops foreign key for table `books`
        $this->dropForeignKey(
            'fk-history-id_book',
            'history'
        );

        // drops index for column `id_book`
        $this->dropIndex(
            'idx-history-id_book',
            'history'
        );

        $this->dropTable('history');
    }
}

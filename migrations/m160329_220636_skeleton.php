<?php

use yii\db\Migration;

class m160329_220636_skeleton extends Migration
{
    public function up()
    {
        $this->createTable('forum_category', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'title' => $this->string(),
        ]);

        $this->createTable('forum_post', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'parent_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'subject' => $this->string(),
            'content' => $this->text(),
            'views' => $this->integer(),
            'date' => $this->dateTime()
        ]);
    }

    public function down()
    {
        $this->dropTable('forum_category');
        $this->dropTable('forum_post');

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

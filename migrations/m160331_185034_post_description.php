<?php

use yii\db\Migration;

class m160331_185034_post_description extends Migration
{
    public function up()
    {
        $this->addColumn('forum_category', 'description', $this->text());
    }

    public function down()
    {
        $this->dropColumn('forum_category', 'description');
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

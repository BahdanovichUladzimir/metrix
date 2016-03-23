<?php

class m150408_075333_insert_messages_types extends CDbMigration
{
	public function up()
	{
        $this->execute("
          INSERT INTO `EmailMessagesTypes` (`name`, `label`) VALUES ('info', 'Info');
        ");
	}

	public function down()
	{
		echo "m150408_075333_insert_messages_types does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
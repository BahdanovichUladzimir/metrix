<?php

class m150620_113504_update_email_field_in_users_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `Users`
	            CHANGE COLUMN `email` `email` VARCHAR(128) NULL DEFAULT NULL AFTER `password`;
        ");
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `Users`
                CHANGE COLUMN `email` `email` VARCHAR(128) NOT NULL AFTER `password`;
		");
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
<?php

class m150828_210800_add_agreement_column_to_users_table extends CDbMigration
{
	public function up()
	{
		$this->execute(
            "ALTER TABLE `Users`
	          ADD COLUMN `agreement` ENUM('1','0') NOT NULL DEFAULT '0' COMMENT 'Agreement' AFTER `state`;"
        );
	}

	public function down()
	{
		$this->execute(
            "ALTER TABLE `Users`
	            DROP COLUMN `agreement`;"
        );
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
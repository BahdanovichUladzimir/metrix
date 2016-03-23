<?php

class m150527_212830_add extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `Lists`
	            ADD COLUMN `type` VARCHAR(50) NOT NULL DEFAULT 'single' COMMENT 'Type' AFTER `name`;
        ");
	}

	public function down()
	{
		$this->execute("
		    ALTER TABLE `Lists`
	            DROP COLUMN `type`;
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
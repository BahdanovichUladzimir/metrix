<?php

class m151013_214813_add_thumb_column_to_dealsLinks_table extends CDbMigration
{
	public function up()
	{
		$this->execute("
		ALTER TABLE `DealLinks`
			ADD COLUMN `thumb` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Thumb' AFTER `link`;
		");
	}

	public function down()
	{
		$this->execute("
		ALTER TABLE `DealLinks`
	      DROP COLUMN `thumb`;
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
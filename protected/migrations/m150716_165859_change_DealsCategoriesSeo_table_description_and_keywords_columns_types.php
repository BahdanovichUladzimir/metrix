<?php

class m150716_165859_change_DealsCategoriesSeo_table_description_and_keywords_columns_types extends CDbMigration
{
	public function up()
	{
		$this->execute("
		    ALTER TABLE `DealsCategoriesSeo`
                CHANGE COLUMN `description` `description` TEXT NOT NULL DEFAULT '' COMMENT 'Description' AFTER `h1`,
                CHANGE COLUMN `keywords` `keywords` TEXT NOT NULL DEFAULT '' COMMENT 'Keywords' AFTER `description`;
		");
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `DealsCategoriesSeo`
                CHANGE COLUMN `description` `description` VARCHAR(255) NOT NULL COMMENT 'Description' AFTER `h1`,
                CHANGE COLUMN `keywords` `keywords` VARCHAR(255) NOT NULL COMMENT 'Keywords' AFTER `description`;
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
<?php

class m150307_134702_add_url_segment_column_to_deals_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `Deals`
              ADD COLUMN `url_segment` VARCHAR(255) NULL DEFAULT '' COMMENT 'URL segment' AFTER `name`;
        ");
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `Deals`
              DROP COLUMN `url_segment`;
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
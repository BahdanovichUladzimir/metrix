<?php

class m150302_195437_add_url_segment_column_to_DealsCategories_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `DealsCategories`
	            ADD COLUMN `url_segment` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'URL segment' AFTER `name`;
        ");
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `DealsCategories`
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
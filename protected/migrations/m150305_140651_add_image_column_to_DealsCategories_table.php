<?php

class m150305_140651_add_image_column_to_DealsCategories_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
          ALTER TABLE `DealsCategories`
	        ADD COLUMN `image` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Image name' AFTER `status_id`;
        ");
	}

	public function down()
	{
		$this->execute("
		  ALTER TABLE `DealsCategories`
	        DROP COLUMN `image`;
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
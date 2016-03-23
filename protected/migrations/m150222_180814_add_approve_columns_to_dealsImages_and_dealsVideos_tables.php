<?php

class m150222_180814_add_approve_columns_to_dealsImages_and_dealsVideos_tables extends CDbMigration
{
	public function up()
	{
		$this->execute("
			ALTER TABLE `DealsImages`
				ADD COLUMN `approve` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Approve label' AFTER `deal_id`;
			ALTER TABLE `DealsVideos`
				ADD COLUMN `approve` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Approve label' AFTER `deal_id`;
		");
	}

	public function down()
	{
		$this->execute("
			ALTER TABLE `DealsImages`
				DROP COLUMN `approve`;
			ALTER TABLE `DealsVideos`
				DROP COLUMN `approve`;
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
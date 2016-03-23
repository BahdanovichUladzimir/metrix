<?php

class m150209_150944_create_table_dealsUnderground extends CDbMigration
{
	public function up()
	{
		$this->execute("
		CREATE TABLE `DealsUnderground` (
			`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`deal_id` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'Deal ID',
			`underground_id` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'Underground ID',
			PRIMARY KEY (`id`),
			CONSTRAINT `FK__Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
			CONSTRAINT `FK__Underground` FOREIGN KEY (`underground_id`) REFERENCES `Underground` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
		)
		COLLATE='utf8_general_ci'
		ENGINE=InnoDB;
		");
	}

	public function down()
	{
		$this->execute("DROP TABLE `DealsUnderground`;");
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
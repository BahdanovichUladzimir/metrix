<?php

class m150129_165511_add_columns_to_deals_params_table extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
		echo "m150129_165511_add_columns_to_deals_params_table does not support migration down.\n";
		return false;
	}*/


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("
			ALTER TABLE `DealsParams`
				ADD COLUMN `field_size` INT(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Field size' AFTER `type_id`,
				ADD COLUMN `field_size_min` INT(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Min field size' AFTER `field_size`,
				ADD COLUMN `required` INT(1) UNSIGNED NULL DEFAULT NULL COMMENT 'Required' AFTER `field_size_min`,
				ADD COLUMN `match` VARCHAR(255) NULL DEFAULT '' COMMENT 'Match' AFTER `required`,
				ADD COLUMN `range` VARCHAR(255) NULL DEFAULT '' COMMENT 'Range' AFTER `match`,
				ADD COLUMN `error_message` VARCHAR(255) NULL DEFAULT '' COMMENT 'Error message' AFTER `range`,
				ADD COLUMN `other_validator` TEXT NULL DEFAULT '' COMMENT 'Other validator' AFTER `error_message`,
				ADD COLUMN `default` VARCHAR(255) NULL DEFAULT '' COMMENT 'Default' AFTER `other_validator`,
				ADD COLUMN `position` INT(3) NULL DEFAULT NULL COMMENT 'Position' AFTER `default`,
				ADD COLUMN `visible` INT(1) NULL DEFAULT NULL COMMENT 'Visible' AFTER `position`,
				ADD COLUMN `widget` VARCHAR(255) NULL DEFAULT '' COMMENT 'Widget' AFTER `visible`,
				ADD COLUMN `widget_params` TEXT NULL DEFAULT '' COMMENT 'Widget params' AFTER `widget`;
		");
	}

	public function safeDown()
	{
		$this->execute("
		ALTER TABLE `DealsParams`
			DROP COLUMN `field_size`,
			DROP COLUMN `field_size_min`,
			DROP COLUMN `required`,
			DROP COLUMN `match`,
			DROP COLUMN `range`,
			DROP COLUMN `error_message`,
			DROP COLUMN `other_validator`,
			DROP COLUMN `default`,
			DROP COLUMN `position`,
			DROP COLUMN `visible`,
			DROP COLUMN `widget`,
			DROP COLUMN `widget_params`;
		");
	}

}
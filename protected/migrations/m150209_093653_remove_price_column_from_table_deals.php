<?php

class m150209_093653_remove_price_column_from_table_deals extends CDbMigration
{
	public function up()
	{
		$this->execute("
			ALTER TABLE `Deals` DROP COLUMN `price`;
		");
	}

	public function down()
	{
		$this->execute("ALTER TABLE `Deals` ADD COLUMN `price` INT(11) NOT NULL DEFAULT '0' COMMENT 'Price' AFTER `user_id`;");
	}
}
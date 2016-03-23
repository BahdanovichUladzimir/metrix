<?php

class m150521_175713_add_approve_column_to_dealLinks_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `DealLinks`
                ADD COLUMN `approve` INT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Approve' AFTER `deal_id`;
        ");
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `DealLinks`
                DROP COLUMN `approve`;
		");
	}
}
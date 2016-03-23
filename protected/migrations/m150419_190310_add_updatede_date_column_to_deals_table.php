<?php

class m150419_190310_add_updatede_date_column_to_deals_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `Deals`
                ADD COLUMN `updated_date` INT(12) UNSIGNED NULL DEFAULT NULL COMMENT 'Дата обновления' AFTER `created_date`;
                ");
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `Deals`
              DROP COLUMN `updated_date`;
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
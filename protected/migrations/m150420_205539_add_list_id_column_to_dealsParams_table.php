<?php

class m150420_205539_add_list_id_column_to_dealsParams_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `DealsParams`
                ADD COLUMN `list_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'List ID' AFTER `label`,
                ADD CONSTRAINT `FK_DealsParams_Lists` FOREIGN KEY (`list_id`) REFERENCES `Lists` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
        ");
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `DealsParams`
                DROP COLUMN `list_id`,
                DROP FOREIGN KEY `FK_DealsParams_Lists`;
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
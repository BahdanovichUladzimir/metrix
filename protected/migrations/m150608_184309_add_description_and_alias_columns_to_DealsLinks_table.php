<?php

class m150608_184309_add_description_and_alias_columns_to_DealsLinks_table extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `DealLinks`
                ADD COLUMN `alias` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Alias' AFTER `approve`,
                ADD COLUMN `description` TEXT NOT NULL DEFAULT '' COMMENT 'Description' AFTER `alias`;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `DealLinks`
                DROP COLUMN `alias`,
                DROP COLUMN `description`;
        ");
	}

}
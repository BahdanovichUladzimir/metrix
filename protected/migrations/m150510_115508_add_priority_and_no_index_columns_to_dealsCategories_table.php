<?php

class m150510_115508_add_priority_and_no_index_columns_to_dealsCategories_table extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
        ALTER TABLE `DealsCategories`
            ADD COLUMN `no_index` TINYINT(1) NULL DEFAULT '0' COMMENT 'No index' AFTER `image`,
            ADD COLUMN `priority` TINYINT(2) NULL DEFAULT NULL COMMENT 'Priority' AFTER `no_index`;
        ");
	}

	public function safeDown()
	{
        $this->execute("
        ALTER TABLE `DealsCategories`
            DROP COLUMN `no_index`,
            DROP COLUMN `priority`;
        ");
	}

}
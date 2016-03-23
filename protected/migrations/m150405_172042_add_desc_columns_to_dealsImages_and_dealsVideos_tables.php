<?php

class m150405_172042_add_desc_columns_to_dealsImages_and_dealsVideos_tables extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `DealsImages`
              ADD COLUMN `description` TEXT NULL DEFAULT '' COMMENT 'Description' AFTER `url`;
            ALTER TABLE `DealsVideos`
              ADD COLUMN `description` TEXT NULL DEFAULT '' COMMENT 'Description' AFTER `url`;

        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `DealsImages`
              DROP COLUMN `description`;
            ALTER TABLE `DealsVideos`
              DROP COLUMN `description`;
        ");
	}

}
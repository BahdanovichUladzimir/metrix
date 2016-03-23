<?php

class m150602_143040_add_alias_column_to_DealsImagesTable_and_DealsVideosTable extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `DealsImages`
                ADD COLUMN `alias` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Alias' AFTER `approve`;
            ALTER TABLE `DealsVideos`
                ADD COLUMN `alias` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Alias' AFTER `approve`;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `DealsImages`
                DROP COLUMN `alias`;
            ALTER TABLE `DealsVideos`
                DROP COLUMN `alias`;
        ");
	}

}
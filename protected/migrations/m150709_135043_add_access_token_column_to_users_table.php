<?php

class m150709_135043_add_access_token_column_to_users_table extends CDbMigration
{
	public function safeUp()
	{
        $this->execute("
          ALTER TABLE `Users` ADD COLUMN `access_token` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Access token' AFTER `provider`;
          ALTER TABLE `Users` ADD COLUMN `access_token_expires` INT(20) NULL DEFAULT NULL COMMENT 'Access token expires' AFTER `acess_token`;
          ");
	}

	public function safeDown()
	{
		$this->execute("
            ALTER TABLE `Users` DROP COLUMN `acess_token`;
            ALTER TABLE `Users` DROP COLUMN `access_token_expires`;
        ");
	}
}
<?php

class m150612_203444_add_loginza_columns_to_user_table extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Users`
                ADD COLUMN `identity` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Identity(Loginza)' AFTER `ballance`,
                ADD COLUMN `provider` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Provider(Loginza)' AFTER `identity`,
                ADD COLUMN `full_name` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Full name (Loginza)' AFTER `provider`,
                ADD COLUMN `state` TINYINT(1) NOT NULL COMMENT 'State(Loginza)' AFTER `full_name`;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Users`
                DROP COLUMN `identity`,
                DROP COLUMN `provider`,
                DROP COLUMN `full_name`,
                DROP COLUMN `state`;
        ");
	}

}
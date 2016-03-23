<?php

class m150512_180602_add_youtube_column_to_profile_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `Profiles`
                ADD COLUMN `youtube` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Youtube URL' AFTER `ok`;"
        );
	}

	public function down()
	{
		$this->execute("
            ALTER TABLE `Profiles`
                DROP COLUMN `youtube`;
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
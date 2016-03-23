<?php

class m150402_124325_add_noindex_and_seotitle_columns_to_cities_table extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Cities`
            ADD COLUMN `noindex` INT(1) UNSIGNED NULL DEFAULT '0' COMMENT 'No index' AFTER `latitude`,
            ADD COLUMN `seo_title` VARCHAR(50) NULL DEFAULT '' COMMENT 'SEO title' AFTER `noindex`;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Cities`
            DROP COLUMN `noindex`,
            DROP COLUMN `seo_title`;
        ");
	}

}
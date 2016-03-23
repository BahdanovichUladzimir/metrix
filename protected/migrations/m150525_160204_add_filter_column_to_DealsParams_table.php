<?php

class m150525_160204_add_filter_column_to_DealsParams_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `DealsParams`
              ADD COLUMN `filter` ENUM('1','0') NULL DEFAULT '0' COMMENT 'Filter' AFTER `list_id`;
		");

    }

	public function down()
	{
		$this->execute("
            ALTER TABLE `DealsParams`
	            DROP COLUMN `filter`;
		");
	}
}
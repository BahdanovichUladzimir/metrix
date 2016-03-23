<?php

class m150620_115040_update_fk_CommentsUsers_in_usersComments_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Comments`
                DROP FOREIGN KEY `FK_Comments_AppCategories`,
                DROP FOREIGN KEY `FK_Comments_Users`;
            ALTER TABLE `Comments`
                ADD CONSTRAINT `FK_Comments_AppCategories` FOREIGN KEY (`app_category_id`) REFERENCES `AppCategories` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
                ADD CONSTRAINT `FK_Comments_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
            ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Comments`
                DROP FOREIGN KEY `FK_Comments_AppCategories`,
                DROP FOREIGN KEY `FK_Comments_Users`;
            ALTER TABLE `Comments`
                ADD CONSTRAINT `FK_Comments_AppCategories` FOREIGN KEY (`app_category_id`) REFERENCES `AppCategories` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION,
                ADD CONSTRAINT `FK_Comments_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;
        ");
	}

}
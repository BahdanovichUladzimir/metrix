<?php

class m150620_120821_update_fk_DialoguesUsers_in_Dialogues_table extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Dialogues`
                DROP FOREIGN KEY `FK_Dialogues_Users`,
                DROP FOREIGN KEY `FK_Dialogues_Users_2`;
            ALTER TABLE `Dialogues`
                ADD CONSTRAINT `FK_Dialogues_Users` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
                ADD CONSTRAINT `FK_Dialogues_Users_2` FOREIGN KEY (`receiver_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Dialogues`
                DROP FOREIGN KEY `FK_Dialogues_Users`,
                DROP FOREIGN KEY `FK_Dialogues_Users_2`;
            ALTER TABLE `Dialogues`
                ADD CONSTRAINT `FK_Dialogues_Users` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION,
                ADD CONSTRAINT `FK_Dialogues_Users_2` FOREIGN KEY (`receiver_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;
        ");
	}

}
<?php

class m151023_225015_add_events_module_config_params extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('EVENTS_MODULE.VODKA_BOTTLE_VOLUME', '0.5', '0.5', 'Vodka bottle volume', 'integer');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('EVENTS_MODULE.WINE_BOTTLE_VOLUME', '0.7', '0.7', 'Wine bottle volume', 'integer');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('EVENTS_MODULE.CHAMPAGNE_BOTTLE_VOLUME', '0.7', '0.7', 'Champagne bottle volume', 'integer');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('EVENTS_MODULE.VODKA_BOTTLE_PRICE', '300', '300', 'Vodka bottle min price', 'integer');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('EVENTS_MODULE.WINE_BOTTLE_PRICE', '400', '400', 'Wine bottle min price', 'integer');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('EVENTS_MODULE.CHAMPAGNE_BOTTLE_PRICE', '300', '300', 'Champagne min price', 'integer');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('EVENTS_MODULE.CONSUMPTION_RATE', '1', '1', 'Consumption rate', 'integer');
		");
	}

	public function safeDown()
	{
        $this->execute("
        DELETE FROM `Config` WHERE `param`='EVENTS_MODULE.VODKA_BOTTLE_VOLUME';
        DELETE FROM `Config` WHERE `param`='EVENTS_MODULE.WINE_BOTTLE_VOLUME';
        DELETE FROM `Config` WHERE `param`='EVENTS_MODULE.CHAMPAGNE_BOTTLE_VOLUME';
        DELETE FROM `Config` WHERE `param`='EVENTS_MODULE.VODKA_BOTTLE_PRICE';
        DELETE FROM `Config` WHERE `param`='EVENTS_MODULE.WINE_BOTTLE_PRICE';
        DELETE FROM `Config` WHERE `param`='EVENTS_MODULE.CHAMPAGNE_BOTTLE_PRICE';
        DELETE FROM `Config` WHERE `param`='EVENTS_MODULE.CONSUMPTION_RATE';
        ");
	}

}
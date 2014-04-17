<?php
$installer = $this;
$installer->startSetup();
$installer->run ("
		DROP TABLE IF EXISTS `{$this->getTable('points/points')}`;
         CREATE TABLE `{$this->getTable('points/points')}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `balance` int(11) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`)           
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
$installer->endSetup();
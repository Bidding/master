<?php
$installer = $this;
$installer->startSetup();
$installer->run ("
		DROP TABLE IF EXISTS `{$this->getTable('points/log')}`;
         CREATE TABLE `{$this->getTable('points/log')}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `session_id` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)           
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
$installer->endSetup();
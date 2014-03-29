<?php
$installer = $this;
$installer->startSetup();
$installer->run ("
		DROP TABLE IF EXISTS `{$this->getTable('points/history')}`;
         CREATE TABLE `{$this->getTable('points/history')}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `order_number` varchar(100) NOT NULL,
            `balance` int(11) NOT NULL,
            `date` timestamp NOT NULL,
            PRIMARY KEY (`id`)           
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
$installer->endSetup();
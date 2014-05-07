<?php
$installer = $this;
$installer->startSetup();
$installer->run("
		DROP TABLE IF EXISTS `{$this->getTable('points/winner')}`;
         CREATE TABLE `{$this->getTable('points/winner')}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `product_id` int(11) NOT NULL,
            `win_date` timestamp NOT NULL,
            `bought` int(1) NOT NULL,
            PRIMARY KEY (`id`)           
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8
");
$installer->endSetup();
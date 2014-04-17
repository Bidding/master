<?php
$installer = $this;
$installer->startSetup();
$installer->run("
		DROP TABLE IF EXISTS `{$this->getTable('points/bid')}`;
         CREATE TABLE `{$this->getTable('points/bid')}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `product_id` int(11) NOT NULL,
            `price` int(11) NOT NULL,
            `new_price` int(11) NOT NULL,
            `bid_date` timestamp NOT NULL,
            PRIMARY KEY (`id`)           
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8
");
$installer->endSetup();
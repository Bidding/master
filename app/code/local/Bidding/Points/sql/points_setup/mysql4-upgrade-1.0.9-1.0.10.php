<?php
$installer = $this;
$installer->startSetup();
$installer->run ("
		ALTER TABLE `{$this->getTable('points/winner')}`
         ADD product_name varchar(900) AFTER product_id,
         ADD product_sku varchar(900) AFTER product_id,
         ADD customer_name varchar(900) AFTER product_id
		");
$installer->endSetup();
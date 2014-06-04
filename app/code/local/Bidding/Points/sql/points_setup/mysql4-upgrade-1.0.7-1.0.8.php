<?php
$installer = $this;
$installer->startSetup();
$installer->run ("
		ALTER TABLE `{$this->getTable('points/history')}`
         ADD order_id varchar(100) AFTER order_number
		");
$installer->endSetup();
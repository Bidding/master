<?php
class Bidding_Store_Block_Product extends Mage_Core_Block_Template
{
	public function getProducts()
	{
		$currentTimestamp = Mage::getModel('core/date')->timestamp(time());
		$date = date('Y-m-d H:i:s', $currentTimestamp);
		$products = Mage::getModel('catalog/product')->getCollection()
					->addAttributeToSelect('*')
					->addAttributeToFilter('can_bid', array('eq' => 1))
					->addAttributeToFilter('start_bidding_date', array('lteq' => $date))
					->addAttributeToFilter('end_bidding_date', array('gteq' => $date));
		return $products;
	}
}
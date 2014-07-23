<?php
class Bidding_Store_Block_Bidding_Next extends Mage_Core_Block_Template
{
	
	public function getNextBidding()
	{
		$currentTimestamp = Mage::getModel('core/date')->timestamp(time());
		$date = date('Y-m-d H:i:s', $currentTimestamp);
		$products = Mage::getModel('catalog/product')->getCollection()
					->addAttributeToSelect('*')
					->addAttributeToFilter('can_bid', array('eq' => 1))
					->addAttributeToFilter('status', array('eq' => 1))
					->addAttributeToFilter('start_bidding_date', array('gt' => $date));
		$products->getSelect()->limit(3);
		return $products;
	}

}
<?php
class Bidding_Store_Block_Bidding_Closed extends Mage_Core_Block_Template
{
	public function getClosedBidding()
	{
		$currentTimestamp = Mage::getModel('core/date')->timestamp(time());
		$date = date('Y-m-d H:i:s', $currentTimestamp);

		$products = Mage::getModel('catalog/product')->getCollection()
		->addAttributeToSelect('*')
		->addAttributeToFilter('can_bid', array('eq' => 1))
		->addAttributeToFilter('status', array('eq' => 1))
		->addAttributeToFilter('end_bidding_date', array('lt' => $date));
		
		return $products;
	}
	
	public function getCurrentBidder($productId)
	{
		$customerSession = $this->getCustomerSession();
		$currentBidder = Mage::getModel('points/bid')->getCollection()
			->addFieldToSelect(array('customer_id','price','new_price'))
			->addFieldToFilter('product_id', array('eq' => $productId));
		$currentBidder->getSelect()->order('id desc');
		$currentBidder->getSelect()->limit(1);
		return $currentBidder->getData();
	}

}
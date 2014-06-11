<?php
class Bidding_Store_Block_Bidding_History extends Mage_Core_Block_Template
{
	protected function _getCustomerSession()
	{
		$session = Mage::getSingleton('customer/session');
		return $session;
	}

	public function getBiddingProducts()
	{
		$customer = $this->_getCustomerSession();
		$products_history = Mage::getModel('points/bid')->getCollection()
		->addFieldToFilter('customer_id', array('eq' => $customer->getCustomer()->getId()));
		$products_history->getSelect()->group('product_id');
		return $products_history;
	}
}
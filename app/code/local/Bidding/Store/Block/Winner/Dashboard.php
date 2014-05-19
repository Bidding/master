<?php
class Bidding_Store_Block_Winner_Dashboard extends Mage_Catalog_Block_Product_Abstract
{
	protected function _getCustomerSession()
	{
		$session = Mage::getSingleton('customer/session');
		return $session;
	}
	
	public function getWinProducts()
	{
		$customer_session = $this->_getCustomerSession();
		$products = Mage::getModel('points/winner')->getCollection()
					->addFieldToFilter('customer_id', array('eq' => $customer_session->getCustomer()->getId()));
		return $products;
	}
	
}
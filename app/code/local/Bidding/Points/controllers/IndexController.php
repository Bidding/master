<?php
class Bidding_Points_IndexController extends Mage_Core_Controller_Front_Action
{
	protected function _getCustomerSession()
	{
		$customer = Mage::getSingleton('customer/session');
		return $customer;
	}
	
	public function indexAction()
	{
		$session = $this->_getCustomerSession();
		if ($session->isLoggedIn())
		{
			echo 'Yes';
		}
		else
		{
			$this->_redirect('customer/account/login');
		}
	}
	
	public function addAction()
	{
		echo $this->getRequest()->getParam('id');die;
	}
}
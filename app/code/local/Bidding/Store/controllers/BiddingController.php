<?php
class Bidding_Store_BiddingController extends Mage_Core_Controller_Front_Action
{
	protected function _getCustomerSession()
	{
		$session = Mage::getSingleton('customer/session');
		return $session;
	}

	public function indexAction()
	{
		if ($this->_getCustomerSession()->isLoggedIn())
		{
			$this->loadLayout();
			$this->renderLayout();
		}
		else
		{
			$this->_redirect('customer/account/login');
		}
	}

	public function previewAction()
	{
		if ($this->_getCustomerSession()->isLoggedIn())
		{
			if ($this->getRequest()->getParam('id'))
			{
			$this->loadLayout();
			$this->renderLayout();
			}
			else
			{
				$this->_redirect('bidding/bidding');
			}
		}
		else
		{
			$this->_redirect('customer/account/login');
		}
	}
}
?>
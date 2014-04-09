<?php
class Bidding_Store_IndexController extends Mage_Core_Controller_Front_Action
{
	protected function _getCustomerSession()
	{
		$session = Mage::getSingleton('customer/session');
		return $session;
	}
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function bidPostAction()
	{
		$customerSession = $this->_getCustomerSession();
		if ($customerSession->isLoggedIn())
		{
		$data = $this->getRequest()->getParams();
		echo json_encode($data);
		}
		else
		{
			return false;
		}
	}
	
}
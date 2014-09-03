<?php 
class Bidding_Store_Block_Adminhtml_Customer_Edit_Points extends Mage_Core_Block_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('bidding/points.phtml');
	}
	
	public function getCustomerBalance()
	{
		$customer_id = $this->getRequest()->getParam('id');
		$pointsModel = Mage::getModel('points/points')->load($customer_id, 'customer_id');
		$balance = $pointsModel->getBalance() ? $pointsModel->getBalance() : 0;
		return $balance;
	}
}
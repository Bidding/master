<?php
class Bidding_Store_Block_Bidding_Preview extends Mage_Core_Block_Template
{

	public function __construct()
	{	
		parent::__construct();
		$customer = $this->_getCustomerSession();
		$collection =Mage::getModel('points/bid')->getCollection()
		->addFieldToFilter('customer_id', array('eq' => $customer->getCustomer()->getId()))
		->addFieldToFilter('product_id', array('eq' => $this->getRequest()->getParam('id')));
		$this->setCollection($collection);
	}

	protected function _getCustomerSession()
	{
		$session = Mage::getSingleton('customer/session');
		return $session;
	}

	protected function _prepareLayout()
	{
		parent::_prepareLayout();

		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		$pager->setAvailableLimit(array(20=>20,40=>40,60=>60,'all'=>'all'));
		$pager->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		$this->getCollection()->load();
		return $this;
	}

	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}

}
<?php
class Bidding_Points_Block_Dashboard extends Mage_Core_Block_Template
{
	public function getPoints()
	{
		$pointsModel = Mage::getModel('points/points')->load(Mage::getSingleton('customer/session')->getCustomerId(),'customer_id');
		return $pointsModel;
	}
	
	public function getPointsHistory()
	{
		$pointsHistory = Mage::getModel('points/history')->getCollection()
						->addFieldToFilter('customer_id', array('eq' => Mage::getSingleton('customer/session')->getCustomerId()))
						->setOrder('date', 'desc');
		return $pointsHistory;
	}
	
	protected function _prepareLayout()
	{
		parent::_prepareLayout();
	
		$pager = $this->getLayout()->createBlock('page/html_pager', 'points.history.pager')
		->setCollection($this->getPointsHistory());
		$this->setChild('pager', $pager);
		$this->getPointsHistory()->load();
		return $this;
	}
	
	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
	
	public function getViewUrl($order)
	{
		return $this->getUrl('*/*/view', array('order_id' => $order->getOrderId()));
	}
}
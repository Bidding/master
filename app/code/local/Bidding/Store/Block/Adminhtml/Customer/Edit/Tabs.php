<?php
class Bidding_Store_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Customer_Edit_Tabs
{
	protected function _beforeToHtml()
	{
		$this->addTabAfter('product', array(
				'label'     => Mage::helper('customer')->__('Points History'),
				'title'		=> Mage::helper('customer')->__('Points History'),
				'content'   => $this->getLayout()->createBlock('store/adminhtml_customer_edit_listing')->toHtml(),
		),'points_history');
		
		$this->addTabAfter('points_history', array(
				'label'     => Mage::helper('customer')->__('Points Managment'),
				'title'		=> Mage::helper('customer')->__('Points History'),
				'content'   => $this->getLayout()->createBlock('store/adminhtml_customer_edit_points')->toHtml(),
		),'points');
		
		parent::_beforeToHtml();
	}
}
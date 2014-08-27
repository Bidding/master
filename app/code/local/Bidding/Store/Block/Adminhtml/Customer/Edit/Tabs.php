<?php
class Bidding_Store_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Customer_Edit_Tabs
{
	protected function _beforeToHtml()
	{
		$this->addTabAfter('product', array(
				'label'     => Mage::helper('customer')->__('Customer Points History'),
				'title'		=> Mage::helper('customer')->__('Customer Points History'),
				'content'   => $this->getLayout()->createBlock('store/adminhtml_customer_edit_listing')->toHtml(),
		),'tags');
		parent::_beforeToHtml();
	}
}
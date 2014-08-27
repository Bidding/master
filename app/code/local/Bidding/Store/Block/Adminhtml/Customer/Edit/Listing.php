<?php 
class Bidding_Store_Block_Adminhtml_Customer_Edit_Listing extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		Mage::getSingleton('admin/session')->setCustomerId($this->getRequest()->getParam('id'));
		$this->_controller = 'adminhtml_customer_edit_listing';
		$this->_blockGroup = 'store';
		$this->_headerText = Mage::helper('customer')->__('Customer Points History');
		parent::__construct();
		$this->_removeButton('add');
	}
	
	public function getGridHtml()
	{
		return $this->getChildHtml('grid');
	}
	
	public function remove()
	{
		return true;
	}
}
?>
<?php
class Bidding_Store_Block_Adminhtml_Store extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct() {
		$this->_controller = 'adminhtml_store';
		$this->_blockGroup = 'store';
		$this->_headerText = Mage::helper('store')->__('Bidding Winner');
		parent::__construct();
		$this->removeButton('add');
		//$this->setTemplate('bidding/store/container.phtml');
	}

	public function getGridHtml()
	{
		return $this->getChildHtml('grid');
	}
}
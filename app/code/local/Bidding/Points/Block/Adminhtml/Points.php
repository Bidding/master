<?php
class Bidding_Points_Block_Adminhtml_Points extends Mage_Adminhtml_Block_Widget_Grid_Container {
	
	public function __construct() {
		$this->_blockGroup = 'points';
		$this->_controller = 'adminhtml_points';
		$this->_headerText = $this->__('Points Managment');
		
		parent::__construct();
		$this->_removeButton('add');
	} 
}
<?php
class Bidding_Points_Model_Mysql4_Winner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('points/winner');
	}
}
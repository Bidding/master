<?php
class Bidding_Points_Model_Mysql4_Bid extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('points/bid', 'id');
	}
}
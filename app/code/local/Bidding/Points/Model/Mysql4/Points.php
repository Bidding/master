<?php
class Bidding_Points_Model_Mysql4_Points extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('points/points', 'id');
	}
}
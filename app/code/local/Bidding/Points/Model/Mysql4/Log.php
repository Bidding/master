<?php
class Bidding_Points_Model_Mysql4_Log extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('points/log', 'id');
	}
}
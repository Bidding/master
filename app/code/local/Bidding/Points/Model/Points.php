<?php
class Bidding_Points_Model_Points extends Mage_Core_Model_Abstract
{
	public function __construct()
	{
		parent::__construct();
		$this->_init('points/points');
	}
}
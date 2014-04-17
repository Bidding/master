<?php 
class Bidding_Store_Model_Cron extends Mage_Core_Model_Abstract
{
	public function checkWinner()
	{
		Mage::log("Cron is Running!");
	}
}
?>
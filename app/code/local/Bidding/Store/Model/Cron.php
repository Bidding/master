<?php 
class Bidding_Store_Model_Cron extends Mage_Core_Model_Abstract
{
	public function checkWinner()
	{
		$date = date('Y-m-d H:i:s');
		$products = Mage::getModel('catalog/product')->getCollection()
			->addFieldToFilter('end_bidding_date', array('lt' => $date));
		foreach ($products as $product)
		{
			Mage::log($product->getId());
			if ($product->getId())
			{
				$winnerCheck = Mage::getModel('points/winner')->load($product->getId(), 'product_id');
				if (!$winnerCheck->getId())
				{
				$winner = Mage::getModel('points/winner');
				$winner->setCustomerId(1);
				$winner->setProductId($product->getId());
				$winner->setWinDate(date('Y-m-d H:i:s'));
				$winner->setBought(0);
				$winner->save();
				}
			}
		}
	}
}
<?php 
class Bidding_Points_Model_Observer
{
	public function setPoints($observer)
	{
		$order = $observer->getEvent()->getOrder();
		$buyer_id = Mage::getSingleton('customer/session')->getId();
		$items = $order->getAllItems();
		foreach ($items as $item):
			$pointsModel = Mage::getModel('points/points');
			$historyModel = Mage::getModel('points/history');
			$pointsModel->setCustomerId($buyer_id);
			$pointsModel->setBalance(100);
			$pointsModel->save();
			$historyModel->setCustomerId($buyer_id);
			$historyModel->setOrderNumber($order->getIncrementId());
			$historyModel->setBalance(100);
			$historyModel->setDate($order->getDate());
			$historyModel->save();
		endforeach;
	}
}
?>
<?php 
class Bidding_Points_Model_Observer
{
	public function setPoints($observer)
	{
		$order = $observer->getEvent()->getOrder();
		$buyer_id = Mage::getSingleton('customer/session')->getId();
		$items = $order->getAllItems();
		foreach ($items as $item):

		//Load Product
		$_product = Mage::getModel('catalog/product')->load($item->getProductId());

		//Load Model
		$pointsModel = Mage::getModel('points/points')->load($buyer_id, 'customer_id');
		$historyModel = Mage::getModel('points/history');

		// Set Points in Entity Table
		$pointsModel->setCustomerId($buyer_id);
		$pointsModel->setBalance($pointsModel->getBalance() + $_product->getPoints());
		$pointsModel->save();

		// Set History in History Table
		$historyModel->setCustomerId($buyer_id);
		$historyModel->setOrderNumber($order->getIncrementId());
		$historyModel->setOrderId($order->getId());
		$historyModel->setBalance($_product->getPoints());
		$historyModel->setDate($order->getDate());
		$historyModel->save();

		endforeach;
	}

	public function setBought($observer)
	{
		$_order = $observer->getEvent()->getOrderIds();
		$order = Mage::getModel('sales/order')->load($_order[0]);
		$items = $order->getAllItems();
		foreach ($items as $item)
		{
			$win_product = Mage::getModel('points/winner')->load($item->getProductId(), 'product_id');
			if ($win_product)
			{
				$win_product->setBought(1);
				$win_product->save();
			}
		}
	}
}
?>
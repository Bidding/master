<?php 
class Bidding_Points_Model_Observer
{
	public function setPoints($observer)
	{
		$order = $observer->getEvent()->getOrder();
		$buyer_id = Mage::getSingleton('customer/session')->getId();
		$quote = Mage::getSingleton('checkout/session')->getQuote();
		$items = $quote->getAllVisibleItems();
		echo '<pre>';
		print_r(get_class_methods($items));
		die;
	}
}
?>
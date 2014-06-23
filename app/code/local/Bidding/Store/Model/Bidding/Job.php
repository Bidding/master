<?php
require_once 'lib/ElephantIO/Client.php';
use ElephantIO\Client as ElephantIOClient;

class Bidding_Store_Model_Bidding_Job extends Jowens_JobQueue_Model_Job_Abstract
{
	public function __construct($name, $customer_id, $product_id) {
		$this->customer_id = $customer_id;
		$this->product_id = $product_id;
	}
	
	public function perform()
	{
		$points = Mage::getModel('points/points')->load($this->customer_id, 'customer_id');
		$bidHistory = Mage::getModel('points/bid');

		$_product = Mage::getModel('catalog/product')->load($this->product_id);
		$new_price = $_product->getCurrentPrice() + $_product->getCpc();

		$bidHistory->setCustomerId($this->customer_id);
		$bidHistory->setProductId($this->product_id);

		$check_uniq_bid = Mage::getModel('points/bid')->getCollection()
		->addFieldToFilter('product_id', array('eq' => $this->product_id))
		->setOrder('new_price', 'DESC')
		->setPageSize(1);
		$check_uniq_bid = $check_uniq_bid->getData();

		$bidHistory->setPrice($_product->getCurrentPrice());
		$bidHistory->setNewPrice($new_price);
		$bidHistory->setBidDate(date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));
		$bidHistory->save();

		$_product->setCurrentPrice($new_price);
		$_product->save();

		$points->setBalance($points->getBalance() - 1 );
		$points->save();
		
	}
}
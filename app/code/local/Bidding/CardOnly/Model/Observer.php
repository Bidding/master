<?php

class Bidding_CardOnly_Model_Observer
{
	public function cardOnly(Varien_Event_Observer $observer)
	{
		$event           = $observer->getEvent();
		$method          = $event->getMethodInstance();
		$result          = $event->getResult();
		$cardonly        = false;

		foreach (Mage::getSingleton('checkout/cart')->getQuote()->getAllVisibleItems() as $item)
		{
			if($item->getProduct()->getCardOnly()){
				$cardonly = true;
			}
		}

		if($method->getCode() == "phoenix_cashondelivery" && $cardonly){
			$result->isAvailable = false;
		}

	}

	public function logCartAdd($observer)
	{
		//$product = $observer->getEvent()->getProduct();
		//$_product = Mage::getModel('catalog/product')->load($product->getId());
		//$params['qty'] = 1;
		//print_r($event->getName());die;
		//$item = $event->getQuoteItem();
		//$product = $item->getProduct();
		//$quote = $item->getQuote();


		/*
		 $params['qty'] = 1;
		 $quoteItem = $observer->getEvent()->getQuoteItem();
		 $quote_item_id = $quoteItem->getItemId();
		 $product = Mage::getModel('catalog/product')->load($quote_item_id);
		 //$product = $this->_initProduct($_product); // here initialize the product
		 */
		//$cart = Mage::getModel('checkout/cart');
		//$cart->truncate(); // remove all active items in cart page
		//$cart->init();
		//$cart->addProduct($_product,$params);
		//$cart->save();
	}
}
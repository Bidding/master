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
		/*
		$cart = Mage::getModel('checkout/cart');
		$cart->truncate(); // remove all active items in cart page
		$cart->init();
		
		$product = $observer->getEvent()->getProduct();
		//echo $product->getName();die;
		$_product = Mage::getModel('catalog/product')
					->setStoreId(Mage::app()->getStore()->getId())
					->load($product->getId());
		$params['qty'] = 1;

		
		//$cart->addProduct($_product, $params);
		//$cart->save();
		 * 
		 */
	}
}
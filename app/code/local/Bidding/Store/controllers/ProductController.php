<?php 
date_default_timezone_set('Asia/Amman');
class Bidding_Store_ProductController extends Mage_Core_Controller_Front_Action
{
	public function viewAction()
	{
		if ($this->getRequest()->getParam('id'))
		{
		$_product = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('id'));
		
			if ($_product->getId() && $_product->getCanBid() == 1 && $_product->getEndBiddingDate() >= date('Y-m-d H:i:s'))
			{
				$this->loadLayout();
				$this->renderLayout();
			}
			else
			{
				$this->_redirect('/');
			}
		}
		else
		{
			$this->_redirect('/');
		}
	}
}
?>
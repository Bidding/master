<?php
class Bidding_Store_IndexController extends Mage_Core_Controller_Front_Action
{
	protected function _getCustomerSession()
	{
		$session = Mage::getSingleton('customer/session');
		return $session;
	}
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function bidPostAction()
	{
		$customerSession = $this->_getCustomerSession();
		if ($customerSession->isLoggedIn())
		{
			$data = $this->getRequest()->getParams();
			$points = Mage::getModel('points/points')->load($customerSession->getCustomerId());
			$bidHistory = Mage::getModel('points/bid');
			if ($points->getBalance() >= 10)
			{
				$_product = Mage::getModel('catalog/product')->load($data['productId']);
				$newPrice = $_product->getCurrentPrice() + $_product->getCpc();
				if ($newPrice < $_product->getPrice())
				{
					$bidHistory->setCustomerId($customerSession->getCustomerId());
					$bidHistory->setProductId($data['productId']);
					$bidHistory->setPrice($_product->getCurrentPrice());
					$bidHistory->setNewPrice($newPrice);
					$bidHistory->setBidDate(date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));
					$bidHistory->save();
					$_product->setCurrentPrice($newPrice);
					$_product->save();
					$points->setBalance($points->getBalance() - 1 );
					$points->save();
					$data = array('action' => 'true','PI' => $_product->getId(), 'price'=> Mage::helper('core')->currency($_product->getCurrentPrice()), 'bidder'=> $customerSession->getCustomer()->getName(), 'bidderTable' => "<tr><td>".Mage::helper('core')->currency($_product->getCurrentPrice())."</td><td>".$customerSession->getCustomer()->getName()."</td></tr>");
					echo json_encode($data);
				}
				else
				{
					echo "can't bid";
				}
			}
			else
			{
				$session = Mage::getModel('core/session');
				$session->addError($this->__("You don't have enough points"));
				$data = array('action' => 'false');
				echo json_encode($data);
			}
		}
		else
		{
			echo "";
		}
	}
	
}
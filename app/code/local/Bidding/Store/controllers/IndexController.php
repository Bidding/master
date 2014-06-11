<?php
date_default_timezone_set('Asia/Amman');
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

	public function winnerAction()
	{
		$customer_session = $this->_getCustomerSession();
		if ($customer_session->isLoggedin())
		{
			$this->loadLayout();
			$this->renderLayout();
		}
		else
		{
			$this->_redirect('customer/account/login');
		}
	}

	public function bidPostAction()
	{
		$customerSession = $this->_getCustomerSession();
		if ($customerSession->isLoggedIn())
		{
			$data = $this->getRequest()->getParams();
			if ($data)
			{
				$points = Mage::getModel('points/points')->load($customerSession->getCustomerId(), 'customer_id');
				$bidHistory = Mage::getModel('points/bid');
				if ($points->getBalance() != 0)
				{
					$_product = Mage::getModel('catalog/product')->load($data['productId']);
					$newPrice = $_product->getCurrentPrice() + $_product->getCpc();
					if (!$this->getTotalBid($customerSession->getCustomerId(), $data['productId']) && $this->getDiffTime($_product->getEndBiddingDate()))
					{
						$session = Mage::getModel('core/session');
						$session->addError($this->__("You can enter on this bidding becuase this is your first time and bidding will end in less than 10 minites"));
						$data = array('action' => 'false');
						echo json_encode($data);
					}
					else
					{
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
							if ($points->getBalance() <= 10)
							{
								$session = Mage::getModel('core/session');
								$session->addError($this->__("Your credit will end soon"));
								$data = array_merge($data, array('reload' => 'true'));
							}
							echo json_encode($data);
						}
						else
						{
							$_product->setEndBiddingDate(date('Y-m-d H:i:s',strtotime("-1 days")));
							$_product->save();
							$session = Mage::getModel('core/session');
							$session->addError($this->__("This product has been closed"));
							$data = array('action' => 'false');
							echo json_encode($data);
						}
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
				echo 'Not allowded';
			}
		}
		else
		{
			echo "";
		}
	}

	protected function getTotalBid($bidder_id, $product_id)
	{
		$count = Mage::getModel('points/bid')->getCollection()
		->addFieldToFilter('customer_id', array('eq' => $bidder_id))
		->addFieldToFilter('product_id', array('eq' => $product_id));
		return $count->count();
	}

	protected function getDiffTime($endtime)
	{
		$datetime1 = time();
		$datetime2 = strtotime($endtime);
		$interval  = abs($datetime2 - $datetime1);
		$minutes   = round($interval / 60);
		if ( $minutes <= 10 )
		return true;
		else
		return false;
	}

}
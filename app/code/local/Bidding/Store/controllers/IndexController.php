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
			$request = $this->getRequest()->isPost();
			if ($request && $data['form_key'] == Mage::getSingleton('core/session')->getFormKey())
			{
				$points = Mage::getModel('points/points')->load($customerSession->getCustomerId(), 'customer_id');
				//$bidHistory = Mage::getModel('points/bid');
				if ($points->getBalance() != 0)
				{
					$_product = Mage::getModel('catalog/product')->load($data['productId']);
					//$newPrice = $_product->getCurrentPrice() + $_product->getCpc();

					if (!$this->getTotalBid($customerSession->getCustomerId(), $data['productId']) && $this->getDiffTime($_product->getEndBiddingDate()))
					{
						$session = Mage::getModel('core/session');
						$session->addError($this->__("You can't enter on this bidding becuase this is your first time and bidding will end in less than 10 minites"));
						$data = array('action' => 'false');
						echo "";
					}
					else
					{
						//if ($newPrice < $_product->getPrice())
						//{
						$bid_result = $this->setCustomerBid($customerSession->getCustomerId(), $data['productId'], $customerSession->getCustomer()->getName());
						if (!$bid_result)
						{
							$session = Mage::getModel('core/session');
							$session->addError($this->__("Your bid faild becuase someone made a bid in the same time please try again now"));
							$data = array_merge($data, array('reload' => 'true'));
							echo json_encode($data);
							exit;
						}
						if ($this->getDiffTime($_product->getEndBiddingDate()) && ($this->getTotalBid($customerSession->getCustomerId(), $data['productId']) < 5))
						{
							$session = Mage::getModel('core/session');
							$session->addError($this->__("You should spend 5 points or more to win this bid"));
							$data = array_merge($data, array('reload' => 'true'));
						}
						if ($points->getBalance() <= 10)
						{
							$session = Mage::getModel('core/session');
							$session->addError($this->__("Your credit will end soon"));
							$data = array_merge($data, array('reload' => 'true'));
						}
							
						$data = array_merge($data , $bid_result);

						echo json_encode($data);
						//}
						if ($newPrice == $_product->getPrice())
						{
							$this->setCustomerBid($customerSession->getCustomerId(), $data['productId'], $customerSession->getCustomer()->getName());
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
			$session = Mage::getModel('core/session');
			$session->addError($this->__("Please login to access bidding"));
			echo "";
		}
	}

	private function setCustomerBid($customer_id, $product_id, $customer_name)
	{
		$points = Mage::getModel('points/points')->load($customer_id, 'customer_id');
		$bidHistory = Mage::getModel('points/bid');

		$_product = Mage::getModel('catalog/product')->load($product_id);
		$new_price = $_product->getCurrentPrice() + $_product->getCpc();

		$bidHistory->setCustomerId($customer_id);
		$bidHistory->setProductId($product_id);

		$check_uniq_bid = Mage::getModel('points/bid')->getCollection()
		->addFieldToFilter('product_id', array('eq' => $product_id))
		->setOrder('new_price', 'DESC')
		->setPageSize(1);
		$check_uniq_bid = $check_uniq_bid->getData();
		if ($check_uniq_bid[0]['new_price'] >= $new_price)
		{
			return false;
		}

		$bidHistory->setPrice($_product->getCurrentPrice());
		$bidHistory->setNewPrice($new_price);
		$bidHistory->setBidDate(date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));
		$bidHistory->save();

		$_product->setCurrentPrice($new_price);
		$_product->save();

		$points->setBalance($points->getBalance() - 1 );
		$points->save();

		$data = array('action' => 'true','PI' => $product_id, 'price'=> Mage::helper('core')->currency($_product->getCurrentPrice()), 'bidder'=> $customer_name, 'bidderTable' => "<tr><td>".Mage::helper('core')->currency($_product->getCurrentPrice())."</td><td>".$customer_name."</td></tr>");
		return $data;
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
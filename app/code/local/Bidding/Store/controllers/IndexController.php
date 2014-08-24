<?php
//date_default_timezone_set('Asia/Amman');
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

		//Check if customer loged in or not
		if ($customerSession->isLoggedIn())
		{
			$data = $this->getRequest()->getParams();
			$request = $this->getRequest()->isPost();

			//Check Form Key for security issue
			if ($request && $data['form_key'] == Mage::getSingleton('core/session')->getFormKey())
			{
				$points = Mage::getModel('points/points')->load($customerSession->getCustomerId(), 'customer_id');

				//Check if the balance available
				if ($points->getBalance() != 0)
				{

					$_product = Mage::getModel('catalog/product')->load($data['productId']);
					if (date('Y-m-d H:i:s', Mage::getModel('core/date')->timestamp(time())) < $_product->getEndBiddingDate())
					{

						//Check if customer can big before time finish with X time
						if (!$this->getTotalBid($customerSession->getCustomerId(), $data['productId']) && $this->getDiffTime($_product->getEndBiddingDate()))
						{
							$session = Mage::getModel('core/session');
							$session->addError($this->__("You can't enter on this bidding becuase this is your first time and bidding will end in less than 10 minites"));
							$data = array('action' => 'false');
							echo json_encode($data);
						}
						else
						{
							$_product = Mage::getModel('catalog/product')->load($data['productId']);
							$newPrice = $_product->getCurrentPrice() + $_product->getCpc();
							if ($newPrice > $_product->getPrice())
							{
								$_product->setWebsiteIDs(array(1));
								$_product->setStoreId(0);
								$_product->setEndBiddingDate(date('Y-m-d H:i:s',strtotime("-1 days")));
								$_product->save();
								$session = Mage::getModel('core/session');
								$session->addError($this->__("This product has been closed"));
								$data = array_merge($data, array('reload' => 'true'));
							}
							else
							{
								$bid_result = $this->setCustomerBid($customerSession->getCustomerId(), $data['productId'], $customerSession->getCustomer()->getName());

								//Check if customer spend X points or more to win product
								if ($this->getDiffTime($_product->getEndBiddingDate()) && ($this->getTotalBid($customerSession->getCustomerId(), $data['productId']) < 5))
								{
									$session = Mage::getModel('core/session');
									$session->addError($this->__("You should spend 5 points or more to win this bid"));
									$data = array_merge($data, array('reload' => 'true'));
								}

								//Check if points will end soon
								if ($points->getBalance() <= 10)
								{
									$session = Mage::getModel('core/session');
									$session->addError($this->__("Your credit will end soon"));
									$data = array_merge($data, array('reload' => 'true'));
								}

								$data = array_merge($data , $bid_result);
							}
							echo json_encode($data);


						}

					} else {
						$session = Mage::getModel('core/session');
						$session->addError($this->__("This bidding has been closed"));
						$this->_redirect('/');
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
		$resource = Mage::getSingleton('core/resource');
		$writeConnection = $resource->getConnection('core_write');
		$readConnection = $resource->getConnection('core_read');
			
		$query1 = "
		INSERT INTO customer_bid_history (customer_id, product_id, new_price, bid_date)
		SELECT " . $customer_id . ", " . $product_id . ", sum(value), '" . date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())) . "' FROM catalog_product_entity_decimal WHERE attribute_id IN (138, 139) AND entity_id = " . $product_id;

		$query2 = "
		UPDATE catalog_product_entity_decimal AS t1, (
		SELECT sum(value) AS price FROM catalog_product_entity_decimal WHERE attribute_id IN (138, 139) AND entity_id = " . $product_id . "
		) as t2
		SET t1.value = t2.price
		WHERE t1.attribute_id = 139 AND entity_id = " . $product_id
		;

		$query3 = "
		SELECT value FROM catalog_product_entity_decimal WHERE attribute_id = 139 and entity_id = " . $product_id;

		$writeConnection->query($query1);
		$writeConnection->query($query2);

		$customer_points = Mage::getModel('points/points')->load($customer_id,'customer_id');
		$customer_points->setBalance($customer_points->getBalance() - 1);
		$customer_points->save();
		$new_price = $readConnection->fetchOne($query3);
		$data = array('action' => 'true',
				'PI' => $product_id, 
				'price'=> Mage::helper('core')->currency($new_price), 
				'bidder'=> $customer_name, 
				'bidderTable' => "<tr><td class=\"bidderName newEntry\">- ".$customer_name."</td><td class=\"bidPrice newEntry\">".Mage::helper('core')->currency($new_price)."</td></tr>");
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
		date_default_timezone_set('Asia/Amman');
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

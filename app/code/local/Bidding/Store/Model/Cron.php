<?php
date_default_timezone_set('Asia/Amman');
class Bidding_Store_Model_Cron extends Mage_Core_Model_Abstract
{
	public function checkWinner()
	{
		$date = date('Y-m-d H:i:s');
		$products = Mage::getModel('catalog/product')->getCollection()
		->addAttributeToSelect('name')
		->addAttributeToSelect('sku')
		->addFieldToFilter('end_bidding_date', array('lt' => $date));
		foreach ($products as $product)
		{
			if ($product->getId())
			{
				$winner_check = Mage::getModel('points/winner')->load($product->getId(), 'product_id');
				if (!$winner_check->getId())
				{
					$winner_bidder = Mage::getModel('points/bid')->getCollection()
					->addFieldToSelect(array('customer_id','price','new_price'))
					->addFieldToFilter('product_id', array('eq' => $product->getId()));
					$winner_bidder->getSelect()->order('id desc');
					$winner_bidder = $winner_bidder->getData();
					if ($this->getTotalBid($winner_bidder[0]['customer_id'], $product->getId()) >= 5)
					{
						$customer = Mage::getModel('customer/customer')->load($winner_bidder[0]['customer_id']);

						$winner = Mage::getModel('points/winner');
						$winner->setCustomerId($winner_bidder[0]['customer_id']);
						$winner->setProductId($product->getId());
						$winner->setCustomerName($customer->getName());
						$winner->setProductSku($product->getSku());
						$winner->setProductName($product->getName());
						$winner->setWinDate(date('Y-m-d H:i:s'));
						$winner->setBought(0);
						$winner->save();

						$this->_sendEmail($customer->getEmail() , $customer->getName(), $product->getName());
						echo $customer->getEmail() . ' Win: ' . $product->getName();
						echo '<br />';
					}
				}
				else
				{
					echo 'Not Win: ' . $product->getName();
					echo '<br />';
				}
			}
		}
		echo 'cronWinner has beeb excuted';
		echo '<br />';
	}

	public function checkExpired()
	{
		$yesterdayDate = date('Y-m-d H:i:s', strtotime("-1 days"));
		$winner_produts = Mage::getModel('points/winner')->getCollection()
		->addFieldToFilter('win_date', array('lteq' => $yesterdayDate));
	}

	protected function getTotalBid($bidder_id, $product_id)
	{
		$count = Mage::getModel('points/bid')->getCollection()
		->addFieldToFilter('customer_id', array('eq' => $bidder_id))
		->addFieldToFilter('product_id', array('eq' => $product_id));
		return $count->count();
	}

	private function _sendEmail($to_email, $to_name, $product_name)
	{
		$emailTemplate = Mage::getModel('core/email_template')->loadDefault('winner_email_template');

		$emailTemplateVariables = array();
		$emailTemplateVariables['product_name'] = $product_name;
		$emailTemplateVariables['customer_name'] = $to_name;
		$emailTemplateVariables['product_url'] = Mage::getUrl('bidding/index/winner');
		$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

		$emailTemplate->send($to_email, $to_name, $emailTemplateVariables);
	}
}
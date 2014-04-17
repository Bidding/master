<?php 
class Bidding_Store_Block_Product_Listofbidders extends Mage_Core_Block_Template
{
	public function getBidders()
	{
		$bidders = Mage::getModel('points/bid')->getCollection()
					->addFieldToFilter('product_id', array('eq' => $this->getRequest()->getParam('id')));
		$bidders->getSelect()->order('id desc');
		$bidders->getSelect()->limit(10);
		
		return $bidders;
	}
}
?>
<?php 
class Bidding_Store_Block_Adminhtml_Store_Renderer_Customer extends 
Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$customer = Mage::getModel('customer/customer')->load($row->getData($this->getColumn()->getIndex()));
		$html = '<a href="' . Mage::helper('adminhtml')->getUrl('*/customer/edit/', array('id' => $customer->getId())) . '">';
		$html .= $customer->getName();
		$html .= '</a>';
		return $html; 
	}
}
?>
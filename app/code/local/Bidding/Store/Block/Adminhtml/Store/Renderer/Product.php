<?php 
class Bidding_Store_Block_Adminhtml_Store_Renderer_Product extends 
Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$product = Mage::getModel('catalog/product')->load($row->getData($this->getColumn()->getIndex()));
		$html = '<a href="#">';
		$html .= $product->getName();
		$html .= '</a>';
		return $html;
	}
}
?>
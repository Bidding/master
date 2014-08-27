<?php
class Bidding_Store_Block_Adminhtml_Customer_Edit_Listing_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('bidding_store_grid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	public function getGridUrl()
	{
		//	return $this->getUrl('*/*/grid', array('_current'=>true));
		return Mage::helper("adminhtml")->getUrl("adminhtml/store/grid", array('_current' => true));
	}

	public function _prepareCollection()
	{
		$collection = Mage::getModel('points/history')->getCollection()
		->addFieldToFilter('customer_id', array('eq'=>Mage::getSingleton('admin/session')->getCustomerId()));

		$this->setCollection($collection);

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	public function _prepareColumns()
	{
		$this->addColumn('id',
				array(
						'header'=> Mage::helper('core')->__('ID'),
						'width' => '10px',
						'type'  => 'number',
						'index' => 'id',
				));
		$this->addColumn('order_id',
				array(
						'header'=> Mage::helper('core')->__('Order ID'),
						'width' => '50px',
						'type'  => 'number',
						'index' => 'order_id',
				));

		$this->addColumn('balance',
				array(
						'header'=> Mage::helper('core')->__('Balance'),
						'width' => '50px',
						'type'  => 'number',
						'index' => 'balance',
				));

		$this->addColumn('date',
				array(
						'header'=> Mage::helper('core')->__('Date'),
						'width' => '50px',
						'index'=> 'win_date',
						'type'      => 'datetime',
						'index' => 'date',
				));
	}
}
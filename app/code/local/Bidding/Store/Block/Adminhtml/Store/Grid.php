<?php
date_default_timezone_set('Asia/Amman');

class Bidding_Store_Block_Adminhtml_Store_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('store');
		$this->setDefaultSort('win_date');
		$this->setDefaultDir('DESC');
	}

	public function _prepareCollection()
	{
		$collection = Mage::getModel('points/winner')->getCollection()
		->addFieldToSelect('*');
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	public function _prepareColumns()
	{
		$this->addColumn('win_date', array(
              'header' => Mage::helper('store')->__('Win Date'),    
              'align' => 'left',
              'width' => '50px',
              'index'=> 'win_date',
              'type'      => 'datetime',
              'filter_index' => 'win_date'
              ));

              $this->addColumn('customer_id', array(
            'header' => Mage::helper('store')->__('Customer Name'),
            'align' => 'left',
            'width' => '50px',
            'type' => 'text',
			'index' => 'customer_id',
            'filter_index' => 'customer_name',
            'renderer'  => 'store/adminhtml_store_renderer_customer'
              ));

              $this->addColumn('product_id', array(
            'header' => Mage::helper('store')->__('Product Name'),
            'align' => 'left',
            'width' => '50px',
            'type' => 'text',
			'index' => 'product_id',
            'filter_index' => 'product_name',
            'renderer'  => 'store/adminhtml_store_renderer_product'
              ));

              $this->addColumn('product_sku', array(
            'header' => Mage::helper('store')->__('Product SKU'),
            'align' => 'left',
            'width' => '50px',
            'type' => 'text',
			'index' => 'product_sku',
              ));

              $this->addExportType('*/*/exportCsv', $this->__('CSV'));
              $this->addExportType('*/*/exportExcel', $this->__('Excel'));
              return parent::_prepareColumns();
	}
}
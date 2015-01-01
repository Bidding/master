<?php
class Bidding_Points_Block_Adminhtml_Points_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct() {
		parent::__construct();
		$this->setId('bidding_points_grid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}

	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('customer/customer_collection')
		->addNameToSelect()
		->addAttributeToSelect('email')
		->addAttributeToSelect('created_at')
		->addAttributeToSelect('group_id')
		->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
		->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
		->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
		->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
		->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');

		$this->setCollection($collection);

		parent::_prepareCollection();
		return $this;
	}

	protected function _prepareColumns() {
		$this->addColumn('entity_id', array(
            'header' => $this->__('ID'),
            'index'  => 'entity_id'
            ));

            $this->addColumn('email', array(
            'header' => $this->__('Customer Email'),
            'index'  => 'email'
            ));

            $this->addColumn('name', array(
            'header' => $this->__('Customer Name'),
            'index'  => 'name'
            ));

            $link= Mage::helper('adminhtml')->getUrl('adminhtml/points/edit/') .'id/$entity_id';
            $this->addColumn('action_edit', array(
        'header'   => $this->helper('catalog')->__('Action'),
        'width'    => 15,
        'sortable' => false,
        'filter'   => false,
        'type'     => 'action',
        'actions'  => array(
            array(
                'url'     => $link,
                'caption' => $this->helper('catalog')->__('Edit'),
            ),
            )
            ));

            return parent::_prepareColumns();
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array(
        'id'=>$row->getId())
		);
	}
}
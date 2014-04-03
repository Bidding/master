<?php
$installer = $this;
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'start_bidding_date', array(
		'group'             => 'Bidding',
		'type'              => 'date',
		'backend'           => '',
		'frontend'          => '',
		'label'             => 'Start Bidding Date',
		'input'             => 'datetime',
		'class'             => '',
		'source'            => 'points/product_attribute_source_startbiddingdate',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => false,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'visible_on_front'  => true,
		'unique'            => false,
		'apply_to'          => 'simple,configurable,bundle,grouped',
		'is_configurable'   => false,
));
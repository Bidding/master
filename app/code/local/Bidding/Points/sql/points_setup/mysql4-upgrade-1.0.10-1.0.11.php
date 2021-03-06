<?php
$installer = $this;
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'diff_time_for_bid', array(
		'group'             => 'Bidding',
		'type'              => 'int',
		'backend'           => '',
		'frontend'          => '',
		'label'             => 'Set minutes before enter bidding',
		'input'             => 'text',
		'class'             => '',
		'source'            => '',
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
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'diff_time_for_points', array(
		'group'             => 'Bidding',
		'type'              => 'int',
		'backend'           => '',
		'frontend'          => '',
		'label'             => 'Set minutes for spend points',
		'input'             => 'text',
		'class'             => '',
		'source'            => '',
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
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'num_of_points', array(
		'group'             => 'Bidding',
		'type'              => 'int',
		'backend'           => '',
		'frontend'          => '',
		'label'             => 'Set number of points for spending',
		'input'             => 'text',
		'class'             => '',
		'source'            => '',
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
<?php
$installer = $this;
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'points', array(
		'group'             => 'Bidding',
		'type'              => 'int',
		'backend'           => '',
		'frontend'          => '',
		'label'             => 'Points',
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
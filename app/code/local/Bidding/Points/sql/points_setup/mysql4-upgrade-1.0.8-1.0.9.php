<?php
$installer = $this;
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'retail_price', array(
		'group'             => 'Prices',
		'type'              => 'decimal',
		'backend'           => '',
		'frontend'          => '',
		'label'             => 'Retail Price',
		'input'             => 'price',
		'class'             => '',
		'source'            => 'catalog/product_attribute_backend_price',
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
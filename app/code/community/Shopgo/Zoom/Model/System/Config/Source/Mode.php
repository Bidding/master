<?php

class Shopgo_Zoom_Model_System_Config_Source_Mode
{
    public function toOptionArray()
    {
        $helper = Mage::helper('zoom');

        return array(
            array('value' => 'window',   'label' => $helper->__('Window')),
            array('value' => 'dock',   'label' => $helper->__('Dock')),
            array('value' => 'slippy',    'label' => $helper->__('Slippy')),
            array('value' => 'lens',    'label' => $helper->__('Lens'))
        );
    }
}

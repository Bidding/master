<?php

class Shopgo_Zoom_Model_System_Config_Source_Dockposition
{
    public function toOptionArray()
    {
        $helper = Mage::helper('zoom');

        return array(
            array('value' => 'right',   'label' => $helper->__('Right')),
            array('value' => 'left',   'label' => $helper->__('Left'))
        );
    }
}

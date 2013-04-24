<?php
class Yougento_Youmaps_Model_Frontendopt
{
    public function toOptionArray()
    {
        return array(
            array('value'=>1, 'label'=>Mage::helper('adminhtml')->__('Marker')),
            array('value'=>2, 'label'=>Mage::helper('adminhtml')->__('Circle')),                 
        );
    }

}
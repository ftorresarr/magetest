<?php
class Yougento_Youmaps_Model_Observer
{
    /**
    * Add file type to available EAV attributes types
    * Used in system config's attributes management page
    * 
    * @param Varien_Event_Observer $observer
    */
    public function addFileAttributeType22(Varien_Event_Observer $observer)
    {
        if ($response = $observer->getEvent()->getResponse()) {
            if (!is_array($types = $response->getTypes())) {
                $types = array();
            }
            $types[] = array(
                'value' => 'youmap',
                'label' => Mage::helper('adminhtml')->__('Youmap'),

            );
            $response->setTypes($types);
        }
    }
    
    /**
    * 
    * @param Varien_Event_Observer $observer
    */
    public function onAttributeSaveBefore(Varien_Event_Observer $observer)
    {
        if (($attribute = $observer->getEvent()->getAttribute())
            && ($attribute->getFrontendInput() == 'youmap')) {
            	$name=$attribute->getName();
            $attribute->setBackendModel('youmaps/attribute_backend_map')
                ->setBackendType('varchar')
                ->setFrontendModel('youmaps/attribute_frontend_map')
                ->setFrontendInputRenderer('youmaps/form_element_map')
                ->setIsHtmlAllowedOnFront(1);
        }
    }
}

<?php

class Silpion_DPD_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function addButtonOfYourChoice(Varien_Event_Observer $observer)
    {
        $block = Mage::app()->getLayout()->getBlock('sales_order_edit');
        if (!$block) {
            return $this;
        }
        $order = Mage::registry('current_order');
        $url = Mage::helper("adminhtml")->getUrl(
            "adminhtml/dpd/send",
            array('order_id' => $order->getId())
        );
        $block->addButton(
            'button_id',
            array(
                'label' => Mage::helper('silpion_dpd')->__('Button Label'),
                'onclick' => 'setLocation(\'' . $url . '\')',
                'class' => 'go'
            )
        );
        return $this;
    }

    /**
     * Save paczkomaty code on checkout
     *
     * @param $observer
     */
    public function savePointToOrder($observer)
    {
        try {
            $dpdPoint = Mage::getSingleton('checkout/session')->getDpdPoint();
            if ($dpdPoint) {
                $order = $observer->getEvent()->getOrder();
                $order->setDpdPoint($dpdPoint);
                $order->setShippingDescription($order->getShippingDescription() . ' ' . $dpdPoint);
            }
        } catch (\Exception $e) {
        }
    }
}

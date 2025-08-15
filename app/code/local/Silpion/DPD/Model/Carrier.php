<?php

class Silpion_DPD_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'dpd';

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');
        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $shippingPrice = $this->getConfigData('price');
        $freeShippingFrom = (float) $this->getConfigData('free_shipping_from');

        if ($freeShippingFrom) {
            $quote = $request->getQuote();
            $quoteTotal = (float) $quote->getGrandTotal() - (float) $quote->getShippingAmount();
            if ($freeShippingFrom > $quoteTotal) {
                $shippingPrice = 0;
            }
        }
        $shippingPrice = 1;

        if ($shippingPrice) {
            $shippingPrice += $this->getConfigData('handling_fee');
        }

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);

        $result->append($method);

        return $result;
    }

    public function getAllowedMethods()
    {
        return array($this->_code => $this->getConfigData('name'));
    }
}

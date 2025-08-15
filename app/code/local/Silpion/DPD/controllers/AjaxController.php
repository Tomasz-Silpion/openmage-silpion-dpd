<?php

class Silpion_DPD_AjaxController extends Mage_Core_Controller_Front_Action
{
    /**
     * @return void
     */
    public function savePointAction()
    {
        $point = $this->getRequest()->getParam('point');

        $response = array(
            'status' => 'ok',
            'point' => $point
        );

        Mage::getSingleton('checkout/session')->setDpdPoint($point);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($response));
    }
}

<?php
class Retailon_Vendor_SignupController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("Register - Complete IT Service companies,Global Outsourcing and consulting,Outsourced IT Services Providers,Outsourcing companies in india."));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
            "label" => $this->__("Home Page"),
            "title" => $this->__("Home Page"),
            "link"  => Mage::getBaseUrl()
        ));
        $breadcrumbs->addCrumb("vendor", array(
            "label" => $this->__("Register"),
            "title" => $this->__("Register")
        ));
        $this->renderLayout();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 6/1/2015
 * Time: 4:10 PM
 */

class Retailon_Marketplace_Adminhtml_CommissionController extends Mage_Adminhtml_Controller_Action {
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu("marketplace/marketplace")->_addBreadcrumb(Mage::helper("adminhtml")->__("Marketplace  Manager"),Mage::helper("adminhtml")->__("Marketplace Manager"));
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__("Marketplace"));
        $this->_title($this->__("Manage Commission"));
        $this->_initAction();
        $this->renderLayout();
    }

    public function payAction(){
        print_r($this->getRequest()->getParams());
        echo 'ok';
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName   = 'marketplace.csv';
        $grid       = $this->getLayout()->createBlock('marketplace/adminhtml_marketplace_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName   = 'marketplace.xml';
        $grid       = $this->getLayout()->createBlock('marketplace/adminhtml_marketplace_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
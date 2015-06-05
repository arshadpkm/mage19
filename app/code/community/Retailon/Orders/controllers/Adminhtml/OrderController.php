<?php
class Retailon_Orders_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Sales'))->_title($this->__('Orders Retailon'));
        $this->loadLayout();
        $this->_setActiveMenu('sales/sales');
        $this->_addContent($this->getLayout()->createBlock('retailon_orders/adminhtml_sales_order'));
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('retailon_orders/adminhtml_sales_order_grid')->toHtml()
        );
    }
    public function exportRetailonCsvAction()
    {
        $fileName = 'retailon_orders.csv';
        $grid = $this->getLayout()->createBlock('retailon_orders/adminhtml_sales_order_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
    public function exportRetailonExcelAction()
    {
        $fileName = 'retailon_orders.xml';
        $grid = $this->getLayout()->createBlock('retailon_orders/adminhtml_sales_order_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
<?php
class Retailon_Commission_Block_Adminhtml_Show_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('myrouter_index_index');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        date_default_timezone_set("Asia/Calcutta");
    }
  /*  protected function _prepareLayout()
    {
        $this->setChild('reset_filter_button');
        $this->setChild('search_button');
    }  */
    protected function _prepareCollection()
    {
        $id=$this->getRequest()->getParam('sell_id');
        $collection = Mage::getModel('commission/sellercomm')->getCollection()->addFieldToFilter('seller_id',array('in' => $id));
         
                
        
        $this->setCollection($collection);
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
     $helper = Mage::helper('retailon_commission');
      $this->addColumn('id',
            array(
                'header' => 'ID',
                'align' =>'right',
                'width' => '50px',
                'index' => 'id',
            ));
            
     $this->addColumn('seller_id',
            array(
                'header' => 'Seller ID',
                'align' =>'right',
                'width' => '50px',
                'index' => 'seller_id',
            ));  
      $this->addColumn('seller_name',
            array(
                'header' => 'Seller Name',
                'align' =>'right',
                'width' => '50px',
                'index' => 'seller_name',
       ));
       $this->addColumn('store_id',
            array(
                'header' => 'Store Id',
                'align' =>'right',
                'width' => '50px',
                'index' => 'store_id',
       ));
       $this->addColumn('store_name',
            array(
                'header' => 'Store Name',
                'align' =>'right',
                'width' => '50px',
                'index' => 'store_name',
       ));
      $this->addColumn('total_sales',
            array(
                'header' => 'Total Sales',
                'align' =>'right',
                'width' => '50px',
                //'index' => 'total_sales',
               'renderer' => 'Retailon_Commission_Block_Adminhtml_Show_TotalSalespath',
       ));
      $this->addColumn('commission_rate',
            array(
                'header' => 'Commission Rate',
                'align' =>'right',
                'width' => '50px',
                // 'index' => 'commission_rate',
               'renderer' => 'Retailon_Commission_Block_Adminhtml_Show_CommRatepath',
       ));
      $this->addColumn('total_commission',
            array(
                'header' => 'Total Commission',
                'align' =>'right',
                'width' => '50px',
                //'index' => 'total_commission',
               'renderer' => 'Retailon_Commission_Block_Adminhtml_Show_TotalCommissionpath',
       ));
      
      
      $this->addColumn('pay_amount',
            array(
                'header' => 'Paid Amount',
                'align' =>'right',
                'width' => '50px',
               // 'index' => 'pay_amount',
                'renderer' => 'Retailon_Commission_Block_Adminhtml_Show_Payamountpath',
       ));
      
       
      $this->addColumn('pay_type',
            array(
                'header' => 'Paid Type',
                'align' =>'right',
                'width' => '50px',
                'index' => 'pay_type',
       ));
      $this->addColumn('paid_date',
            array(
                'header' => 'Paid Date',
                'align' =>'left',
                'width' => '50px',
                'index' => 'paid_date',
                'type' => 'datetime'
       ));
      $this->addColumn('due',
            array(
                'header' => 'Due',
                'align' =>'right',
                'width' => '50px',
               // 'index' => 'due',
                'renderer' => 'Retailon_Commission_Block_Adminhtml_Show_Duepath',
       ));
      $this->addColumn('total_paid',
            array(
                'header' => 'Total Paid',
                'align' =>'right',
                'width' => '50px',
                //'index' => 'total_paid',
                'renderer' => 'Retailon_Commission_Block_Adminhtml_Show_TotalPaidpath',
       ));
       
     /* $this->addColumn('back',
            array(
                'header' => $this->__('Back'),
                'width' => '100',
                'type' => 'action',
                //'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => $this->__('Back'),  */
                      //  'url' => array('base' => "*/*/")//,
                        //'field' => 'seller_id'
              /*      )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'edit',
                'is_system' => true,
            ));  */
         $this->addColumn('comments',
            array(
                'header' => 'Comments',
                'align' =>'right',
                'width' => '50px',
                'index' => 'comments',
       )); 
       
       $this->addExportType('*/*/exportCommissionHistoryCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportCommissionHistoryExcel', $helper->__('Excel XML'));
         
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        //return $this->getUrl("*/*/showhistory", array('seller_id' => $row->getId()));
    }
}
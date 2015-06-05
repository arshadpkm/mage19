<?php
class Retailon_Commission_Block_Adminhtml_Test_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('myrouter_index_index');
        $this->setDefaultSort('store_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(TRUE);
        // $this->setChild('reset_filter_button');
        //$this->setChild('search_button');
        date_default_timezone_set("Asia/Calcutta");
    }
   /* protected function _prepareLayout()
    {
        $this->setChild('reset_filter_button');
        $this->setChild('search_button');
    }  */
    protected function _prepareCollection()
    { $total_qtyinvoiced = 0;
        $last_paid_is=0;
        $collection = Mage::getModel('commission/sellershow')->getCollection();
        $collection->setOrder('id','ASC');
        $month=$this->getRequest()->getParam('month');
        $year=$this->getRequest()->getParam('year');
        
       
        
        
        
        if(($year==NULL)&&($month==NULL))
         {
         
         
         foreach($collection as $col)
          {
          
          
             $sid=$col->getSellerId();
                            
             $datatr=Mage::getModel('commission/sellershow')->getCollection()->getData();         
              foreach($datatr as $valuetr) 
               {
                 if($sid==$valuetr['seller_id']) 
                    {
                      $sum1=(float)$valuetr['total_sales'];
                      $sum=number_format($sum1,2);

                      $total_commission_row1=(float)$valuetr['total_commission'];
                      $total_commission_row=number_format($total_commission_row1,2);

                      $last_paid_is1=(float)$valuetr['last_paid'];
                      $last_paid_is=number_format($last_paid_is1,2);
                      
                        $retailonex001=(string)$valuetr['due'];  
                        $retailonex002= strpos($retailonex001, ".", 0);
                        $retailonex003=substr($retailonex001,$retailonex002+1,2);
                      if($retailonex003=="00")
                       {
                       $cal_due="0.00";
                       }
                      else
                       {        
                      $cal_due1=(float)$valuetr['due'];
                      $cal_due=number_format($cal_due1,2);
                       }

                      $paid_particular1=(float)$valuetr['total_paid'];
                      $paid_particular=number_format($paid_particular1,2);

                      $col->setTotalSales($sum);          
                     $col->setTotalCommission($total_commission_row);  
                     $col->setLastPaid($last_paid_is);            
                    $col->setDue($cal_due);
                    $col->setTotalPaid($paid_particular);
                     break;
                    } 
               }                   
            
          
          }// for each close
         
         }  //if close
        
        
        
        
        if($year!=NULL)
         {
         
         
         foreach($collection as $col)
          {
          
          
               $sid=$col->getSellerId();
                $currid=$this->getRequest()->getParam('sid');
                 if($sid==$currid) 
                  {
                    
          
                  $model = Mage::getModel('storeconf/storeconf')->getCollection()->getData();
       
        
                      foreach($model as $key1 => $value1)
                             {
                                if($sid==$value1['seller_id'])
                                         {
                                           
                                           $comm_rate=$value1['etc2'];
                                           $know_fixed_percent = $value1['rate']; 
                                           $know_seller_category = $value1['store_category'];
                                          break;
                                         }
           
                            } 
                  /* area start here for calculating total sales and total qty shipped */          
         
                $resource = Mage::getSingleton('core/resource');
                 $readConnection = $resource->getConnection('core_read');

     $allproductids = "SELECT product_id FROM catalog_category_product where category_id=$know_seller_category ";
     $allproductresult = $readConnection->fetchAll($allproductids);
     $prdIds =array();
     foreach($allproductresult as $value4)
      {
    $prdIds[]=$value4['product_id'];
      }
 
    $no_of_ele=count($prdIds);
     $sum=0;
     $total_qtyinvoiced=0;
     
     $allincrementids = "SELECT increment_id FROM sales_flat_order_grid where status='complete' ";
     $allincrresult = $readConnection->fetchAll($allincrementids);
     $incr_id_array =array();
     foreach($allincrresult as $value)
      {
    $incr_id_array[]=$value['increment_id'];
      }

     foreach($incr_id_array as $value1)
     {
         $j=0;
     	$orderIncrementId =$value1;
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
        $required_order_id=$order->getId();       
        $items = $order->getAllVisibleItems();
          foreach($items as $value2)
            {
   	        $ids[$j++]=$value2->getProductId();   	
            } 
           

         
          foreach($ids as $value3)
           {
           	 for($i=0;$i<$no_of_ele;$i++)
           	   {
           	      if($value3==$prdIds[$i])
           	      {
           	      	
           	      	$amount="SELECT base_row_total_incl_tax,qty_shipped,updated_at FROM sales_flat_order_item where order_id=$required_order_id and product_id=$value3 ";
           	      	$temp1=$readConnection->fetchAll($amount);
           	      	 foreach($temp1 as $value6)
           	      	 {

                                  $str001=$value6['updated_at'];
                                  $str002 = substr($str001,2,2);
                                    if($str002==$year)
                                      {
                                        $sum+=$value6['base_row_total_incl_tax'];
                                        $total_qtyinvoiced+=$value6['qty_shipped'];
                                      }
           	      	 	
           	      	 }
           	      }
           	   }
           }  
           
     }
  
 
         
            /* area end here for calculating total sales and total qty shipped */     
          
            if($know_fixed_percent==0)
             {
             $total_commission_row = ($sum * $comm_rate)/100;	
             }
           if($know_fixed_percent==1)
             {
             $total_commission_row = $total_qtyinvoiced * $comm_rate;
             } 
          
        
            $paid_particular = 0;  
            
           $transdata = Mage::getModel('commission/sellercomm')->getCollection()->getData();
            foreach($transdata as $keyq => $valueq)  
             {
               if($sid==$valueq['seller_id'])
                 {
                   $str6 = $valueq['paid_date'];
                   $str7 = substr($str6,2,2);
                   
                  
                  
                   if($year==$str7)
                     {
                      $last_date_is =$valueq['paid_date'];
                      $last_paid_is =$valueq['pay_amount'];
                     $paid_particular +=$valueq['pay_amount'];
                     }
                  
                 }
             } 
            if($sum==0)
             {
             $last_paid_is = 0;
             $last_date_is =NULL;
             $cal_due = 0; 
             $paid_particular = 0;
             } 
            if($paid_particular > ($sum - $total_commission_row))
             {
             $paid_particular = $sum - $total_commission_row;
             $cal_due = 0;
             }
             if($last_paid_is > ($sum - $total_commission_row))
              {
              $last_paid_is = $sum - $total_commission_row;
              }
              
            $cal_due =($sum - $total_commission_row -  $paid_particular);
            
            
                      $sum1=(float)$sum;
                      $sum=number_format($sum1,2);

                      $total_commission_row1=(float)$total_commission_row;
                      $total_commission_row=number_format($total_commission_row1,2);

                      $last_paid_is1=(float)$last_paid_is;
                      $last_paid_is=number_format($last_paid_is1,2);
           
                      $retailonex001=(string)$cal_due;  
                        $retailonex002= strpos($retailonex001, ".", 0);
                        $retailonex003=substr($retailonex001,$retailonex002+1,2);
                      if($retailonex003=="00")
                       {
                       $cal_due="0.00";
                       }
                      else
                       { 
                      $cal_due1=(float)$cal_due;
                      $cal_due=number_format($cal_due1,2);
                       }

                      $paid_particular1=(float)$paid_particular;
                      $paid_particular=number_format($paid_particular1,2);
            
            $col->setTotalSales($sum);
            $col->setCommissionRate($comm_rate);
            $col->setTotalCommission($total_commission_row);  
            $col->setLastPaid($last_paid_is);
            $col->setLastPaidDate($last_date_is);
            $col->setDue($cal_due);
            $col->setTotalPaid($paid_particular);
           }
          else
          {
          $datatr=Mage::getModel('commission/sellershow')->getCollection()->getData();         
              foreach($datatr as $valuetr) 
               {
                 if($sid==$valuetr['seller_id']) 
                    {
                      $sum1=(float)$valuetr['total_sales'];
                      $sum=number_format($sum1,2);

                      $total_commission_row1=(float)$valuetr['total_commission'];
                      $total_commission_row=number_format($total_commission_row1,2);

                      $last_paid_is1=(float)$valuetr['last_paid'];
                      $last_paid_is=number_format($last_paid_is1,2);
                      
                      $retailonex001=(string)$valuetr['due'];  
                        $retailonex002= strpos($retailonex001, ".", 0);
                        $retailonex003=substr($retailonex001,$retailonex002+1,2);
                      if($retailonex003=="00")
                       {
                       $cal_due="0.00";
                       }
                      else
                      { 
                      $cal_due1=(float)$valuetr['due'];
                      $cal_due=number_format($cal_due1,2);
                      }

                      $paid_particular1=(float)$valuetr['total_paid'];
                      $paid_particular=number_format($paid_particular1,2);

                      $col->setTotalSales($sum);          
                     $col->setTotalCommission($total_commission_row);  
                     $col->setLastPaid($last_paid_is);            
                    $col->setDue($cal_due);
                    $col->setTotalPaid($paid_particular);
                     break;
                    } 
               }     
          
          } 
          
          }// for each close
         
         }  //if close
         
         
        if($month!=NULL)
        {
          $str_date=date('Y-m-d');
          $year_value_is=substr($str_date,2,2);
          foreach($collection as $col)
          {
          
          
               $sid=$col->getSellerId();
                $currid=$this->getRequest()->getParam('sid');
                 if($sid==$currid) 
                  {
          
                  $model = Mage::getModel('storeconf/storeconf')->getCollection()->getData();
       
        
                      foreach($model as $key1 => $value1)
                             {
                                if($sid==$value1['seller_id'])
                                         {
                                           
                                           $comm_rate=$value1['etc2'];
                                           $know_fixed_percent = $value1['rate'];
                                           $know_seller_category1 = $value1['store_category']; 
                                          break;
                                         }
           
                            } 
         
          /* area start here for calculating total sales and total qty shipped */
                 
         
          $resource = Mage::getSingleton('core/resource');
                 $readConnection = $resource->getConnection('core_read');

     $allproductids = "SELECT product_id FROM catalog_category_product where category_id=$know_seller_category1 ";
     $allproductresult = $readConnection->fetchAll($allproductids);
     $prdIds =array();
     foreach($allproductresult as $value4)
      {
    $prdIds[]=$value4['product_id'];
      }
 
    $no_of_ele=count($prdIds);
     $sum=0;
     $total_qtyinvoiced=0;
     
     $allincrementids = "SELECT increment_id FROM sales_flat_order_grid where status='complete' ";
     $allincrresult = $readConnection->fetchAll($allincrementids);
     $incr_id_array =array();
     foreach($allincrresult as $value)
      {
    $incr_id_array[]=$value['increment_id'];
      }

     foreach($incr_id_array as $value1)
     {
         $j=0;
     	$orderIncrementId =$value1;
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
        $required_order_id=$order->getId();       
        $items = $order->getAllVisibleItems();
          foreach($items as $value2)
            {
   	        $ids[$j++]=$value2->getProductId();   	
            } 
           

         
          foreach($ids as $value3)
           {
           	 for($i=0;$i<$no_of_ele;$i++)
           	   {
           	      if($value3==$prdIds[$i])
           	      {
           	      	
           	      	$amount="SELECT base_row_total_incl_tax,qty_shipped,updated_at FROM sales_flat_order_item where order_id=$required_order_id and product_id=$value3 ";
           	      	$temp1=$readConnection->fetchAll($amount);
           	      	 foreach($temp1 as $value6)
           	      	 {

                                  $str001=$value6['updated_at'];
                                  $str002 = substr($str001,5,2);
                                  $str003 = substr($str001,2,2);
                                    if(($str002==$month)&&($str003==$year_value_is))
                                      {
                                        $sum+=$value6['base_row_total_incl_tax'];
                                        $total_qtyinvoiced+=$value6['qty_shipped'];
                                      }
           	      	 	
           	      	 }
           	      }
           	   }
           }  
           
     }
         
         
            /* area end here for calculating total sales and total qty shipped */
          
            if($know_fixed_percent==0)
             {
             $total_commission_row = ($sum * $comm_rate)/100;	
             }
           if($know_fixed_percent==1)
             {
             $total_commission_row = $total_qtyinvoiced * $comm_rate;
             } 
          
        
            $paid_particular = 0;  
            
           $transdata = Mage::getModel('commission/sellercomm')->getCollection()->getData();
            foreach($transdata as $keyq => $valueq)  
             {
               if($sid==$valueq['seller_id'])
                 {
                   $str6 = $valueq['paid_date'];
                   $str7 = substr($str6,5,2);
                   $str8 = substr($str6,2,2);
                  
                  
                   if(($month==$str7)&&($str8==$year_value_is))
                     {
                      $last_date_is =$valueq['paid_date'];
                      $last_paid_is =$valueq['pay_amount'];
                     $paid_particular +=$valueq['pay_amount'];
                     }
                  
                 }
             } 
            if($sum==0)
             {
             $last_paid_is = 0;
             $last_date_is =NULL;
             $cal_due = 0; 
             $paid_particular = 0;
             } 
            if($paid_particular > ($sum - $total_commission_row))
             {
             $paid_particular = $sum - $total_commission_row;
             $cal_due = 0;
             }
             if($last_paid_is > ($sum - $total_commission_row))
              {
              $last_paid_is = $sum - $total_commission_row;
              }
            $cal_due =($sum - $total_commission_row -  $paid_particular);
            
            
                      $sum1=(float)$sum;
                      $sum=number_format($sum1,2);

                      $total_commission_row1=(float)$total_commission_row;
                      $total_commission_row=number_format($total_commission_row1,2);

                      $last_paid_is1=(float)$last_paid_is;
                      $last_paid_is=number_format($last_paid_is1,2);

                          $retailonex001=(string)$cal_due;  
                        $retailonex002= strpos($retailonex001, ".", 0);
                        $retailonex003=substr($retailonex001,$retailonex002+1,2);
                      if($retailonex003=="00")
                       {
                       $cal_due="0.00";
                       }
                      else
                       {
                      $cal_due1=(float)$cal_due;
                      $cal_due=number_format($cal_due1,2);
                       }

                      $paid_particular1=(float)$paid_particular;
                      $paid_particular=number_format($paid_particular1,2);
            
            $col->setTotalSales($sum);
            $col->setCommissionRate($comm_rate);
            $col->setTotalCommission($total_commission_row);  
            $col->setLastPaid($last_paid_is);
            $col->setLastPaidDate($last_date_is);
            $col->setDue($cal_due);
            $col->setTotalPaid($paid_particular);
           }
           
         else
          {
          $datatr=Mage::getModel('commission/sellershow')->getCollection()->getData();         
              foreach($datatr as $valuetr) 
               {
                 if($sid==$valuetr['seller_id']) 
                    {
                      $sum1=(float)$valuetr['total_sales'];
                      $sum=number_format($sum1,2);

                      $total_commission_row1=(float)$valuetr['total_commission'];
                      $total_commission_row=number_format($total_commission_row1,2);

                      $last_paid_is1=(float)$valuetr['last_paid'];
                      $last_paid_is=number_format($last_paid_is1,2);

                      $retailonex001=(string)$valuetr['due'];  
                        $retailonex002= strpos($retailonex001, ".", 0);
                        $retailonex003=substr($retailonex001,$retailonex002+1,2);
                      if($retailonex003=="00")
                       {
                       $cal_due="0.00";
                       }          
                      else
                       {      
                      $cal_due1=(float)$valuetr['due'];
                      $cal_due=number_format($cal_due1,2);
                       }

                      $paid_particular1=(float)$valuetr['total_paid'];
                      $paid_particular=number_format($paid_particular1,2);

                      $col->setTotalSales($sum);          
                     $col->setTotalCommission($total_commission_row);  
                     $col->setLastPaid($last_paid_is);            
                    $col->setDue($cal_due);
                    $col->setTotalPaid($paid_particular);
                     break;
                    } 
               }     
          
          } 
          
          }// for each close
        
        
        
        
        
        	
        	
        }//if close
        
       
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
     $helper = Mage::helper('retailon_commission');
    /* $this->addColumn('seller_id',
            array(
                'header' => 'Seller ID',
                'align' =>'right',
                'width' => '50px',
                'index' => 'seller_id',
            ));    */
            
            $this->addColumn('store_id',
            array(
                'header' => 'Store ID',
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
       $this->addColumn('seller_name',
            array(
                'header' => 'Seller Name',
                'align' =>'right',
                'width' => '50px',
                'index' => 'seller_name',
       ));
      $this->addColumn('total_sales',
            array(
                'header' => 'Total Sales',
                'align' =>'right',
                'width' => '50px',
                'index' => 'total_sales',
                
       ));
      $this->addColumn('commission_rate',
            array(
                'header' => 'Commission<br>Rate',
                'align' =>'right',
                'width' => '30px',
               
               'renderer' => 'Retailon_Commission_Block_Adminhtml_Test_Commpath',
       ));
      $this->addColumn('total_commission',
            array(
                'header' => 'Total<br>Commission',
                'align' =>'right',
                'width' => '50px',
                'index' => 'total_commission',
               
       ));
       
     
       
      
       
      $this->addColumn('last_paid',
            array(
                'header' => 'Last Paid',
                'align' =>'right',
                'width' => '50px',
                'index' => 'last_paid',
               
       ));
      $this->addColumn('last_paid_date',
            array(
                'header' => 'Last Paid Date',
                'align' =>'left',
                'width' => '100px',
                'index' => 'last_paid_date',
                'type' => 'datetime'
       ));
      $this->addColumn('due',
            array(
                'header' => 'Due',
                'align' =>'right',
                'width' => '90px',
                'index' => 'due',
               
                
       ));
      $this->addColumn('total_paid',
            array(
                'header' => 'Total Paid',
                'align' =>'right',
                'width' => '50px',
                'index' => 'total_paid',
               
       ));
       
       
        
       
       
      $this->addColumn('action',

            array(

                'header'    =>  $this->__('Action'),

                'width'     => '100',

                'type'      => 'action',

                'getter'    => 'getSellerId',

                'actions'   => array(

                    array(

                        'caption'   => $this->__('Pay'),

                        'url'       => array('base'=> '*/*/pay'),

                        'field'     => 'id'

                    ),

                    array(

                        'caption'   => $this->__('History'),

                        'url'       => array('base'=> '*/*/view'),

                        'field'     => 'sell_id'

                    )

                ),

                'filter'    => false,

                'sortable'  => false,

                'index'     => 'stores',

                'is_system' => true
        ));  
     
        $this->addColumn('month_view',
            array(
                'header' => $this->__('Month View'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getSellerId',
                'actions' => array(
                    array(
                        'caption' => $this->__('Jan'),
                        'url' => array('base' => '*/*/index/month/01'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Feb'),
                        'url' => array('base' => '*/*/index/month/02'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Mar'),
                        'url' => array('base' => '*/*/index/month/03'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Apr'),
                        'url' => array('base' => '*/*/index/month/04'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('May'),
                        'url' => array('base' => '*/*/index/month/05'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Jun'),
                        'url' => array('base' => '*/*/index/month/06'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Jul'),
                        'url' => array('base' => '*/*/index/month/07'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Aug'),
                        'url' => array('base' => '*/*/index/month/08'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Sep'),
                        'url' => array('base' => '*/*/index/month/09'),
                        'field' => 'id'
                    ),
                    array(
                        'caption' => $this->__('Oct'),
                        'url' => array('base' => '*/*/index/month/10'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Nov'),
                        'url' => array('base' => '*/*/index/month/11'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('Dec'),
                        'url' => array('base' => '*/*/index/month/12'),
                        'field' => 'sid'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'edit',
                'is_system' => true,
            ));

         $this->addColumn('year',
            array(
                'header' => $this->__('Year View'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getSellerId',
                'actions' => array(
                    array(
                        'caption' => $this->__('2014'),
                        'url' => array('base' => '*/*/index/year/14'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('2015'),
                        'url' => array('base' => '*/*/index/year/15'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('2016'),
                        'url' => array('base' => '*/*/index/year/16'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('2017'),
                        'url' => array('base' => '*/*/index/year/17'),
                        'field' => 'sid'
                    ),
                    array(
                        'caption' => $this->__('2018'),
                        'url' => array('base' => '*/*/index/year/18'),
                        'field' => 'sid'
                    )
                                      
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'edit',
                'is_system' => true,
            ));
        
        $this->addColumn('status', array(

          'header'    => $this->__('Commission Status'),
          
          'align'   => 'center',   
          'width' => '80px',

          'renderer' => 'Retailon_Commission_Block_Adminhtml_Test_Status',
           
       ));
       
       
        
       $this->addExportType('*/*/exportCommissionPrimaryCsv', $helper->__('CSV'));
       $this->addExportType('*/*/exportCommissionPrimaryExcel', $helper->__('Excel XML'));
      
        
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
      //  return $this->getUrl("*/*/view", array('seller_id' => $row->getId()));
    }
}
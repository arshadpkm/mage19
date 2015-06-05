<?php
class Retailon_Commission_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function viewAction()
    {
      $id=$this->getRequest()->getParam('seller_id');
      Mage::register('view_id',$id);
      $this->_initAction();
      $this->renderLayout();
    }
    public function discountinitAction()
    {
       $helper=Mage::helper('retailon_commission');
       $helper->updateDiscount();
    }
    
    
    public function paySaveAction()
    {
      $id=$this->getRequest()->getParam('id');
      $pay_amount=$this->getRequest()->getParam('pay_amount');
      $pay_type=$this->getRequest()->getParam('pay_type');
      echo $id."   ".$pay_amount."  ".$pay_type;
    } 
         
    public function payAction()
    {
      $id=$this->getRequest()->getParam('id');
      Mage::register('pay_id',$id);
      $this->loadLayout();
      $this->getLayout()->getBlock('head')
            ->setCanLoadExtJs(true);
      $this->_addContent($this->getLayout()
            ->createBlock('myblock/adminhtml_test_edit'));
//            ->addContent($this->getLayout()
  //                  ->createBlock('myblock/adminhtml_test_edit_form')
    //       );
      $this->renderLayout();
    }

    public function _initAction()
    {
        $write_comm = Mage::getSingleton( 'core/resource' );
        $acc=$write_comm->getConnection( 'core_write' );
        $sqlc = "CREATE TABLE IF NOT EXISTS `commission` (
`comm_id` int NOT NULL AUTO_INCREMENT,
`vendor_id` int(11) NOT NULL,
`comm_rate` int(11) NOT NULL,
`vendor_name` varchar(20) NOT NULL,
`total_comm` decimal(10,0) NOT NULL,
`total_price` int(20) NOT NULL,
`paid` int(11) NOT NULL,
`balance` decimal(20,0) NOT NULL,
`last_paid` int(11) NOT NULL,
`created_data` datetime NOT NULL,
`due` int(11) DEFAULT NULL,
PRIMARY KEY(`comm_id`))";

//$write_his = Mage::getSingleton( 'core/resource' )->getConnection( 'core_write' );
$sqlh = "CREATE TABLE IF NOT EXISTS `history` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `vd_name` varchar(100) NOT NULL,
  `last_paid` int(11) NOT NULL,
  `comm_rate` int(11) NOT NULL,
  `paid_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `due` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
PRIMARY KEY(`id`))";
        try{
            $acc->query($sqlc);
            flush($acc);
            try{
                $acc->query($sqlh);
                flush($acc);
            }catch(Exception $e)
            {
                echo $e->getMessage();
            }

        }catch(Exception $e)
        {
            echo $e->getMessage();
        }


        $this->loadLayout();
        return $this;
    }
    public function indexAction()
    {
           
           $Helper = Mage::helper('retailon_commission');
              
           $i = 0;
              
          $mode34 = Mage::getModel('storeconf/storeconf')->getCollection()->getData();
       
      
          foreach($mode34 as $key34 => $value34)
                {    
                $selleridnew[$i++]=$value34['seller_id'];                        
                }
                sort($selleridnew);
                
                
          foreach($selleridnew as $key45 => $value45)
                {                              
                     $flag = 0;    
                                                                     
                                      $mode33 = Mage::getModel('storeconf/storeconf')->getCollection()->getData();  
                                      foreach($mode33 as $key33 => $value33)
                                            {
                                             if($value45==$value33['seller_id'])
                                                  {
                                                   $seller_name_is=$value33['seller_name'];
                                                   $know_fixed_percent = $value33['rate'];                  
                                                   $seller_name_code_new=$value33['store_name']; 
                                                   $store_name_is = $value33['actual_store_name'];                                               
                                                   $seller_name_category= $value33['store_category'];
                                                   $comm_rate_new=$value33['etc2'];
                                                   break;
                                                   }
                                                                     
                                             }
                                                                                                                                                                          
                                                                  
                                       $totalsales_new = $Helper->fortotalsales($seller_name_category);
                                       //$total_paid = $Helper->fortotalpaid($seller_name_category);
                                        
                                        $totalcommission_new = $Helper->fortotalcommission($totalsales_new,$comm_rate_new);
                                        
                                        if($know_fixed_percent==0)
                                           {
                                              $totalcommission_new = $Helper->fortotalcommission($totalsales_new,$comm_rate_new);
                                              $rate_type_string="%";
                                           }
                                      if($know_fixed_percent==1)
                                         {
                                           $totalcommission_new = $Helper->fortotalcommission1($seller_name_category,$comm_rate_new);
                                           $rate_type_string="fixed";
                                         } 
                                        
                                        $due_new = $totalsales_new - $totalcommission_new;
                                        //Retailon 34
                                        
                                        
                                        
                                        $total = 0;
                                        
                                        $data255 = Mage::getModel('commission/sellershow')->getCollection()->getData();
                                        foreach($data255 as $key255 => $value255)
                                           {
                                             if($value45==$value255['seller_id'])
                                               {
                                               $data256 = Mage::getModel('commission/sellershow')->load($value255['id']);
                                               
                                               
                                               $data256->setTotalSales($totalsales_new);
                                               $data256->setCommissionRate($comm_rate_new);
                                               $data256->setRateType($rate_type_string);
                                               //$data256->setLastPaid($total);
                                               $data256->setTotalCommission($totalcommission_new);
                                               $maxtotal=0;
                                               $data785 = Mage::getModel('commission/sellercomm')->getCollection()->getData();
                                               if($data785)
                                                {
                                                foreach($data785 as $key785 => $value785)
                                                  {
                                                   if($value45==$value785['seller_id'])
                                                     {
                                                       if($value785['total_paid'] > $maxtotal)
                                                         {
                                                         $maxtotal = $value785['total_paid'];
                                                         }
                                                     }
                                                  }
                                                }
                                               $maxdue = $totalsales_new - $totalcommission_new - $maxtotal;
                                               $data256->setDue($maxdue);
                                               $data256->setTotalPaid($maxtotal);                         
                                               $data256->save();
                                               $flag = 1;
                                               }
                                           }
                                        if($flag!=1)
                                        {
                                        
                                        $data253 = Mage::getModel('commission/sellershow');
                                        $data253->setSellerId($value45);
                                        $data253->setSellerName($seller_name_is);
                                        $data253->setStoreId($seller_name_code_new);
                                        $data253->setStoreName($store_name_is);
                                        $data253->setTotalSales($totalsales_new);
                                        $data253->setCommissionRate($comm_rate_new);
                                        $data253->setLastPaid($total);
                                        $data253->setTotalCommission($totalcommission_new);
                                        $data253->setDue($due_new);
                                        $data253->setTotalPaid($total); 
                                        $data253->setRateType($rate_type_string);                        
                                        $data253->save();
                                        }
                                       
                    
                             
                 }  
                 
                  /* To delete the entries of deleted stores */
                $b=0;                               
                foreach (Mage::app()->getWebsites() as $website) 
                          {
                             foreach ($website->getGroups() as $group) 
                                {
                                 $stores = $group->getStores();
                                 foreach ($stores as $store) 
                                      {                                        
                                        $tempstore_id_array[$b++]= $store->getId();                                       
                                        $tempstore_status_array[$store->getId()]="NO";         
                                      }
                                 }
                           } 
                                                     
                 sort($tempstore_id_array);                                                  
                 $fordata324=Mage::getModel('commission/sellershow')->getCollection()->getData();           
                 $b=0;
                
                 $no_of_stores=count($tempstore_id_array);
                          for($b=0;$b<$no_of_stores;$b++)
                           {
                               foreach($fordata324 as $value324)
                                {
                                  if($value324['store_id']==$tempstore_id_array[$b])
                                   {
                                   $tempstore_status_array[$value324['store_id']]="YES";
                                   }
                                }

                           }
                           
                           
                    $c=0;        
                   foreach($tempstore_status_array as $key325=>$value325)
                    {
                      if($value325=="NO")
                      {
                       $temp326[$c++]=$key325;
                      }                    
                    }   
                    
                    
                       
                    $no_of_delete_stores=count($temp326);
               for($h=0;$h<$no_of_delete_stores;$h++)   
               {  
                 
                 foreach($fordata324 as $value325)
                  {
                    if($value325['store_id']==$temp326[$h])
                     {
                        $fordata327=Mage::getModel('commission/sellershow')->load($value325['id']); 
                       
                        $fordata327->delete(); 
                        $fordata328=Mage::getModel('commission/sellercomm')->getCollection()->getData();
                         foreach($fordata328 as $value328)
                          {
                           if($temp326[$h]==$value328['store_id'])
                            {
                              $fordata329=Mage::getModel('commission/sellercomm')->load($value328['id']);
                              $fordata329->delete();
                            }
                          }
                       
                     }
                  } 
               }                
        $this->_initAction();

        $this->renderLayout();

    }
public function saveAction()
{

    $req = $this->getRequest()->getParams();
    $vendorid=$req['vendor'];
    $comm=$req['comm'];
    $paid=$req['payout'];

    $user = Mage::getModel('admin/user')->load($vendorid);
    $vendorname=$user->getFirstname();



   /* $dat=Mage::getModel('commission/commission');
    $dat->setVendorName($vendorfname)
        ->setCommRate($comm)
        ->setVendorId($vendorid)
        ->save();
    die();*/
    $dat=Mage::getModel('commission/commission')->getCollection()->addFieldToFilter('vendor_id',$vendorid);
    foreach($dat as $data){

        $d=$data->getCommId();
        $ef =$data->getTotalPrice();
        $c= ($ef*$comm)/100;
        $balance = $ef-$c;
        Mage::log('Bal'.$balance,null,'lastpaid1.log',true);
      /*  $co =$data->getCommRate();
        $final_commision = ($ef * $co) / 100;*/



    }


    if($d)
    {
        $date=Mage::getModel('commission/commission')->load($d);
        $date->setVendorName($vendorname)
            ->setCommRate($comm)
            ->setData('total_comm',$c)
            ->setData('last_paid', $paid)
            ->setData('balance',$balance)
            ->save();
    }
    else{
        $date=Mage::getModel('commission/commission');

        $date->setVendorName($vendorname)
            ->setCommRate($comm)
            ->setVendorId($vendorid)
            ->save();
    }

    $url = Mage::getUrl('admincom/adminhtml_index/index/');


    $this->_redirectReferer($url);

}
    public  function payoutAction()
    {


        $par = $this->getRequest()->getParams();
        $vendorid=$par['v_id'];
        $vname=$par['v_name'];
        $paid=$par['payout'];
        $tp=$par['tp'];
        $tc=$par['tc'];
        $comm=$par['comm'];
        $du=$par['du'];
        $read = Mage::getSingleton( 'core/resource' )->getConnection( 'core_read' ); // To read from the database
        $productTable = Mage::getSingleton( 'core/resource' )->getTableName( 'history' );
        $query = "SELECT * FROM " . $productTable . " WHERE vendor_id=".$vendorid;
        $result = $read->query( $query );


        $add = 0;
        while ( $row = $result->fetch() ) {
            $l=$row['last_paid'];

            //echo $l;
            $add += $row['last_paid'];

        }
        $adds = $add + $paid;
        $m=($par['tp']-$par['tc']);
        if($du)
        {
        $remain_due=$du-$paid;
        }
        else
        {
         $remain_due=$m-$paid;
        }

        if(!empty($par['demo'])){
            $resource = Mage::getSingleton('core/resource');
            $writeConnection = $resource->getConnection('core_write');
            $table = $resource->getTableName('history');
            $date = date('Y-m-d H:i:s');
            $query="Insert into {$table}(vendor_id,vd_name,last_paid,comm_rate,paid_date,due,amount_paid)VALUES(' $vendorid','$vname','$paid',
           '$comm','$date',' $remain_due','$adds')";
            $writeConnection->query($query);


        }
       // $connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        $a= Mage::getModel('commission/commission')->getCollection()->addFieldToFilter('vendor_id',$vendorid);

      foreach($a as $b){
      $b->setData('last_paid',$paid);
     $b->setData('balance',$remain_due)->save();
      }


        $url = Mage::getUrl('admincom/adminhtml_index/index/');
        $this->_redirectReferer($url);


    }
   
   public function commcalculationAction()
     {
     
     
     
     
     
    
      $sellerid = $this->getRequest()->getParam('id');
      $payamount = $this->getRequest()->getParam('pay_amount');
      $paytype = $this->getRequest()->getParam('pay_type'); 
      $comments = $this->getRequest()->getParam('pay_cmd'); 
      
      date_default_timezone_set('Asia/Calcutta');      
      $date1 = date("Y-m-d H:i:s"); 
     // $str2 = substr($date1,5,2);
   
       $model = Mage::getModel('storeconf/storeconf')->getCollection()->getData();
       
        
       foreach($model as $key => $value)
         {
           if($sellerid==$value['seller_id'])
             {
             $seller_name_is=$value['seller_name'];
             $seller_name_category = $value['store_category'];
             $seller_name_code = $value['store_name']; 
             $store_name_is = $value['actual_store_name'];           
             $know_fixed_percent = $value['rate'];
             $comm_rate = $value['etc2'];
             break;
             }
           
         } 
            
      $Helper = Mage::helper('retailon_commission');
      
        
        $totalsales = $Helper->fortotalsales($seller_name_category); 
        
        if($know_fixed_percent==0)
         {
         $totalcommission = $Helper->fortotalcommission($totalsales,$comm_rate);
         $rate_type_str="%";
         }
        if($know_fixed_percent==1)
          {
          $totalcommission = $Helper->fortotalcommission1($seller_name_category,$comm_rate);
          $rate_type_str="fixed";
          } 
      
       
      
      $lastid = 1;
      $flag1 = 0;
      $flag2 = 0;
      $flag3 = 0;
      $data1 = Mage::getModel('commission/sellercomm')->getCollection()->getData();
      if(!$data1)
        {
         $due =$totalsales - $totalcommission - $payamount;         
         $totalpaid = $payamount;
         $flag1 = 1;
          
        }
      foreach($data1 as $key1 => $value1)
        {
         if(($sellerid==$value1['seller_id'])&&($seller_name_is==$value1['seller_name']))
           {
              if($totalcommission==$value1['total_commission'])
                {
                 $id1 = $value1['id']; 
                    if($id1 > $lastid)
                      {
                      $lastid = $id1;
                      }       
                 $flag2 = 1;
                }
              else
                 {
                  $id2 = $value1['id'];  
                    if($id2 > $lastid)
                      {
                      $lastid = $id2;
                      }                
                 $flag3 = 1;
                 }  
           }
        }  
        
        if($flag2 == 1)
         {
         $data3 = Mage::getModel('commission/sellercomm')->load($lastid);
        
         $due1 = $data3->getDue();
         $totalpaid1 = $data3->getTotalPaid();
         
         $totalpaid =$totalpaid1 + $payamount;
         $due=$totalsales - $totalcommission - $totalpaid;
         }
         if($flag3 == 1)
         {
         $data4 = Mage::getModel('commission/sellercomm')->load($lastid);
          
         $due2 = $data4->getDue();
         $totalpaid2 = $data4->getTotalPaid();
         
         $totalpaid =$totalpaid2 + $payamount;
         $due=$totalsales - $totalcommission - $totalpaid;
          
         }
       if(($flag1!=1)&&($flag2!=1)&&($flag3!=1))
        {
        
        $due =$totalsales - $totalcommission - $payamount;
        $totalpaid = $payamount;
        
        }
       $data2 = Mage::getModel('commission/sellercomm');
       $data2->setSellerId($sellerid);
       $data2->setSellerName($seller_name_is);
       $data2->setStoreId($seller_name_code);
       $data2->setStoreName($store_name_is);
       $data2->setTotalSales($totalsales);
       $data2->setCommissionRate($comm_rate);
       $data2->setTotalCommission($totalcommission);
       $data2->setPayAmount($payamount);
       $data2->setPayType($paytype);
       $data2->setPaidDate($date1);
       $data2->setDue($due);
       $data2->setTotalPaid($totalpaid);
       $data2->setComments($comments);
       $data2->save();
       
      
       
             
       $data123 = Mage::getModel('commission/sellershow')->getCollection()->getData();
        if(!$data123)
         {
          $data24 = Mage::getModel('commission/sellershow');
          $data24->setSellerId($sellerid);
          $data24->setSellerName($seller_name_is);
          $data24->setStoreId($seller_name_code);
          $data24->setStoreName($store_name_is);
          $data24->setTotalSales($totalsales);
          $data24->setCommissionRate($comm_rate);
          $data24->setTotalCommission($totalcommission);
          $data24->setLastPaid($payamount);
          $data24->setLastPaidDate($date1);
          $data24->setDue($due);
          $data24->setTotalPaid($totalpaid);
          $data24->setRateType($rate_type_str);
          $data24->save();
         }
         foreach($data123 as $key123 => $value123)
           {
             if($sellerid==$value123['seller_id'])
               {
                $data25 = Mage::getModel('commission/sellershow')->getCollection();
                foreach($data25 as $d)
                {
                if($d->getSellerId()==$sellerid)
                {
                $id=$d->getId();
             //echo $id."   ".$sellerid;
                $data253 = Mage::getModel('commission/sellershow')->load($id);
                $data253->setSellerId($sellerid);
                $data253->setSellerName($seller_name_is);
                $data253->setStoreId($seller_name_code);
                $data253->setStoreName($store_name_is);
                $data253->setTotalSales($totalsales);
                $data253->setCommissionRate($comm_rate);
                $data253->setTotalCommission($totalcommission);
                $data253->setLastPaid($payamount);
                $data253->setLastPaidDate($date1);
                $data253->setDue($due);
                $data253->setTotalPaid($totalpaid);
                $data253->setRateType($rate_type_str);
                $data253->save();
                
                break;
                }
                }
                
               }
              
           }
           
       
       
           
      
       $this->_redirect('*/*/');  
     }
  
   public function exportCommissionPrimaryCsvAction()
    {
        $fileName = 'all_sellers_commission.csv';
        $grid = $this->getLayout()->createBlock('myblock/adminhtml_test_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
 
  public function exportCommissionPrimaryExcelAction()
    {
        $fileName = 'all_sellers_commission.xml';
        $grid = $this->getLayout()->createBlock('myblock/adminhtml_test_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
  public function exportCommissionHistoryCsvAction()
    {
        $fileName = 'seller_commission_history.csv';
        $grid = $this->getLayout()->createBlock('myblock/adminhtml_show_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
 
  public function exportCommissionHistoryExcelAction()
    {
        $fileName = 'seller_commission_history.xml';
        $grid = $this->getLayout()->createBlock('myblock/adminhtml_show_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
  
}
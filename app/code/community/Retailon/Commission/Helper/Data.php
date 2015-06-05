<?php
class Retailon_Commission_Helper_Data extends Mage_Core_Helper_Abstract
{
  
  
   public function month_sales()
    {
      $sum = 0;
    $da22 = Mage::getModel('sales/order_item')->getCollection()->getData();

    $xyz = 2;
     $xx= 01;
        foreach($da22 as $value)
         {  
             
             $str1 = $value['updated_at'];
             $str2 = substr($str1,5,2);
           if(($value['store_id'])==$xyz)
            {
              if($str2==$xx)
              {
                   $remainder = 0;
                   $price_value = $value['price'];
                   $order_quantity = $value['qty_ordered'];
                   $cancel_quantity = $value['qty_canceled'];
                    $remainder =($order_quantity - $cancel_quantity);
                    
                       if($remainder > 0)
                         {
                          $sum +=($remainder * $price_value);
                         } 
              }               
               
            }
        }
    // echo "SUM = ".$sum; 
      
    }  
  
  public function fortotalsales($get_seller_category)
    {
      
     $resource = Mage::getSingleton('core/resource');
      $readConnection = $resource->getConnection('core_read');

     $allproductids = "SELECT product_id FROM catalog_category_product where category_id=$get_seller_category ";
     $allproductresult = $readConnection->fetchAll($allproductids);
     $prdIds =array();
     foreach($allproductresult as $value4)
      {
    $prdIds[]=$value4['product_id'];
      }
 
    $no_of_ele=count($prdIds);
    $sum=0;
     
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
           	      	$amount="SELECT base_row_total_incl_tax FROM sales_flat_order_item where order_id=$required_order_id and product_id=$value3 ";
           	      	$temp1=$readConnection->fetchOne($amount);
           	      	$sum+=$temp1;
           	      	
           	      	//$tot_paid="SELECT base_row_total_incl_tax FROM seller_commission_calculate where order_id=$required_order_id and product_id=$value3 ";
           	      	//$temp2=$readConnection->fetchOne($tot_paid);
           	      	
           	      }
           	   }
           }  
           
     }
  
  return $sum;  
     
      
    }
  public function fortotalcommission($x,$y)
    {
     $total = ($x * $y )/100;
    return $total;
    } 
    
   public function fortotalcommission1($get_seller_category,$fixed_rate)
    {
    
       $resource = Mage::getSingleton('core/resource');
      $readConnection = $resource->getConnection('core_read');

     $allproductids = "SELECT product_id FROM catalog_category_product where category_id=$get_seller_category ";
     $allproductresult = $readConnection->fetchAll($allproductids);
     $prdIds =array();
     foreach($allproductresult as $value4)
      {
    $prdIds[]=$value4['product_id'];
      }
 
    $no_of_ele=count($prdIds);
    $qty_ship=0;
     
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
           	      	
           	      	$amount="SELECT qty_shipped FROM sales_flat_order_item where order_id=$required_order_id and product_id=$value3 ";
           	      	$temp1=$readConnection->fetchOne($amount);
           	      	$qty_ship+=$temp1;
           	      }
           	   }
           }  
           
     }
       
       return $qty_ship*$fixed_rate; 
    } 
    public function newfunction($x,$y)
    {
    $lastpaid = 0;
    $ld = 1;
    $flag = 0;
    $data = Mage::getModel('commission/sellercomm')->getCollection()->getData();
     
    foreach($data as $key => $value)
        {
           if(($x==$value['seller_id'])&&($y==$value['seller_name']))
                 {   
                 $id7 = $value['id']; 
                    if($id7 > $ld)
                      {
                      $ld = $id7;
                      } 
                   $flag = 1;   
                 }         
        }
      if($flag == 1)
        {
       $data8 =  Mage::getModel('commission/sellercomm')->load($ld);
       $lastpaid = $data8->getPayAmount();
        }    
    
    return $lastpaid;
    }
    
    public function newfunction1($x,$y)
    {
    $lastpaiddate = " ";
    $ld = 1;
    $flag = 0;
    $data1 = Mage::getModel('commission/sellercomm')->getCollection()->getData();
     
    foreach($data1 as $key => $value1)
        {
           if(($x==$value1['seller_id'])&&($y==$value1['seller_name']))
                 {   
                 $id1 = $value1['id']; 
                    if($id1 > $ld)
                      {
                      $ld = $id1;
                      } 
                   $flag = 1;   
                 }         
        }
      if($flag == 1)
        {
       $data2 =  Mage::getModel('commission/sellercomm')->load($ld);
       $lastpaiddate = $data2->getPaidDate();
        }    
    
    return $lastpaiddate;
    
    }
    public function newfunction2($x,$y,$z)
    {
     
      $lastdue = $z;
      
     
    $ld = 1;
    $flag = 0;
    $data2 = Mage::getModel('commission/sellercomm')->getCollection()->getData();
     
     
    foreach($data2 as $key2 => $value2)
        {
           if(($x==$value2['seller_id'])&&($y==$value2['seller_name']))
                 {   
                 $id2 = $value2['id']; 
                    if($id2 > $ld)
                      {
                      $ld = $id2;
                      } 
                   $flag = 1;   
                 }         
        }
      if($flag == 1)
        {
       $data3 =  Mage::getModel('commission/sellercomm')->load($ld);
       $lastdue = $data3->getDue();
        }    
    
    return $lastdue;
    }
    public function newfunction3($x,$y)
    {
    $totalpaid = 0;
    $ld = 1;
    $flag = 0;
    $data6 = Mage::getModel('commission/sellercomm')->getCollection()->getData();
     
    foreach($data6 as $key6 => $value6)
        {
           if(($x==$value6['seller_id'])&&($y==$value6['seller_name']))
                 {   
                 $id11 = $value6['id']; 
                    if($id11 > $ld)
                      {
                      $ld = $id11;
                      } 
                   $flag = 1;   
                 }         
        }
      if($flag == 1)
        {
       $data11 =  Mage::getModel('commission/sellercomm')->load($ld);
       $totalpaid = $data11->getTotalPaid();
        }    
    
    return $totalpaid;
    }
    
    
    // Discount Area
    
    
    public function checkdelDiscount($pid)
    {
        $youlo_discount=Mage::getModel('commission/youlo')->getCollection();
        foreach($youlo_discount as $y)
        {
          Mage::log($y->getProductId()." --  ".$pid,null,'del.log');
          if($y->getProductId()==$pid)
          {
              $helper=Mage::helper('retailon_commission');
              $y->delete();
         /*     $resource = Mage::getSingleton('core/resource');
              $writeConnection = $resource->getConnection('core_write');
	      $tableName = $resource->getTableName('commission/youlo');
              $query = "TRUNCATE TABLE ".$tableName;
	      $writeConnection->query($query);*/
       
              $helper->updateDiscount($pid);
              break;
          }
        }
    }
    public function checkDiscount($pid,$discount,$cat_id)
    {
    
        Mage::log($pid."  ".$discount."  ".$cat_id,null,'discount.log');
      /*  $youlo_discount=Mage::getModel('commission/youlo')->getCollection();
        foreach($youlo as $y)
         $y->delete();*/
       
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
	$tableName = $resource->getTableName('commission/youlo');
        $query = "TRUNCATE TABLE ".$tableName;
	$writeConnection->query($query);
       
       
       
        $helper=Mage::helper('retailon_commission');
        $helper->updateDiscount();
    /*    Mage::log($pid." ".$discount." ".$cat_id,null,'dis.log');
        $category= $categories = Mage::getModel('catalog/category')->load($cat_id);
        if ($category->getIsActive())
        {
         $youlo=Mage::getModel('commission/youlo')->getCollection();
         $flag=false;
         foreach($youlo as $y)
         {
            if($y->getCategoryId()==$cat_id)
            {
                $flag=true;
                $big_discount=$y->getDiscount();
                $big_pid=$y->getProductId();
                $did=$y->getId();
                break;
            }
         }
         $youlo_discount=Mage::getModel('commission/youlo');
         Mage::log($flag." ".$did." ".$big_discount,null,'dis.log');

         if($flag)
         {
            if($big_discount<$discount)
            {
                $youlo_discount->load($did);
                $youlo_discount->setProductId($pid);
                $youlo_discount->setDiscount($discount);
                $youlo_discount->save();
            }
            else
            {
                if($big_pid==$pid && $big_discount>$discount)
                {
                    $helper=Mage::helper('retailon_commission');
                    $helper->updateDiscount();
                }
            }
         }
         else
         {
            $youlo_discount->setStoreId($cat_id);
            $youlo_discount->setCategoryId($cat_id);
            $youlo_discount->setProductId($pid);
            $youlo_discount->setDiscount($discount);
            $youlo_discount->save();
         }
        }*/

    }
    public function updateDiscount($del_pid=NULL)
    {
            $categories = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('id')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url_key')
            ->addAttributeToSelect('url')
            ->addAttributeToSelect('is_active');
        foreach ($categories as $category)
        {
            if ($category->getIsActive()) { // Only pull Active categories
  //              $name = $category->getName();
    //            $url_key = $category->getUrlKey();
      //          $url_path = $category->getUrl();

            $cat_id = $category->getId();
            $collection = Mage::getModel('catalog/product')->getCollection();
            $big_discount=-1;
            $big_pid=NULL;
            foreach($collection as $c)
            {
                $pid=$c->getId();
                if($pid==$del_pid)
                    continue;

                $product = Mage::getModel('catalog/product')->load($pid);

                $categoryId=$ids = $product->getCategoryIds();

                //$discount=$product->getDiscountValue();
                $discount=(int)((($product->getPrice()-$product->getSpecialPrice())/$product->getPrice())*100);
             
            //    Mage::log($categoryId,null,'discount.log');


                $flag=false;
                foreach($categoryId as $cat)
                {
                 if($cat_id==$cat)
                 {
                     $flag=true;
                 }
                }
                if($flag)
                {
                    if($big_discount<$discount)
                    {
                        $big_discount=$discount;
                        $big_pid=$pid;
                    }
                }
            }
            if($big_pid!=NULL)
            {
                $youlo=Mage::getModel('commission/youlo')->getCollection();
                $flag=true;
                foreach($youlo as $y)
                {
                    if($y->getCategoryId()==$cat_id)
                    {
                        $flag=false;
                        break;
                    }
                }
                $youlo_discount=Mage::getModel('commission/youlo');
                if($flag)
                {
                      $str_id=NULL;
                      $sellerstores=Mage::getModel('commission/seller')->getCollection();
		      foreach($sellerstores as $store)
      		      {
		        if($store->getStoreCategory()==$cat_id)
        		{
 			     $str_id=$store->getStoreName();
 			     $str_sub_id=$store->getData('store_sub_category');
	                     break;
        		}
      		      }

          //           Mage::log("Store   ".$str_id."  ".$cat_id,null,'discount.log');

                    $youlo_discount->setStoreId($str_id);
                    $youlo_discount->setCategoryId($cat_id);
                    $youlo_discount->setData('store_sub_category',$str_sub_id);
                    $youlo_discount->setProductId($big_pid);
                    $youlo_discount->setDiscount($big_discount);
                }
                else
                {
                    $youlo_discounts=Mage::getModel('commission/youlo')->getCollection();
                    foreach($youlo_discounts as $yy)
                    {
                        if($yy->getCategoryId()==$cat_id)
                        {
                            $did=$yy->getId();
                            break;
                        }
                    }

                    $youlo_discount->load($did);
                    $youlo_discount->setProductId($big_pid);
                    $youlo_discount->setDiscount($big_discount);
                }
                Mage::log("Beg   ".$str_id."  ".$cat_id,null,'discount.log');
                if($str_id!=NULL)
                {
                 Mage::log("Store   ".$str_id."  ".$cat_id,null,'discount.log');
                
                 $youlo_discount->save();
                }
            }
          }
        }
    }
    
    
    
  
}
	 
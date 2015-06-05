<?php

class Retailon_Storeconf_Adminhtml_StoreController extends Mage_Adminhtml_Controller_Action
{
  public function  indexAction()
    {
       // echo 'store controller index action';
        $this->loadLayout()->renderLayout();
    }

     public function  commissionAction()
    {
        //  echo 'store controller index action';
        $this->loadLayout()->renderLayout();
    }


    public function  setupAction()
    {
        //echo 'store controller setup action';


        $req =  $this->getRequest()->getParams();
        $storename=$req['storename'];
        $code=$req['code'];


        $fname=$req['fname'];

        $lname=$req['lname'];

        $email=$req['email'];

        $password=$req['password'];


//validation check


$category = Mage::getModel('catalog/category')->getCollection()->addAttributeToSelect('name')->addAttributeToFilter('level',1);
$allrootCategories=array();
foreach($category as $data)
{
$allrootCategories[]=$data->getName();
}
$customers = Mage::getModel('customer/customer')->getCollection();
$allCustomersemail=array();
foreach($customers as $custdata)
{
$allCustomersemail[]=$custdata->getData('email');
}
$stores = Mage::getModel('core/store')->getCollection();
$allStorenames=array();
$allStorecodes=array();
foreach($stores as $store)
{
   $allStorenames[]=$store->getData('name');
   $allStorecodes[]=$store->getData('code');
}


$lasturl= Mage::helper('adminhtml')->getUrl("storesetup/adminhtml_store/index");


if(in_array( $storename,$allrootCategories))
{
Mage::getSingleton('core/session')->addError('The Storename or Rootcategory "'.$storename.'" - already exists');

$this->_redirectUrl($lasturl);

}

elseif(in_array( $storename,$allStorenames))
{

Mage::getSingleton('core/session')->addError('The Storename or Rootcategory "'.$storename.'" - already exists');

$this->_redirectUrl($lasturl);
}
elseif(in_array( $code,$allStorecodes))
{
Mage::getSingleton('core/session')->addError('The url code "'.$code.'" - already exists');

$this->_redirectUrl($lasturl);

}
elseif(in_array($email,$allCustomersemail))
{
Mage::getSingleton('core/session')->addError('The email  "'.$email.'" - already exists');

$this->_redirectUrl($lasturl);

}
else
{

//validation check end


 //create root category

        // Create category object
        $category = Mage::getModel('catalog/category');
        //$category->setStoreId(0); // No store is assigned to this category

        $rootCategory['name'] = $storename;
        $rootCategory['path'] = "1"; // this is the catgeory path - 1 for root category
      //  $rootCategory['display_mode'] = "PRODUCTS";
        $rootCategory['is_active'] = 1;
        $rootCategory['is_anchor'] = 1;

        $category->addData($rootCategory);

        try {
            $category->save();
          $rootCategoryId = $category->getId();
        }
        catch (Exception $e){
            echo $e->getMessage();
        }


//Create New store

//If you need do it from frontend - add line Mage::registry('isSecureArea'); before this code.

//#add Website
        /** @var $website Mage_Core_Model_Website */
      /*  $website = Mage::getModel('core/website');
        $website->setCode('<your_website_code_here>')
            ->setName('<your_website_name>')
            ->save();*/

//#add StoreGroup
        /** @var $storeGroup Mage_Core_Model_Store_Group */
        $storeGroup = Mage::getModel('core/store_group');
        $storeGroup->setWebsiteId(1)  //1 is Main Website Id
            ->setName($storename)
            ->setRootCategoryId($rootCategoryId)
            ->save();

//#add Store
        /** @var $store Mage_Core_Model_Store */
        $store = Mage::getModel('core/store');
        $store->setCode($code)
            ->setWebsiteId($storeGroup->getWebsiteId())
            ->setGroupId($storeGroup->getId())
            ->setName($storename)
            ->setIsActive(1)
            ->save();

//Create customer
        $customer = Mage::getModel("customer/group")->getCollection()->addFieldToFilter('customer_group_code',Mage::getStoreConfig('retailon/retailon_group/retailon_input',Mage::app()->getStore()));
        foreach($customer as $data)
        {
            $groupId=$data->getId();
        }


        $customer = Mage::getModel("customer/customer");
        $customer   ->setWebsiteId(1)   //! is main website id
         //   ->setStore($store)
            ->setFirstname($fname)
            ->setLastname($lname)
            ->setEmail($email)
            ->setGroupId($groupId)   //6 is Seller Group Id
            ->setPassword($password);

        try{
            $customer->save();
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

      /*  $url = Mage::getSingleton('core/session')->getLastUrl();
        $this->_redirectReferer($url);*/

        $storeconf = Mage::getModel('storeconf/storeconf');
        $storeconf->setData('store_name',$store->getId())
       		->setData('actual_store_name',$store->getName())
        	  ->setData('store_category',$rootCategoryId)
        	  ->setData('seller_id',$customer->getId())
        	  ->setData('seller_name',$customer->getName())
        	  ->setData('seller_email',$customer->getEmail())
        ->save();

     //  Mage::log('');

         $url= Mage::helper('adminhtml')->getUrl("admin_storeconf/adminhtml_storeconf/edit",array('id'=>$storeconf->getId()));
        $this->_redirectUrl($url);

}




    }

    public function displayAction()
    {
    echo 'yes';
    $this->loadLayout()->renderLayout();

    }

      public function deleteAction()
    {
     //echo 'delete action ';
     $this->loadLayout()->renderLayout();

    }

    public function listsAction()
    {
   // echo 'list action';
    $this->loadLayout()->renderLayout();

    }
      public function reportsAction()
    {
   // echo 'list action';
    $this->loadLayout()->renderLayout();

    }

      public function reportsviewAction()
    {
   // echo 'list action';
    $this->loadLayout()->renderLayout();

    }


  /*    public function confdeleteAction()
    {

     $id= $this->getRequest()->getParam('id');


     $str = Mage::getSingleton('storeconf/storeconf')->load($id);

 $seller_id=$str->getSellerId();

$store_category=$str->getStoreCategory();

$store_id=$str->getStoreName();

$category = Mage::getModel('catalog/category')->load($store_category);
  $products = Mage::getModel('catalog/product')
    ->getCollection()
    ->addCategoryFilter($category)
    ->load();

    $pr_id=array();
    foreach($products as $data)
    {
   $pr_id[]=$data->getId();
    }
    $noproducts='';
  if(!$pr_id)
  {
$noproducts =1;
  }



$mod = Mage::getModel('commission/sellershow')->getCollection()->addFieldToFilter('seller_id',$seller_id);
foreach($mod as $comm)
{
$total_comm =$comm->getData('total_commission');
$total_paid=$comm->getData('total_paid');
}
$nodue='';
if($total_comm == $total_paid)
{
$nodue=1;
}
//delete

if($noproducts && $nodue)
{
//store view
 $store = Mage::getModel('core/store')->load($store_id);
 $storeGroup = Mage::getModel('core/store_group')->load($store->getGroupId())->delete();

 //category
 $category = Mage::getModel('catalog/category')->load($store_category)->delete();

//seller
$customer = Mage::getModel("customer/customer")->load($seller_id)->delete();

//delete from storeconf table
$last_step = Mage::getSingleton('storeconf/storeconf')->load($id)->delete();

echo 'yes';
}
else
{
echo 'no';
}*/

    //store view
    //  $store = Mage::getModel('core/store')->load($store_id);
      // store group
   //  $storeGroup = Mage::getModel('core/store_group')->load($store->getGroupId())->delete();



         //category
        //  $category = Mage::getModel('catalog/category')->load($store_category)->delete();

       //seller
 	//$customer = Mage::getModel("customer/customer")->load($seller_id)->delete();


 //$storeGroup = Mage::getModel('core/store_group')->load(29)->delete();
    //$category = Mage::getModel('catalog/category')->load($store_category)->delete();
 /*
   try
    {
             $category = Mage::getModel('catalog/category')->load($store_category)->delete();
    }
        catch (Exception $e)
   {
            echo 'Cannot Delete this Store';
   }
   */
//print_r();

    //}

 public function confdeleteAction()
    {
     
     $id= $this->getRequest()->getParam('id');
    
     
     $str = Mage::getSingleton('storeconf/storeconf')->load($id);
    
 $seller_id=$str->getSellerId();
    
$store_category=$str->getStoreCategory();
    
$store_id=$str->getStoreName();

$category = Mage::getModel('catalog/category')->load($store_category);
  $products = Mage::getModel('catalog/product')
    ->getCollection()
    ->addCategoryFilter($category)
    ->load();
    
    $pr_id=array();
    foreach($products as $data)
    {    
   $pr_id[]=$data->getId();
    }
    $noproducts='';
  if(!$pr_id)
  {
$noproducts =1;
  }

 

$mod = Mage::getModel('commission/sellershow')->getCollection()->addFieldToFilter('seller_id',$seller_id);
foreach($mod as $comm)
{
$total_comm =$comm->getData('total_commission');
$total_paid=$comm->getData('total_paid');
}
$nodue='';
if($total_comm == $total_paid)
{
$nodue=1;
}
//delete

if($noproducts && $nodue)
{
//store view  
if($store_id>1)
{
 $store = Mage::getModel('core/store')->load($store_id);
 

 $storeGroup = Mage::getModel('core/store_group')->load($store->getGroupId())->delete();
 
 //category
 $category = Mage::getModel('catalog/category')->load($store_category)->delete();
       
//seller
$customer = Mage::getModel("customer/customer")->load($seller_id)->delete();

//delete from storeconf table
$last_step = Mage::getSingleton('storeconf/storeconf')->load($id)->delete();

system('rm -rf '.$store->getCode());
echo 'yes';
}
}	
else
{
echo 'no';
}
      
    //store view  
    //  $store = Mage::getModel('core/store')->load($store_id);
      // store group 
   //  $storeGroup = Mage::getModel('core/store_group')->load($store->getGroupId())->delete();
     

     
         //category
        //  $category = Mage::getModel('catalog/category')->load($store_category)->delete();
       
       //seller
 	//$customer = Mage::getModel("customer/customer")->load($seller_id)->delete();

                     
 //$storeGroup = Mage::getModel('core/store_group')->load(29)->delete();
    //$category = Mage::getModel('catalog/category')->load($store_category)->delete();
 /*   
   try
    {
             $category = Mage::getModel('catalog/category')->load($store_category)->delete();
    }
        catch (Exception $e)
   {
            echo 'Cannot Delete this Store';
   }
   */
//print_r();
    
    }




}
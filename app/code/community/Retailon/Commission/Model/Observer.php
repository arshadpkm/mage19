<?php
/**
 * Created by PhpStorm.
 * User: RetailOn
 * Date: 1/13/15
 * Time: 3:32 PM
 */
class Retailon_Commission_Model_Observer extends Varien_Event_Observer // Mage_Core_Model_Observer
{
    public function  catalog_product_delete_after($observer)
    {
        $product = $observer->getEvent()->getProduct();

        $pid=$product->getId();
        $helper=Mage::helper('retailon_commission');
        $helper->checkdelDiscount($pid);
    }
    public function catalog_product_save_after($observer)
    {
         $product = $observer->getEvent()->getProduct();

        $pid=$product->getId();
    //    $storeId=$product->getStoreIds()[0];
        $discount=$product->getDiscountValue();
        //$categoryId= $product->getCategoryIds()[0];
        $categoryId =39;
        //$category->load($ids[0]);
     //   Mage::log($product->getCategoryIds(),null,'disc.log');
       // $helper=Mage::helper('retailon_commission');
      //  $helper->checkDiscount($pid,$discount,$categoryId);
    }

}
<?php
class Retailon_Orders_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('retailon_order_grid');
        $this->setDefaultSort('increment_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        // Get current logged in user
        $current_user = Mage::getSingleton( 'admin/session' )->getUser();
//print_r($current_user);
//var_dump($current_user);
//echo( $current_user->getUserId());
        // Limit only for vendors
       if ( $current_user->getRole()->getRoleId() == Mage::getStoreConfig( 'marketplace/marketplace/vendors_role' ) ) {
          // echo( $current_user->getUserId());
           $my_products = Mage::getModel( 'marketplace/marketplaceproducts' )
               ->getCollection()
               ->addFieldToSelect( 'product_id' )
               ->addFieldToFilter( 'user_id', $current_user->getUserId() )
               ->load();
//echo($my_products->getSelect());
           if($my_products->getData()){

           $my_product_array = array();
           foreach ( $my_products as $product ) {
               $my_product_array[] = $product->getProductId();
               $entity = Mage::getModel('sales/order_item')
                   ->getCollection()
                   ->addFieldToSelect('order_id')
                   ->addFieldToFilter('product_id',$my_product_array)
                   ->load();
              // echo $entity->getSelect();// will print sql query

           }
           $d=$entity->getData();
//print_r($d);
           if($d){

               $collection = Mage::getResourceModel('sales/order_collection')
               // My code
                 ->addFieldToFilter('entity_id', $d)
            ->join(array('a' => 'sales/order_address'), 'main_table.entity_id = a.parent_id AND a.address_type != \'billing\'', array(
                'city'       => 'city',
                'country_id' => 'country_id'
            ))

             //  ->join(Mage::getConfig()->getTablePrefix().'catalog_product_entity_varchar', 'main_table.products_id ='.Mage::getConfig()->getTablePrefix().'catalog_product_entity_varchar.entity_id',array('value'))
            ->join(array('c' => 'customer/customer_group'), 'main_table.customer_group_id = c.customer_group_id', array(
                'customer_group_code' => 'customer_group_code'
            ))


                ->addExpressionFieldToSelect(
                'fullname',
                'CONCAT({{customer_firstname}}, \' \', {{customer_lastname}})',
                array('customer_firstname' => 'main_table.customer_firstname', 'customer_lastname' => 'main_table.customer_lastname'))
            ->addExpressionFieldToSelect(
                'products',
                '(SELECT GROUP_CONCAT(\' \', x.name)
                    FROM sales_flat_order_item x
                    WHERE {{entity_id}} = x.order_id
                        AND x.product_type != \'configurable\')',
                array('entity_id' => 'main_table.entity_id')
            )

           ;
             parent::_prepareCollection();
           $this->setCollection($collection);
        return $this;

       }
           else
           {
               echo("Current there are no purchases on your product. Thank you");
           }
           }
           else{
               echo("You don't have product in your store. Add products First.");
           }
       }

       else{
           echo("Please Login as Vendor and you will see orders on your products.<br>");
          // $current_user = Mage::getSingleton( 'admin/session' )->getUser()->getUserId();
          // echo($current_user);
        }

}
    protected function _prepareColumns()
    {
        $helper = Mage::helper('retailon_orders');
        $currency = (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE);
        $this->addColumn('increment_id', array(
            'header' => $helper->__('Order #'),
            'index'  => 'increment_id'
        ));
        $this->addColumn('purchased_on', array(
            'header' => $helper->__('Purchased On'),
            'type'   => 'datetime',
            'index'  => 'created_at'
        ));
        $this->addColumn('products', array(
            'header'       => $helper->__('Products Purchased'),
            'index'        => 'products',
            'filter_index' => '(SELECT GROUP_CONCAT(\' \', x.name) FROM sales_flat_order_item x WHERE main_table.entity_id = x.order_id AND x.product_type != \'configurable\')'
        ));
        $this->addColumn('fullname', array(
            'header'       => $helper->__('Name'),
            'index'        => 'fullname',
            'filter_index' => 'CONCAT(customer_firstname, \' \', customer_lastname)'
        ));
        $this->addColumn('city', array(
            'header' => $helper->__('City'),
            'index'  => 'city'
        ));
        $this->addColumn('country', array(
            'header'   => $helper->__('Country'),
            'index'    => 'country_id',
            'renderer' => 'adminhtml/widget_grid_column_renderer_country'
        ));
        $this->addColumn('customer_group', array(
            'header' => $helper->__('Customer Group'),
            'index'  => 'customer_group_code'
        ));
        $this->addColumn('grand_total', array(
            'header'        => $helper->__('Grand Total'),
            'index'         => 'grand_total',
            'type'          => 'currency',
            'currency_code' => $currency
        ));
        $this->addColumn('shipping_method', array(
            'header' => $helper->__('Shipping Method'),
            'index'  => 'shipping_description'
        ));
        $this->addColumn('order_status', array(
            'header'  => $helper->__('Status'),
            'index'   => 'status',
            'type'    => 'options',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
        $this->addExportType('*/*/exportInchooCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportInchooExcel', $helper->__('Excel XML'));
        return parent::_prepareColumns();
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}

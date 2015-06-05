<?php

class Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId("storeconfGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("storeconf/storeconf")->getCollection();
        //->addAttributeToSelect('short_description');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }



   protected function _prepareColumns()
    {
  
    
        $this->addColumn("id", array(
            "header" => Mage::helper("storeconf")->__("ID"),
            "align" =>"right",
            "width" => "50px",
            "type" => "number",
            "index" => "id"
        ));  
               
        $this->addColumn('seller_id', array(
            'header' => Mage::helper('storeconf')->__('Seller Name'),
            'index' => 'seller_id',
            'type' => 'options',
            'options'=>Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray0()
        ));

        $this->addColumn("seller_email", array(
            "header" => Mage::helper("storeconf")->__("Seller Email"),
            "index" => "seller_email"
        ));

  


        $this->addColumn("store_contact", array(
            "header" => Mage::helper("storeconf")->__("Store Contact"),
            "index" => "store_contact",
        ));
 
        $this->addColumn('store_sub_category', array(
            'header' => Mage::helper('storeconf')->__('Line of Business'),
            'index' => 'store_sub_category',
            'type' => 'options',
            'options'=>Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray13(),
        ));

        $this->addColumn('created_date', array(
            'header'    => Mage::helper('storeconf')->__('Store Created Date'),
            'index'     => 'created_date',
            'type'      => 'timestamp',
        ));
        $this->addColumn('modified_date', array(
            'header'    => Mage::helper('storeconf')->__('Modified date'),
            'index'     => 'modified_date',
            'type'      => 'timestamp',
        ));
 
        $this->addColumn("likes", array(
            "header" => Mage::helper("storeconf")->__("Store Likes"),
            "index" => "likes",
        ));
        $this->addColumn("dislikes", array(
            "header" => Mage::helper("storeconf")->__("Store Dislikes"),
            "index" => "dislikes",
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        /* Retailon 42 To add store status column in Manage Store */
         $this->addColumn('Current Status',
            array(
                'header'=> Mage::helper('storeconf')->__('Current Status'),
                'index' => 'store_status',
                'getter' => 'getStoreName',
                'renderer'  => 'Retailon_Storeconf_Block_Adminhtml_Storeconf_Renderer_Storestatus'// THIS IS WHAT THIS POST IS ALL ABOUT
            ));

        $this->addColumn('Change Status',

            array(

                'header'    =>  $this->__('Change Status'),

                'width'     => '100',

                'type'      => 'action',

                'getter'    => 'getStoreName',

                'actions'   => array(

                    array(

                        'caption'   => $this->__('Change Status'),

                        'url'       => array('base'=> '*/*/status'),

                        'field'     => 'enable_id',

                        'selected' => 'selected'

                    ),

                    //array(

                    //   'caption'   => $this->__('Disabled'),

                    // 'url'       => array('base'=> '*/*/disabled'),

                    // 'field'     => 'disable_id'

                    // )*/

                ),

                'filter'    => false,

                'sortable'  => false,

                'index'     => 'stores',

                'is_system' => true
            ));      

       return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }



    protected function _prepareMassaction()
    {
      //  $this->setMassactionIdField('id');
     //   $this->getMassactionBlock()->setFormFieldName('ids');
     //   $this->getMassactionBlock()->setUseSelectAll(true);
     //   $this->getMassactionBlock()->addItem('remove_storeconf', array(
     //       'label'=> Mage::helper('storeconf')->__('Remove Selected Stores'),
     //       'url'  => $this->getUrl('*/adminhtml_storeconf/massRemove'),
     //       'confirm' => Mage::helper('storeconf')->__('Are you sure?')
     //   ));
     //   return $this;
    }

    //seller_id
    static public function getOptionArray0()
    {
        $data_array=array();
        return $data_array;

        $group = Mage::getSingleton('customer/group')->getCollection()->addFieldToFilter('customer_group_code',Mage::getStoreConfig('retailon/retailon_group/retailon_input',Mage::app()->getStore()));
        
        //print_r($group->getData('customer_group_id'));
        

        $seller = Mage::getModel('customer/customer')->getCollection()->addFieldToFilter('group_id',$group->getData('customer_group_id'));
        

        $seller->addAttributeToSort('entity_id', 'desc');

       foreach($seller as $data)
       {
           //getting seller name

                  $new=Mage::getModel('customer/customer')->load($data->getId());

                $data_array[$new->getId()] = $new->getName();
        //   Mage::log($data_array,null,'data.log');

       }

        return($data_array);
    }

   
    static public function getValueArray0()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray0() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }

        return($data_array);

    }
    //atual store name

    //store_name
    static public function getOptionArray99()
    {

//get all store names

 $data_array=array();
			 foreach (Mage::app()->getWebsites() as $website) {
			    foreach ($website->getGroups() as $group) {
			        $stores = $group->getStores();


			        foreach ($stores as $store) {


			            $data_array[$store->getId()] = $store->getName();
			        }
			    }
			}

        return($data_array);
    }
    static public function getValueArray99()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray99() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

    //store_category
    static public function getOptionArray1()
    {
        $data_array=array();
        $categories = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('*')//or you can just add some attributes
            ->addAttributeToFilter('level',1)//if you want only active categories
            ->addAttributeToSort('entity_id', 'desc')
        ;
        foreach($categories as $data)
        {
            $data_array[$data->getId()] = $data->getName();
          //  Mage::log($data->getName(),null,'cat.log');
        }
        return($data_array);
    }

    static public function getValueArray1()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray1() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

    //store_sub_category
    static public function getOptionArray13()
    {
       $data_array=array();

        $catIds = Mage::getModel('catalog/category')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addIsActiveFilter()
        ->addAttributeToFilter('level',2);
        if ($catIds){
            foreach ($catIds as $cat){

                $data_array[$cat->getId()] = $cat->getName();
            }
        }
        return($data_array);
    }

    static public function getValueArray13()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray13() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

    //shipping_method
    static public function getOptionArray19()
    {
        $data_array=array();
        $activeCarriers = Mage::getSingleton('shipping/config')->getActiveCarriers();

        foreach($activeCarriers as $data)
        {
            // Mage::log($data->getName(),null,'stores.log');
            $data_array[$data->getId()] = $data->getId();

        }

        return($data_array);
    }

    static public function getValueArray19()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray19() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

    static public function getOptionArray30()
    {
        $data_array=array();
       $data_array['Sunday']="Sunday";
       $data_array['Monday']="Monday";
       $data_array['Tuesday']="Tuesday";
       $data_array['Wednesday']="Wednesday";
       $data_array['Thursday']="Thursday";
       $data_array['Friday']="Friday";
       $data_array['Saturday']="Saturday";

        return($data_array);
    }

    static public function getValueArray30()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray30() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

    static public function getOptionArray21()
    {
        $data_array=array();
       $data_array['0']="in %";
       $data_array['1']="Fix Rate";


        return($data_array);
    }

    static public function getValueArray21()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArray21() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

    static public function getOptionArrayTime()
    {
        $data_array=array();
       $data_array['1']="1";
       $data_array['2']="2";
       $data_array['3']="3";
       $data_array['4']="4";
       $data_array['5']="5";
       $data_array['6']="6";
       $data_array['7']="7";
       $data_array['8']="8";
       $data_array['9']="9";
       $data_array['10']="10";
       $data_array['11']="11";
       $data_array['12']="12";


        return($data_array);
    }

     static public function getValueArrayTime()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArrayTime() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }
    static public function getOptionArrayFormate()
    {
        $data_array=array();
       $data_array['am']="AM";
       $data_array['pm']="PM";

        return($data_array);
    }

     static public function getValueArrayFormate()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArrayFormate() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

       static public function getOptionArrayMinutes()
    {
        $data_array=array();
       for($i=0;$i<60;$i++)
       {
       $data_array[$i]=$i;
       }

        return($data_array);
    }

     static public function getValueArrayMinutes()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArrayMinutes() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }

        static public function getOptionArrayImage()
    {
        $data_array=array();
       $data_array[0]="No";
       $data_array[1]="Yes";

        return($data_array);
    }

     static public function getValueArrayImage()
    {
        $data_array=array();
        foreach(Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getOptionArrayImage() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }



}

<?php
/**
 * Created by PhpStorm.
 * User: arshad
 * Date: 6/4/2015
 * Time: 4:36 PM
 */
class Retailon_Marketplace_Block_Adminhtml_Commission_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('commission_grid');
        $this->setDefaultSort("commission_id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('marketplace/commission')->getCollection();
        $collection->getSelect()->join('admin_user',' mage_user_id = user_id','*');
        $collection->getSelect()->join('retailon_marketplace as m',' m.mage_user_id = user_id','*');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

//       $this->addColumn('column_id',
//           array(
//               'header'=> $this->__('column header'),
//               'width' => '50px',
//               'index' => 'column_from_collection'
//           )
//       );
        $this->addColumn("email", array(
            "header" => Mage::helper("marketplace")->__("Email"),
            "index" => "email",
        ));
        $this->addColumn("display_name", array(
            "header" => Mage::helper("marketplace")->__("Display Name"),
            "index" => "display_name",
        ));
        $this->addColumn("total_sales", array(
            "header" => Mage::helper("marketplace")->__("Total Sales"),
            "index" => "total_sales",
        ));
        $this->addColumn("commission_amount", array(
            "header" => Mage::helper("marketplace")->__("Commission Rate"),
            "index" => "commission_amount",
        ));
        $this->addColumn("total_commission", array(
            "header" => Mage::helper("marketplace")->__("Total Commission"),
            "index" => "total_commission",
        ));
        $this->addColumn("total_paid", array(
            "header" => Mage::helper("marketplace")->__("Total Paid"),
            "index" => "total_paid",
        ));
        $this->addColumn("due", array(
            "header" => Mage::helper("marketplace")->__("Due"),
            "index" => "due",
        ));


        $this->addColumn('action',

            array(

                'header'    =>  $this->__('Action'),

                'width'     => '100',

                'type'      => 'action',

                'getter'    => 'getMageUserId',

                'actions'   => array(

                    array(

                        'caption'   => $this->__('Pay'),

                        'url'       => array('base'=> '*/*/pay'),

                        'field'     => 'mage_user_id'

                    ),

                    array(

                        'caption'   => $this->__('History'),

                        'url'       => array('base'=> '*/*/view'),

                        'field'     => 'mage_user_id'

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
                'getter' => 'getMageUserId',
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
                'getter' => 'getMageUserId',
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

            'renderer' => 'Retailon_Marketplace_Block_Adminhtml_Commission_Status',

        ));



                $this->addExportType('*/*/exportCsv', $this->__('CSV'));
        
                $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));
        
        return parent::_prepareColumns();
    }

    }
<?php
/**
 * Created by PhpStorm.
 * User: arshad
 * Date: 6/4/2015
 * Time: 4:36 PM
 */
class Retailon_Marketplace_Block_Adminhtml_Commission extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup      = 'marketplace';
        $this->_controller      = 'adminhtml_commission';
        $this->_headerText      = $this->__('Manage Commission');
        parent::__construct();
        $this->_removeButton('add');
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}


<?php
class Retailon_Commission_Block_Adminhtml_View extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        //where is the controller
        $this->_controller = 'adminhtml_show';
        $this->_blockGroup = 'myblock';
        //text in the admin header
        $this->_headerText = 'Sales Commission History';
        parent::__construct();
        $this->_removeButton('add');
        $dat=array(
           'label' => 'Back',
           'onclick' => "setLocation('".$this->getUrl('*/*/')."')"
               );
         $this->addButton('back',$dat);      
    }
    /*protected function _prepareLayout()
    {
       echo "hai2";
        $this->setChild( 'grid',
        $this->getLayout()->createBlock( $this->_blockGroup . '/' . $this->_controller . '_grid',
        $this->_controller . '.grid')->setSaveParametersInSession(TRUE) );
        return parent::_prepareLayout();
    }*/
}
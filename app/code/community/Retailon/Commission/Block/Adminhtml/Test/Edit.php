<?php
class Retailon_Commission_Block_Adminhtml_Test_Edit extends
    Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'myblock';
        $this->_controller = 'adminhtml_test';

        $this->_removeButton('delete');
        $this->_updateButton('save', 'label','Pay');
    }
    /* Here, we're looking if we have transmitted a form object,
       to update the good text in the header of the page (edit or add) */
    public function getHeaderText()
    {
            return 'Pay Amount';
    }
}
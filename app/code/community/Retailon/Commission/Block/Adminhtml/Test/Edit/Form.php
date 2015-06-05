<?php
/**
 * Created by PhpStorm.
 * User: RetailOn
 * Date: 1/10/15
 * Time: 5:23 PM
 */
class Retailon_Commission_Block_Adminhtml_Test_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form', 
            'action'  => $this->getUrl('*/*/commcalculation', array('id' => $this->getRequest()->getParam('id'))),
            'method'  => 'post',
        ));
        
        $form->setUseContainer(true);
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('test_form1',
            array('legend'=>'Pay Amount'));

         $fieldset->addField('pay_amount', 'text',
            array(
                'label' => 'Enter Amount',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'pay_amount',
                'value' => '',
                'tabindex'  => 1
            ));
        /*  $fieldset->addField('pay_type', 'text',
            array(
                'label' => 'Pay Type',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'pay_type',
                'value' => '',
                'tabindex'  => 2
            ));*/
            
          $fieldset->addField('pay_type', 'select', array(
          'label'     =>'Pay Type',
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'pay_type',
          'onclick' => "",
          'onchange' => "",
          'value'  => 'cash',
          'values' => array('cash' => 'Cash','cheque' => 'Cheque', 'demand draft' => 'Demand Draft','fund transfer' => 'Fund Transfer'),
          'disabled' => false,
          'readonly' => false,
          'after_element_html' => '<small></small>',
          'tabindex' => 3
        ));
        
        
         $fieldset->addField('pay_cmd', 'textarea',
            array(
                'label' => 'Comments',
               // 'class' => 'required-entry',
               // 'required' => true,
                'name' => 'pay_cmd',
           
                
            ));
        return parent::_prepareForm();
    }
}
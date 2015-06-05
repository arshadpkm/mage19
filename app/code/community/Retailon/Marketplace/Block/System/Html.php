<?php
/**
 * Created by PhpStorm.
 * User: Arshad <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */


class Retailon_Marketplace_Block_System_Html extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
	protected $_dummyElement;
	protected $_fieldRenderer;
	protected $_values;

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
		
		$html = "";
        $html .= "<div style=\" margin-bottom: 12px; width: 490px;\">".
                 "<a href='http://retailon.net' alt='Retailon--' target='_blank'><img src='http://retailon.net/rlogo.png' alt='Retailon--' id='logo'></a> <br />".
                 " For more Extensions visit our extension store at <a href='http://www.store.retailon.net/' target='_blank'>store.retailon.net</a><br /> ".
                 "Report bugs to support@retailon.net".
        $html .= "" ;

        return $html;
    }
}

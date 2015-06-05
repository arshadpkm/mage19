<?php
	
class Retailon_Storeconf_Block_Adminhtml_Storeconf_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "storeconf";
				$this->_controller = "adminhtml_storeconf";
				$this->_updateButton("save", "label", Mage::helper("storeconf")->__(" Save "));
				//$this->_updateButton("delete", "label", Mage::helper("storeconf")->__(" Delete "));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("storeconf")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "
							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
						$this->_removeButton('delete');
		}
		
		protected function _prepareLayout() {
		        parent::_prepareLayout();
		        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
		            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		        }
		    }

		public function getHeaderText()
		{
		
				if( Mage::registry("storeconf_data") && Mage::registry("storeconf_data")->getId() ){
				

				    return Mage::helper("storeconf")->__("Edit Store - '%s'", $this->htmlEscape(Mage::getSingleton('core/store')->load(Mage::registry("storeconf_data")->getStoreName())->getName()));

				} 
				else{

				     return Mage::helper("storeconf")->__("Add Store");

				}
		}
}
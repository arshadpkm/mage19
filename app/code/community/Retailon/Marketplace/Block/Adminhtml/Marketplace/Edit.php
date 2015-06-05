<?php
	
class Retailon_Marketplace_Block_Adminhtml_Marketplace_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{
				parent::__construct();
				$this->_objectId = "marketplace_id";
				$this->_blockGroup = "marketplace";
				$this->_controller = "adminhtml_marketplace";
				$this->_updateButton("save", "label", Mage::helper("marketplace")->__("Save"));
				$this->_updateButton("delete", "label", Mage::helper("marketplace")->__("Delete"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("marketplace")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("marketplace_data") && Mage::registry("marketplace_data")->getId() ){

				    return Mage::helper("marketplace")->__("Edit Vendor '%s'", $this->htmlEscape(Mage::registry("marketplace_data")->getDisplayName()));

				} 
				else{

				     return Mage::helper("marketplace")->__("Add");

				}
		}
}
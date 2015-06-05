<?php
class Retailon_Marketplace_Block_Adminhtml_Marketplace_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("marketplace_form", array("legend"=>Mage::helper("marketplace")->__("Vendor Details")));

                        $fieldset->addField("username", "text", array(
                            "label" => Mage::helper("marketplace")->__("User Name"),
                            "name" => "username",
                            "disabled" => "true",
                        ));

                        $fieldset->addField("firstname", "text", array(
                            "label" => Mage::helper("marketplace")->__("First Name"),
                            "name" => "firstname",
                            "disabled" => "true",
                        ));

                        $fieldset->addField("lastname", "text", array(
                            "label" => Mage::helper("marketplace")->__("Last Name"),
                            "name" => "lastname",
                            "disabled" => "true",
                        ));

                        $fieldset->addField("email", "text", array(
                            "label" => Mage::helper("marketplace")->__("Email ID"),
                            "name" => "email",
                            "disabled" => "true",
                        ));
				
						$fieldset->addField("display_name", "text", array(
						"label" => Mage::helper("marketplace")->__("Display Name"),
						"name" => "display_name",
						));
					
						$fieldset->addField("address", "text", array(
						"label" => Mage::helper("marketplace")->__("Address"),
						"name" => "address",
						));
					
						$fieldset->addField("contact", "text", array(
						"label" => Mage::helper("marketplace")->__("Contact"),
						"name" => "contact",
						));
					
						$fieldset->addField("country", "select", array(
						"label" => Mage::helper("marketplace")->__("Country"),
						"name" => "country",
                            'values'   =>  Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
						));
					
						$fieldset->addField("state", "text", array(
						"label" => Mage::helper("marketplace")->__("State"),
						"name" => "state",
						));
					
						$fieldset->addField("pin_code", "text", array(
						"label" => Mage::helper("marketplace")->__("PIN Code"),
						"name" => "pin_code",
						));
					
						$fieldset->addField("vat_cst_number", "text", array(
						"label" => Mage::helper("marketplace")->__("VAT CST Number"),
						"name" => "vat_cst_number",
						));
					
						$fieldset->addField("pan_number", "text", array(
						"label" => Mage::helper("marketplace")->__("PAN Number"),
						"name" => "pan_number",
						));
					
						$fieldset->addField("beneficiary", "text", array(
						"label" => Mage::helper("marketplace")->__("Beneficiary"),
						"name" => "beneficiary",
						));
					
						$fieldset->addField("account_number", "text", array(
						"label" => Mage::helper("marketplace")->__("Account Number"),
						"name" => "account_number",
						));
					
						$fieldset->addField("account_type", "text", array(
						"label" => Mage::helper("marketplace")->__("Account Type"),
						"name" => "account_type",
						));
					
						$fieldset->addField("ifsc", "text", array(
						"label" => Mage::helper("marketplace")->__("IFSC"),
						"name" => "ifsc",
						));
            $fieldset = $form->addFieldset("marketplace_form_commission", array("legend"=>Mage::helper("marketplace")->__("Manage Global Commission")));

                        $fieldset->addField("commission_type", "select", array(
                            "name" => "commission_type",
                            "label" => Mage::helper("marketplace")->__("Commission in % OR Fixed Rate"),
                            "class"=>"rate",
                            'values'   => Retailon_Marketplace_Block_Adminhtml_Marketplace_Grid::getCommissionType(),
                            'note'=>'Example for percentage 5 Or For Fixed Cost 500 )',
                        ));

                        $fieldset->addField("commission_amount", "text", array(
                            "label" => Mage::helper("marketplace")->__("Commission"),
                            "name" => "commission_amount",
                        ));

            $fieldset = $form->addFieldset("marketplace_form_commission_level", array("legend"=>Mage::helper("marketplace")->__("Manage Category Level Commission")));

            $fieldset->addField("commission_type_", "select", array(
                "name" => "commission_type_",
                "label" => Mage::helper("marketplace")->__("Commission in % OR Fixed Rate"),
                "class"=>"rate",
                'values'   => Retailon_Marketplace_Block_Adminhtml_Marketplace_Grid::getCommissionType(),
                'note'=>'Example for percentage 5 Or For Fixed Cost 500 )',
            ));

					

				if (Mage::getSingleton("adminhtml/session")->getMarketplaceData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getMarketplaceData());
					Mage::getSingleton("adminhtml/session")->setMarketplaceData(null);
				} 
				elseif(Mage::registry("marketplace_data")) {
				    $form->setValues(Mage::registry("marketplace_data")->getData());
				}
				return parent::_prepareForm();
		}
}

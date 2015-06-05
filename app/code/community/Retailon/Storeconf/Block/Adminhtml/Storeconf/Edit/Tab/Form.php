<?php
class Retailon_Storeconf_Block_Adminhtml_Storeconf_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				
				$fieldset = $form->addFieldset("storeconf_form", array("legend"=>Mage::helper("storeconf")->__("Vendor information")));

            $fieldset->addField('seller_username', 'text', array(
                'label'     => Mage::helper('storeconf')->__('Vendor Username'),
                'name' => 'seller_id',
                "class" => "required-entry",
                "required" => true,
                "disabled"=>false,
            ));
            $fieldset->addField('seller_first_name', 'text', array(
                'label'     => Mage::helper('storeconf')->__('Vendor First name'),
                'name' => 'seller_id',
                "class" => "required-entry",
                "required" => true,
                "disabled"=>false,
            ));
            $fieldset->addField('seller_last_name', 'text', array(
                'label'     => Mage::helper('storeconf')->__('Vendor Last name'),
                'name' => 'seller_id',
                "class" => "required-entry",
                "required" => true,
                "disabled"=>false,
            ));
						
						$fieldset->addField('seller_email', 'text', array(
						'label'     => Mage::helper('storeconf')->__('Vendor Email'),
						'name' => 'seller_id',
						"class" => "required-entry",
						"required" => true,
						"disabled"=>false,
						));

						
						 $fieldset->addField('store_sub_category', 'select', array(
						'label'     => Mage::helper('storeconf')->__('Line Of Business'),
						'values'   => Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getValueArray13(),
						'name' => 'store_sub_category',
						
						));
						
						
						$fieldset->addField("store_display_name", "text", array(
						"label" => Mage::helper("storeconf")->__("Store Display Name"),
						"name" => "store_display_name",
						"class"=>"required-entry",
						'note'=> 'Example : Flora, J. P. Nagar Phase 1, Bengaluru',
						));
						
						$fieldset->addField("store_address", "textarea", array(
						"label" => Mage::helper("storeconf")->__("Store Address"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "store_address",
						));						
						
						$fieldset->addField("store_contact", "text", array(
						"label" => Mage::helper("storeconf")->__("Store Contact"),
						"name" => "store_contact",
						"required" => true,
						"class"=>"required-entry validate-phoneStrict",
						
						));
					
						$fieldset->addField("store_email", "text", array(
						"label" => Mage::helper("storeconf")->__("Store Email"),
						"name" => "store_email",
						"required" => true,
						"class"=>"required-entry validate-email",
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("country", "text", array(
						"label" => Mage::helper("storeconf")->__("Country"),
						"name" => "country",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("state", "text", array(
						"label" => Mage::helper("storeconf")->__("State"),
						"name" => "state",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));

                        $fieldset->addField("pin_code", "text", array(
						"label" => Mage::helper("storeconf")->__("Pin Code"),
						"name" => "pin_code",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("vat_cst_num", "text", array(
						"label" => Mage::helper("storeconf")->__("VAT/CST Number"),
						"name" => "vat_cst_num",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("pan_num", "text", array(
						"label" => Mage::helper("storeconf")->__("PAN Card Number"),
						"name" => "pan_nume",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("benificeary", "text", array(
						"label" => Mage::helper("storeconf")->__("Benificeary Name"),
						"name" => "benificeary",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("acc_num", "text", array(
						"label" => Mage::helper("storeconf")->__("Account Number"),
						"name" => "acc_num",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("account_type", "text", array(
						"label" => Mage::helper("storeconf")->__("Account Type"),
						"name" => "account_type",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
						
						$fieldset->addField("ifsc", "text", array(
						"label" => Mage::helper("storeconf")->__("IFSC Code"),
						"name" => "ifsc",
						"required" => true,
						"style"=>'margin-bottom: 25px;',
						));
			

						$fieldset->addField("rate", "select", array(					
						"name" => "rate",
						"label" => Mage::helper("storeconf")->__("Commission in % OR Fixed Rate"),
						"class"=>"rate",
						'values'   => Retailon_Storeconf_Block_Adminhtml_Storeconf_Grid::getValueArray21(),
						'note'=>'Example for percentage 5 Or For Fixed Cost 500 )',
						));
					
						$fieldset->addField("etc2", "text", array(
						"label" => Mage::helper("storeconf")->__("Commission"),
						"name" => "etc2",
						));
						
												
						
				if (Mage::getSingleton("adminhtml/session")->getStoreconfData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getStoreconfData());
					Mage::getSingleton("adminhtml/session")->setStoreconfData(null);
				} 
				elseif(Mage::registry("storeconf_data")) {
				    $form->setValues(Mage::registry("storeconf_data")->getData());
				}
				return parent::_prepareForm();
		}
}
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
jQuery.noConflict();

jQuery(document).ready(function() {
jQuery("#store_small_image").addClass('small_image_upload');
jQuery("#store_sliding_image").addClass('sliding_image_upload');

var w='',h='';

  function readImage(file) {
  
    var reader = new FileReader();
    var image  = new Image();
  
    reader.readAsDataURL(file);  
    reader.onload = function(_file) {
        image.src    = _file.target.result;              // url.createObjectURL(file);
        image.onload = function() {
            var w = this.width,
                h = this.height,
                t = file.type,                           // ext only: // file.type.split('/')[1],
                n = file.name,
                s = ~~(file.size/1024);
 
                Validation.add('small_image_upload','File size should be 280x260 for better quality and less than 2MB!',function(the_field_value){
		        if(w > 260 && h > 250 && s < 2048)
		        {
		            return true;
		        }
		        
		        return false;
   		 });
                
        };
        image.onerror= function() {
            alert('Invalid file type: '+ file.type);
        };      
    };
    
}
jQuery("#store_small_image").change(function (e) {
    if(this.disabled) return alert('File upload not supported!');
    var F = this.files;
    if(F && F[0]) for(var i=0; i<F.length; i++) readImage( F[i] );
});

  function readImage1(file) {
  
    var reader1 = new FileReader();
    var image1  = new Image();
  
    reader1.readAsDataURL(file);  
    reader1.onload = function(_file) {
        image1.src    = _file.target.result;              // url.createObjectURL(file);
        image1.onload = function() {
            var w1 = this.width,
                h1 = this.height,
                t1 = file.type,                           // ext only: // file.type.split('/')[1],
                n1 = file.name,
                s1 = ~~(file.size/1024);
               
               
                Validation.add('sliding_image_upload','File size should be 1100x400 for better quality and less than 2MB!',function(the_field_value){
		        if(w1 > 600 && h1 > 300 && s1 < 2048)
		        {
		            return true;
		        }
		        
		        return false;
   		 });
                
        };
        image1.onerror= function() {
            alert('Invalid file type: '+ file.type);
        };      
    };
    
}
jQuery("#store_sliding_image").change(function (e) {
    if(this.disabled) return alert('File upload not supported!');
    var F = this.files;
    if(F && F[0]) for(var i=0; i<F.length; i++) readImage1( F[i] );
});



});

jQuery(document).ready(function()
{
jQuery("#store_contact").keyup(function() {
    this.value = this.value
        .match(/\d*/g).join('')
        .match(/(\d{0,3})(\d{0,3})(\d{0,4})/).slice(1).join('-')
        .replace(/-*$/g, '')
    ;
});
});


</script>
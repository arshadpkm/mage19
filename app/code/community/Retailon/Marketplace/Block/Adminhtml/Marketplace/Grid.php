<?php

class Retailon_Marketplace_Block_Adminhtml_Marketplace_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("marketplaceGrid");
				$this->setDefaultSort("marketplace_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("marketplace/marketplace")->getCollection();
                $collection->getSelect()->join('admin_user','mage_user_id = user_id','*');
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("marketplace_id", array(
				"header" => Mage::helper("marketplace")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "marketplace_id",
				));
                $this->addColumn("email", array(
                    "header" => Mage::helper("marketplace")->__("Email"),
                    "index" => "email",
                ));
				$this->addColumn("display_name", array(
				"header" => Mage::helper("marketplace")->__("Display Name"),
				"index" => "display_name",
				));
				$this->addColumn("address", array(
				"header" => Mage::helper("marketplace")->__("Address"),
				"index" => "address",
				));
				$this->addColumn("contact", array(
				"header" => Mage::helper("marketplace")->__("Contact"),
				"index" => "contact",
				));
				$this->addColumn("country", array(
				"header" => Mage::helper("marketplace")->__("Country"),
				"index" => "country",
				));
				$this->addColumn("state", array(
				"header" => Mage::helper("marketplace")->__("State"),
				"index" => "state",
				));
				$this->addColumn("pin_code", array(
				"header" => Mage::helper("marketplace")->__("PIN Code"),
				"index" => "pin_code",
				));
//				$this->addColumn("vat_cst_number", array(
//				"header" => Mage::helper("marketplace")->__("VAT CST Number"),
//				"index" => "vat_cst_number",
//				));
//				$this->addColumn("pan_number", array(
//				"header" => Mage::helper("marketplace")->__("PAN Number"),
//				"index" => "pan_number",
//				));
//				$this->addColumn("beneficiary", array(
//				"header" => Mage::helper("marketplace")->__("Beneficiary"),
//				"index" => "beneficiary",
//				));
//				$this->addColumn("account_number", array(
//				"header" => Mage::helper("marketplace")->__("Account Number"),
//				"index" => "account_number",
//				));
//				$this->addColumn("account_type", array(
//				"header" => Mage::helper("marketplace")->__("Account Type"),
//				"index" => "account_type",
//				));
//				$this->addColumn("ifsc", array(
//				"header" => Mage::helper("marketplace")->__("IFSC"),
//				"index" => "ifsc",
//				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('marketplace_id');
			$this->getMassactionBlock()->setFormFieldName('marketplace_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_marketplace', array(
					 'label'=> Mage::helper('marketplace')->__('Remove Marketplace'),
					 'url'  => $this->getUrl('*/adminhtml_marketplace/massRemove'),
					 'confirm' => Mage::helper('marketplace')->__('Are you sure?')
				));
			return $this;
		}


    static public function getCommissionType()
    {
        $data_array=array();
        $data_array['0']="in %";
        $data_array['1']="Fix Rate";
        return($data_array);
    }

    static public function getCommissionTypeValue()
    {
        $data_array=array();
        foreach(Retailon_Marketplace_Block_Adminhtml_Marketplace_Grid::getCommissionType() as $k=>$v){
            $data_array[]=array('value'=>$k,'label'=>$v);
        }
        return($data_array);

    }
			

}
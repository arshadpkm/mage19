<?php
class Retailon_Vendor_Model_Eav_Entity_Attribute_Source_Industryvertical extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
			
                array(
                    "label" => Mage::helper("eav")->__("Telecom/ Media"),
                    "value" =>  1
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Manufacturing"),
                    "value" =>  2
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Banking & Finance"),
                    "value" =>  3
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Healthcare"),
                    "value" =>  4
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Utilities"),
                    "value" =>  5
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Power"),
                    "value" =>  6
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Retail"),
                    "value" =>  7
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Hospitality"),
                    "value" =>  8
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Other"),
                    "value" =>  9
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Advertising/PR/Events"),
                    "value" =>  10
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Automotive/ Ancillaries"),
                    "value" =>  11
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Bio Technology & Life Sciences"),
                    "value" =>  12
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Chemicals/Petrochemicals"),
                    "value" =>  13
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Construction"),
                    "value" =>  14
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("FMCG"),
                    "value" =>  15
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Courier/ Freight/ Transportation"),
                    "value" =>  16
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Education"),
                    "value" =>  17
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("E-Learning"),
                    "value" =>  18
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Engineering, Procurement, Construction"),
                    "value" =>  19
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Entertainment/ Media/ Publishing"),
                    "value" =>  20
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Food & Packaged Food"),
                    "value" =>  21
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Insurance"),
                    "value" =>  22
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("IT/ Computers - Hardware"),
                    "value" =>  23
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("IT/ Computers - Software"),
                    "value" =>  24
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("ITES/BPO"),
                    "value" =>  25
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("KPO/Analytics"),
                    "value" =>  26
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Machinery/ Equipment Mfg."),
                    "value" =>  27
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Oil/ Gas/ Petroleum"),
                    "value" =>  28
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Pharmaceuticals"),
                    "value" =>  29
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Public Relations (PR)"),
                    "value" =>  30
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Real Estate"),
                    "value" =>  31
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Shipping/ Marine Services"),
                    "value" =>  32
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Travel/ Tourism"),
                    "value" =>  33
                ),
	
            );
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option["value"]] = $option["label"];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option["value"] == $value) {
                return $option["label"];
            }
        }
        return false;
    }

    /**
     * Retrieve Column(s) for Flat
     *
     * @return array
     */
    public function getFlatColums()
    {
        $columns = array();
        $columns[$this->getAttribute()->getAttributeCode()] = array(
            "type"      => "tinyint(1)",
            "unsigned"  => false,
            "is_null"   => true,
            "default"   => null,
            "extra"     => null
        );

        return $columns;
    }

    /**
     * Retrieve Indexes(s) for Flat
     *
     * @return array
     */
    public function getFlatIndexes()
    {
        $indexes = array();

        $index = "IDX_" . strtoupper($this->getAttribute()->getAttributeCode());
        $indexes[$index] = array(
            "type"      => "index",
            "fields"    => array($this->getAttribute()->getAttributeCode())
        );

        return $indexes;
    }

    /**
     * Retrieve Select For Flat Attribute update
     *
     * @param int $store
     * @return Varien_Db_Select|null
     */
    public function getFlatUpdateSelect($store)
    {
        return Mage::getResourceModel("eav/entity_attribute")
            ->getFlatUpdateSelect($this->getAttribute(), $store);
    }
}

			 
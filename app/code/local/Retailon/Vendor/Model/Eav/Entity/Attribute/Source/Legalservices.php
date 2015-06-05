<?php
class Retailon_Vendor_Model_Eav_Entity_Attribute_Source_Legalservices extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
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
                    "label" => Mage::helper("eav")->__("Company Law"),
                    "value" =>  1
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Company Formation"),
                    "value" =>  2
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Customs and International Law"),
                    "value" =>  3
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Bankruptcy"),
                    "value" =>  4
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Immigration & Naturalization"),
                    "value" =>  5
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Insurance Law"),
                    "value" =>  6
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Labor and Employment Law"),
                    "value" =>  7
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Patent,Copyright & Trademark"),
                    "value" =>  8
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Pension Plans& Profit Sharing"),
                    "value" =>  9
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Social Security"),
                    "value" =>  10
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Tax- Federal & State"),
                    "value" =>  11
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Unemployment Compensation"),
                    "value" =>  12
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Workers Compensation"),
                    "value" =>  13
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

			 
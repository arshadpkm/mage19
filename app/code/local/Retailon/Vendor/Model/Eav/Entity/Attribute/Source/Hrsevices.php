<?php
class Retailon_Vendor_Model_Eav_Entity_Attribute_Source_Hrsevices extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
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
                    "label" => Mage::helper("eav")->__("Career Advice Services"),
                    "value" =>  1
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Contract Staffing"),
                    "value" =>  2
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Employment compensation"),
                    "value" =>  3
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Employee relations"),
                    "value" =>  4
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Green Jobs"),
                    "value" =>  5
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Recruitment"),
                    "value" =>  6
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Recruitment Process Outsourcing"),
                    "value" =>  7
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Staffing"),
                    "value" =>  8
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Telecommuting"),
                    "value" =>  9
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Temporary Employment"),
                    "value" =>  10
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Labor"),
                    "value" =>  11
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Labor Law"),
                    "value" =>  12
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Employment Leasing "),
                    "value" =>  13
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Payroll Software "),
                    "value" =>  14
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Professional Payroll Services"),
                    "value" =>  15
                ),
	
                array(
                    "label" => Mage::helper("eav")->__(" Career and Technical Education"),
                    "value" =>  16
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Communication Skills Training"),
                    "value" =>  17
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Leadership Training"),
                    "value" =>  18
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Life Coaching"),
                    "value" =>  19
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Performance Psycology"),
                    "value" =>  20
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Training "),
                    "value" =>  21
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

			 
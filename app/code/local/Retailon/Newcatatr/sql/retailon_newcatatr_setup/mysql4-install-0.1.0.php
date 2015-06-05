<?php
 
$installer = $this;
$installer->startSetup();
 
/**
* This is an entity associated with catalog_category
* @var integer
*/
$entityTypeId = $installer->getEntityTypeId('catalog_category');
 
/**
* Use the default attribute set for catalog_category -- this refers to the table `eav_attribute_set`
* In my case, it's 3, but this function should automatically get that for you.
* @var integer
*/
$attributeSetId = $installer->getDefaultAttributeSetId($entityTypeId);
 
/**
* This determines what group (tab) that the field will be placed. "General Information"
* is the default tab, and I'm okay with this, but see `eav_attribute_group` for other
* groups
* @var integer
*/
$attributeGroupId = $installer->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);
 
/**
* Let's set up our attribute, customize the type as needed (e.g. int, varchar, decimal)
* Note where I've used `internal_title` and change to your variable.
*/
$installer->addAttribute('catalog_category', 'sub_title', array(
'type' => 'text', /* Type - see eav_entity_* for the different types */
'label' => 'Sub title', /* Your label */
'input' => 'textarea', /* This refers to the type of form field should display*/
'wysiwyg_enabled'   => TRUE,
'is_html_allowed_on_front' => TRUE,
'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
'visible' => TRUE,
'required' => FALSE,
'user_defined' => FALSE,
'default' => ''
));

/**
* Now, add the attribute to the proper attribute group - again, replace the variable title
* with yours.
*/
$installer->addAttributeToGroup(
$entityTypeId,
$attributeSetId,
$attributeGroupId,
'sub_title',
'2' /* Refers to the sort order of fields - see `eav_entity_attribute` for reference on the location of other fields. I want this right below the active field, so 2 works for me.*/
);
 
$installer->endSetup();
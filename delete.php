<?php
include 'app/Mage.php';
Mage::app();
$setup = Mage::getResourceModel('catalog/setup','catalog_setup');
$setup->removeAttribute('catalog_category','sub_title');
?>
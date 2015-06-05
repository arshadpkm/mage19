<?php
 
$installer = $this;
 
$installer->startSetup();

$tableName = $installer->getTable('storeconf/storeconf');
if ($installer->getConnection()->isTableExists($tableName) != true) {
 
$sql=<<<SQLTEXT
CREATE TABLE IF NOT EXISTS `$tableName` (
	`id` int(100) NOT NULL AUTO_INCREMENT,
  `seller_id` int(100) NOT NULL,
  `seller_name` varchar(32) NOT NULL,
  `seller_email` varchar(100) NOT NULL,
  `store_category` int(100) NOT NULL,
  `actual_store_name` varchar(50) NOT NULL,
  `store_name` varchar(256) NOT NULL,
  `store_display_name` varchar(255) NOT NULL,
  `store_address` text NOT NULL,
  `store_contact` varchar(256) NOT NULL,
  `store_email` varchar(256) NOT NULL,
  `store_sub_category` varchar(256) NOT NULL,
  `created_date` date NOT NULL,
  `modified_date` date DEFAULT NULL,
  `etc1` text NOT NULL,
  `etc2` varchar(100) NOT NULL,
  `rate` int(10) NOT NULL,
  `likes` int(100) NOT NULL,
  `dislikes` int(100) NOT NULL,
  `shipping_method` text NOT NULL,
  `country` varchar(225) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pin_code` varchar(255) NOT NULL,
  `vat_cst_num` varchar(255) NOT NULL,
  `pan_num` varchar(255) NOT NULL,
  `benificeary` varchar(255) NOT NULL,
  `acc_num` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `ifsc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=InnoDB
;
SQLTEXT;

$installer->run($sql);
}



$installer->endSetup();
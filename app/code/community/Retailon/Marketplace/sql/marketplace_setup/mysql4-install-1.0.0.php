<?php
/**
 * Created by PhpStorm.
 * User: Arshad <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE IF NOT EXISTS`{$this->getTable( 'retailon_marketplace_products' )}` (
	`marketplace_product_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` bigint(20) unsigned NOT NULL,
	`user_id` bigint(20) unsigned NOT NULL,
	`marketplace_products_dtime` datetime NOT NULL,
	PRIMARY KEY (`marketplace_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS`{$this->getTable( 'retailon_vendor_orders' )}` (
	`vendor_order_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`mage_order_id` varchar(20) NOT NULL,
	`user_id` bigint(20) unsigned NOT NULL,
	PRIMARY KEY (`vendor_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS`{$this->getTable( 'retailon_marketplace' )}` (
	`marketplace_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`mage_user_id` bigint(20) unsigned NOT NULL,
	`created_date` date NOT NULL,
    `modified_date` date DEFAULT NULL,
    `rate` int(10) NOT NULL,
    `likes` int(100) NOT NULL,
    `dislikes` int(100) NOT NULL,
    `display_name` varchar(255) NOT NULL,
    `address` text NOT NULL,
    `contact` varchar(256) NOT NULL,
    `country` varchar(225) NOT NULL,
    `state` varchar(255) NOT NULL,
    `pin_code` varchar(255) NOT NULL,
    `vat_cst_number` varchar(255) NOT NULL,
    `pan_number` varchar(255) NOT NULL,
    `beneficiary` varchar(255) NOT NULL,
    `account_number` varchar(255) NOT NULL,
    `account_type` varchar(255) NOT NULL,
    `ifsc` varchar(255) NOT NULL,
    `commission_type` varchar(255) NOT NULL,
    `commission_amount` varchar(255) NOT NULL,
	PRIMARY KEY (`marketplace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS`{$this->getTable( 'retailon_commission' )}` (
	`commission_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`mage_user_id` bigint(20) unsigned NOT NULL,
	`created_date` date NOT NULL,
    `modified_date` date DEFAULT NULL,
    `total_sales` varchar(255) NOT NULL,
    `total_commission` varchar(225) NOT NULL,
    `total_paid` varchar(255) NOT NULL,
    `due` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL,
	PRIMARY KEY (`commission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS`{$this->getTable( 'retailon_commissionhistory' )}` (
	`commissionhistory_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`mage_user_id` bigint(20) unsigned NOT NULL,
	`created_date` date NOT NULL,
    `modified_date` date DEFAULT NULL,
    `paid_amount` varchar(255) NOT NULL,
    `paid_type` varchar(225) NOT NULL,
    `paid_date` date DEFAULT NULL,
    `comment` varchar(255) NOT NULL,
	PRIMARY KEY (`commissionhistory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SQLTEXT;

$installer->run($sql);

$installer->endSetup();
ALTER TABLE `PREFIX_orders` 
ADD `payment_fee` decimal(20,6) NOT NULL default '0';	
ALTER TABLE `PREFIX_orders` 
ADD `payment_fee_rate` decimal(20,3) NOT NULL default '0';
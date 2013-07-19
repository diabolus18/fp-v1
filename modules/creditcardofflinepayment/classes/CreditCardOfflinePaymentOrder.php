<?php
/*
 * IDnovate (http://www.idnovate.com)
 * Credit Card Offline Payment Module - Allows currently running stores to
 * accept creditcard information through their online
 * shop. The credit card number is verified and the information 
 * is then stored masked in the database.  
 * It can then be decrypted, together with the information received by email,
 * at a later time for charges through an existing gateway (ie. a creditcard machine).
 *	
 * This product is licensed for one customer to use on one domain. Site developer has the 
 * right to modify this module to suit their needs, but can not redistribute the module in 
 * whole or in part. Any other use of this module constitues a violation of the user agreement.
 *
 *	NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
 *	ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
 *	WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF 
 *	PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
 *	IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
 *
 *	Versions
 * 	1.34 - May 2, 2013 - idnovate.com - For Prestashop 1.4 & 1.5
 *
*/

	class CreditCardOfflinePaymentOrder
	{
		public static function isCreditCardOrder($id_order)
		{
			$db = Db::getInstance();
			$result = $db->getRow('
				SELECT `id_pedido` FROM '._DB_PREFIX_.'ccofflinepayment
				WHERE `id_pedido` = '.$id_order);
	
			return intval($result["id_pedido"]) != 0 ? true : false;			
		}

		public static function insertOrder($id_order, $cvv, $tipo_tarjeta, $pan, $nombre, $cedula, $direccion, $cp, $mes_caducidad, $ano_caducidad, $importe, $moneda)
		{
			$db = Db::getInstance();
			$cvv = pSQL($cvv);
			$pan = pSQL($pan);
			$nombre = pSQL($nombre);
			$cedula = pSQL($cedula);
			$direccion = pSQL($direccion);
			$cp = pSQL($cp);
			$result = $db->Execute('
			INSERT INTO `'._DB_PREFIX_.'ccofflinepayment`
			(`id_pedido`, `cvc`, `tipo_tarjeta`, `pan`, `nombre_titular`, `cedula`, `direccion`, `cp`, `mes_caducidad`, `ano_caducidad`, `importe`, `moneda`)
			VALUES
			("'.$id_order.'","' . $cvv . '","' . $tipo_tarjeta .'","'.$pan.'","' . $nombre . '","' . $cedula . '","' . $direccion . '","' . $cp .'","' . $mes_caducidad .'","'. $ano_caducidad . '","' . $importe. '","' . $moneda. '")'
			);
		}

		public static function getOrder($id_order)
		{
			$db = Db::getInstance();
			$result = $db->ExecuteS('
			SELECT `id_pedido`, `cvc`, `tipo_tarjeta`, `pan`, `nombre_titular`, `cedula`, `direccion`, `cp`, `mes_caducidad`, `ano_caducidad`, `importe`, `moneda`
			FROM `'._DB_PREFIX_.'ccofflinepayment`
			WHERE `id_pedido` ="'.$id_order.'";');
			
			return $datos = array(
				'cvc' => $result[0]['cvc'],
				'tipo_tarjeta' => $result[0]['tipo_tarjeta'],
				'pan' => $result[0]['pan'],
				'nombre_titular' =>	$result[0]['nombre_titular'],
				'cedula' =>	$result[0]['cedula'],
				'direccion' =>	$result[0]['direccion'],
				'cp' =>	$result[0]['cp'],
				'mes_caducidad' => $result[0]['mes_caducidad'],
				'ano_caducidad' => $result[0]['ano_caducidad'],
				'importe' => $result[0]['importe'],
				'moneda' => $result[0]['moneda']
				);
		}

		public static function setup()
		{	
			$db = Db::getInstance();

			$db->execute('CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'ccofflinepayment (
				`id_pedido` INT NOT NULL PRIMARY KEY,
				`pan` varchar(20) NOT NULL,
				`cvc` varchar(20) NULL,
				`tipo_tarjeta` varchar(20) NULL,
				`nombre_titular` varchar(255) NOT NULL,
				`cedula` varchar(20),
				`direccion` varchar(255) NULL,
				`cp` varchar(10) NULL,
				`mes_caducidad` decimal(2,0) NULL,
				`ano_caducidad` decimal(4,0) NULL,
				`importe` decimal(12,2) NOT NULL,
				`moneda` varchar(50) NULL,
				`fecha_transaccion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP)
				ENGINE='._MYSQL_ENGINE_.' default CHARSET=utf8');
			return true;
		}		

		public static function deleteCardInfo($id)
		{	
			$db = Db::getInstance();
			$result = $db->execute('
				DELETE FROM `'._DB_PREFIX_.'ccofflinepayment`
				WHERE `id_pedido` = "'.$id.'"');
		}

		public static function remove()
		{	
			$db = Db::getInstance();
			$db->execute("DROP TABLE `"._DB_PREFIX_."ccofflinepayment`");
			return true;
		}		
	}
?>
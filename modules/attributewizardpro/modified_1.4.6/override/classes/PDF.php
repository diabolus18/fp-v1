<?php
/*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 10339 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

include_once(_PS_FPDF_PATH_.'fpdf.php');

class PDF extends PDFCore
{

	/**
	* Product table with price, quantities...
	*/
	public function ProdTab($delivery = false)
	{
		if (!$delivery)
			$w = array(100, 15, 30, 15, 30);
		else
			$w = array(120, 30, 10);
		self::ProdTabHeader($delivery);
		if (!self::$orderSlip)
		{
			if (isset(self::$order->products) AND sizeof(self::$order->products))
				$products = self::$order->products;
			else
				$products = self::$order->getProducts();
		}
		else
			$products = self::$orderSlip->getOrdersSlipProducts(self::$orderSlip->id, self::$order);
		$customizedDatas = Product::getAllCustomizedDatas((int)(self::$order->id_cart));
		Product::addCustomizationPrice($products, $customizedDatas);

		$counter = 0;
		$lines = 25;
		$lineSize = 0;
		$line = 0;

		foreach($products AS $product)
			if (!$delivery OR ((int)($product['product_quantity']) - (int)($product['product_quantity_refunded']) > 0))
			{
				if ($counter >= $lines)
				{
					$this->AddPage();
					$this->Ln();
					self::ProdTabHeader($delivery);
					$lineSize = 0;
					$counter = 0;
					$lines = 40;
					$line++;
				}
				$counter = $counter + ($lineSize / 5) ;

				$i = -1;

				// Unit vars
				$unit_without_tax = $product['product_price'] + $product['ecotax'];
				$unit_with_tax = $product['product_price_wt'];
				if (self::$_priceDisplayMethod == PS_TAX_EXC)
					$unit_price = &$unit_without_tax;
				else
					$unit_price = &$unit_with_tax;
				$productQuantity = $delivery ? ((int)($product['product_quantity']) - (int)($product['product_quantity_refunded'])) : (int)($product['product_quantity']);

				if ($productQuantity <= 0)
					continue ;

				// Total prices
				$total_with_tax = $unit_with_tax * $productQuantity;
				$total_without_tax = $unit_without_tax * $productQuantity;
				// Spec
				if (self::$_priceDisplayMethod == PS_TAX_EXC)
					$final_price = &$total_without_tax;
				else
					$final_price = &$total_with_tax;
				// End Spec

				if (isset($customizedDatas[$product['product_id']][$product['product_attribute_id']]))
				{
					$custoLabel = '';

					foreach($customizedDatas[$product['product_id']][$product['product_attribute_id']] as $customizedData)
					{
						$customizationGroup = $customizedData['datas'];
						$nb_images = 0;

						if (array_key_exists(_CUSTOMIZE_FILE_, $customizationGroup))
							$nb_images = sizeof($customizationGroup[_CUSTOMIZE_FILE_]);

						if (array_key_exists(_CUSTOMIZE_TEXTFIELD_, $customizationGroup))
							foreach($customizationGroup[_CUSTOMIZE_TEXTFIELD_] as $customization)
								if (!empty($customization['name'])) $custoLabel .= '- '.$customization['name'].': '.$customization['value']."\n";


						if ($nb_images > 0)
							$custoLabel .= '- '.$nb_images. ' '. self::l('image(s)')."\n";

						$custoLabel .= "---\n";
					}

					$custoLabel = rtrim($custoLabel, "---\n");

					$productQuantity = (int)($product['product_quantity']) - (int)($product['customizationQuantityTotal']);
					if ($delivery)
						$this->SetX(25);
					$before = $this->GetY();
					$this->MultiCell($w[++$i], 5, Tools::iconv('utf-8', self::encoding(), $product['product_name']).' - '.self::l('Customized')." \n".Tools::iconv('utf-8', self::encoding(), $custoLabel), 'B');
					$lineSize = $this->GetY() - $before;
					$this->SetXY($this->GetX() + $w[0] + ($delivery ? 15 : 0), $this->GetY() - $lineSize);
					$this->Cell($w[++$i], $lineSize, $product['product_reference'], 'B');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($unit_price, self::$currency, true)), 'B', 0, 'R');
					$this->Cell($w[++$i], $lineSize, (int)($product['customizationQuantityTotal']), 'B', 0, 'C');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($unit_price * (int)($product['customizationQuantityTotal']), self::$currency, true)), 'B', 0, 'R');
					$this->Ln();
					$i = -1;
					$total_with_tax = $unit_with_tax * $productQuantity;
					$total_without_tax = $unit_without_tax * $productQuantity;
				}
				if ($delivery)
					$this->SetX(25);
				if ($productQuantity)
				{
					$before = $this->GetY();
					$product['product_name'] = str_replace("<br />","\n\r",$product['product_name']);
					$product['product_name'] = strip_tags(html_entity_decode($product['product_name'],ENT_QUOTES));
					$this->MultiCell($w[++$i], 5, Tools::iconv('utf-8', self::encoding(), $product['product_name']), 'B');
					$lineSize = $this->GetY() - $before;
					$this->SetXY($this->GetX() + $w[0] + ($delivery ? 15 : 0), $this->GetY() - $lineSize);
					$this->Cell($w[++$i], $lineSize, ($product['product_reference'] ? Tools::iconv('utf-8', self::encoding(), $product['product_reference']) : '--'), 'B');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($unit_price, self::$currency, true)), 'B', 0, 'R');
					$this->Cell($w[++$i], $lineSize, $productQuantity, 'B', 0, 'C');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($final_price, self::$currency, true)), 'B', 0, 'R');
					$this->Ln();
				}
			}

		if (!sizeof(self::$order->getDiscounts()) AND !$delivery)
			$this->Cell(array_sum($w), 0, '');
	}


}


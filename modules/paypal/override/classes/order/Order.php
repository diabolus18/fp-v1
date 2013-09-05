<?php



class Order extends OrderCore

{

	public 	$payment_fee;

	public 	$payment_fee_rate;

	

	public function getFields()

	{

		$fields = parent::getFields();

		$fields['payment_fee'] = (float)($this->payment_fee);

		$fields['payment_fee_rate'] = (float)($this->payment_fee_rate);

		return $fields;

	}

};
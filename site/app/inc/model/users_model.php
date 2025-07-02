<?php
class users_model extends DOLModel
{
	public $field = array(" idx ", " name ", " email ", " cpf ",  " avatar ");
	public $filter = array(" active = 'yes' ");
	function __construct($bd = false)
	{
		return parent::__construct("users", $bd);
	}
}
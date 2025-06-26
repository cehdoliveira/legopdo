<?php
class users_model extends DOLModel
{
	protected $field = array(" idx ", " name ", " email ", " cpf ",  " avatar ");
	protected $filter = array(" active = 'yes' ");
	function __construct($bd = false)
	{
		return parent::__construct("users", $bd);
	}
}
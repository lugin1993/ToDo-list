<?php

namespace App\Core;

class Validator
{
	public static function validate(array $values, array $rules):bool
	{
		foreach ($rules as $key=>$rule){
			$ruleItems = explode('|', $rule);
			if(isset($values[$key])){
				$value = $values[$key];
				if(!in_array(gettype($value), $ruleItems)){
					return false;
				}
				if(in_array('email', $ruleItems) && !filter_var($value, FILTER_VALIDATE_EMAIL)){
					return false;
				}
			}elseif(in_array('required', $ruleItems)){
				return false;
			}
		}
		return true;
	}
}
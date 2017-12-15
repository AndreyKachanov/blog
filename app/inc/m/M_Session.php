<?php
class M_Session
{
	public static function push($name, $value)
	{
		$_SESSION[$name] = $value;
	}
}
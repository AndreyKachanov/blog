<?php

class M_Helpers
{
	private static $privs;	
	
	public static function can_look($priv)
	{
		if(self::$privs === null)
			self::$privs = M_Users::Instance()->GetPrivs();

		return (in_array('ALL', self::$privs) || in_array($priv, self::$privs));
	}
}
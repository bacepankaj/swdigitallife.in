<?	
	/**
	* Cookie Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Cookie {		
		/**
		* Set Cookie Values
		*
		* Function set Cookie values
		* @author Susanta Das
		*/		
		public static function set($key, $value) {			
			setcookie(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$key, $value, time()+60*60*24*30, "/");		
		}
		
		/**
		* Get Cookie Values
		*
		* Function get Cookie values
		* @author Susanta Das
		*/		
		public static function get($key) {			
			if(isset($_COOKIE[strtolower(str_replace(' ', '_', APP_NAME)).'_'.$key]))
			return $_COOKIE[strtolower(str_replace(' ', '_', APP_NAME)).'_'.$key];
		}
		
		/**
		* Destroy the Cookie
		*
		* Function destroy the Cookie
		* @author Susanta Das
		*/		
		public static function destroy() {		
			if(isset($_COOKIE))
			unset($_COOKIE);		
		}
	}
?>
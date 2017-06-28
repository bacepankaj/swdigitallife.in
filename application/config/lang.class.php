<?
	/**
	* Lang Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Lang {
		/**
		* Get Translet Language 
		*
		* Function translet
		* @param $key as string
		* @param $param as array		
		* @returns array
		* @author Susanta Das
		*/
		static function error($key, $param=null){
			// define lang array
            $_lang = array();
            
            if(is_array($param)) extract($param);
			
			// error messages
			$_lang['error'] = array(
				'001'=>array('msg'=>"The user name or password you have entered is incorrect or does not exist", 'title'=>"Authentication Error"),					
			);
			
            // define lang object
			$lang = new stdClass();
            
            // assign lang object
            $lang->msg = $_lang['error'][$key]['msg'];
			$lang->title = $_lang['error'][$key]['title'];
            
            // return lang
            return $lang;
		}
	}
?>

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
				'001'=>array('msg'=>"The user name or password you have entered is incorrect or does not exist.", 'title'=>"Authentication Error"),					
				'002'=>array('msg'=>"Dear <b>{$name}</b> your mobile <b>{$mobile}</b> is already registered in our system.<br>Please try other mobile no.", 'title'=>"Signup Error"),					
				'003'=>array('msg'=>"Dear <b>{$name}</b> your mobile <b>{$mobile}</b> is accepted. Please click <b>Yes</b> to verify your mobile no.", 'title'=>"Mobile Number Accepted"),					
				'004'=>array('msg'=>"Dear <b>{$name}</b> OTP Code you have entered is not valid. Please try again", 'title'=>"OTP Validation Failed"),					
				'005'=>array('msg'=>"Dear <b>{$name}</b> Congratulations, you have successfully created an <b>".APP_NAME."</b> account.<br>Please click <b>Ok</b> to continue.", 'title'=>"Account Created Successfully"),					
				'006'=>array('msg'=>"Dear user, your request for change password is accepted.<br>Please click <b>Yes</b> to verify your mobile no.", 'title'=>"Account Created Successfully"),					
				'007'=>array('msg'=>"Dear <b>{$name}</b>, your password is reset successfully.<br>Please click <b>Ok</b> to continue.", 'title'=>"Password Reset Successfully"),					
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

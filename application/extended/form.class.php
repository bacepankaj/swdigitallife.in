<?
	/**
	* Extends Main Form Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Form extends MainForm {				
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct();
			
			//form element disable if state is view
			if($this->method=='view')
				$this->disable = true;
			else
				$this->disable = false;
		}
        
        /**
		* Get Avatar Image
		*
		* Function avatar
		* @param $user_id as string
		* @param $exists as boolean byref
		* @author Susanta Das
		*/
		public function avatar($user_id, &$exists) {
			if(file_exists(AVATAR_PATH.'/'.$user_id.'.png'))
			{
				// get user avatar version
                $user = ORM::for_table('user')->find_one($user_id);
                
                // get thumbs
				$thumb = AJAX_BASE_URL.'/'.AVATAR_PATH.'/'.$user_id.'.png?v='.$user->avatar_version;
				
				// avatar exists
				$exists = true;
			}
			else
			{
				// get thumbs
				$thumb = AJAX_BASE_URL.'/'.AVATAR_PATH.'/avatar.png';				
				
				// avatar exists
				$exists = false;
			}
			
			return $thumb;
		}
	}
?>
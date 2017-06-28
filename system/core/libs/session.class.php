<?	
	/**
	* Session Class
	*
	* @link http://somnetics.in/
	* @copyright 2010-2011 Somnetics Pvt. Ltd.
	* @author Susanta Das <susanta.das@somnet.co.in>
	* @version 1.0.50
	*/
	class Session {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {		
			// start the session
			self::start();
			
			// get session expire time
			$expiretime = self::get('expiretime');
			
			//check session		
			if(isset($expiretime)) {
				if(self::get('expiretime') < time()) {
					self::destroy();						
				}			
			}	
			
			//session time
			$minutes = SESSION_TIMEOUT;
			
			//set session time out		
			self::set('expiretime', time() + ($minutes * 60));
		}
		
		/**
		* Start the Session
		*
		* Function start the session
		* @author Susanta Das
		*/		
		public static function start() {			
			// get session id
            $sessionid = Functions::encrypt_decrypt('encrypt', "Bengalathon");
            
            //set session name
			ini_set('session.name', $sessionid.'_SESID');
           			
            //set session name
			ini_set('session.name', base64_encode(BASE_PATH).'_SESID');
            
            //set session path
			ini_set('session.cookie_path', "/");
			            			
            //set session domain
            ini_set('session.cookie_domain', $_SERVER['HTTP_HOST']);
            
            //set session httponly
            ini_set('session.cookie_httponly', true);
            
            //set session secure https
            ini_set('session.cookie_secure', false);
            
			// start the session
			@session_start();		
			
			// get session token
			$token = self::get('token');
			
			// set session token
			if (empty($token)) {
				if (function_exists('mcrypt_create_iv')) {
					self::set('token', bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)));
				} else {
					self::set('token', bin2hex(openssl_random_pseudo_bytes(32)));
				}
			}
			
			// return session id			
			return session_id();
		}
		
		/**
		* Set Session Values
		*
		* Function set session values
		* @author Susanta Das
		*/		
		public static function set($key, $value) {
			$_SESSION[base64_encode(BASE_PATH).'_'.$key] = $value;
		}
		
		/**
		* Get Session Values
		*
		* Function get session values
		* @author Susanta Das
		*/		
		public static function get($key) {			
			if(isset($_SESSION[base64_encode(BASE_PATH).'_'.$key]))
			return $_SESSION[base64_encode(BASE_PATH).'_'.$key];
		}
		
		/**
		* Delete Session Values
		*
		* Function del session values
		* @author Susanta Das
		*/		
		public static function del($key) {			
			if(isset($_SESSION[base64_encode(BASE_PATH.'_'.$key)]))
			unset($_SESSION[base64_encode(BASE_PATH.'_'.$key)]);
		}
		
		/**
		* Destroy the Session
		*
		* Function destroy the session
		* @author Susanta Das
		*/		
		public static function destroy() {			
			self::start();
			session_regenerate_id(true); 
			
			unset($_SESSION);
			session_destroy();
		}
		
		/**
		* Check the Session
		*
		* Function check the session
		* @author Susanta Das
		*/
		public static function check_session() {
			// get redirect_to_default
			$redirect_to_default = Cookie::get('redirect_to_default');
			
			// if empty redirect_to_default set from default settings
			if(empty($redirect_to_default)){$redirect_to_default = REDIRECT_TO_DEFAULT;}
						
			// check if auth token is submitted
			if(isset($_GET['authtoken']))
			{
				// check auth token
				$authtoken = Functions::encrypt_decrypt('decrypt', $_GET['authtoken'], "\x73\x6f\x6d\x31\x34\x31\x30\x40\x73\x6f\x6d\x6e\x65\x74\x69\x63\x73");
					
				// get auth token
				$authtoken = json_decode($authtoken);
				
				// set active session
				if(!isset($authtoken->keep_session)){$authtoken->keep_session = true;}
				
				// unset login state
				if(!$authtoken->keep_session){self::set_state(false);}
			}
			
			// if session exists
			if(!self::get_state())
			{	
				// check requested url
				if(trim(REQUEST_URI) != trim(APP_PATH.'/'.$redirect_to_default))
				{	
					// get return url					
					$returnUrl = urlencode(ltrim(str_replace(APP_PATH, '', REQUEST_URI), '/'));
					
					// check if auth token is submitted
					if(isset($_GET['authtoken']))
					{
						/*
                        // get guest user info
						$guest_user = ORM::for_table('sys_user_login');
						
						// if user pass is provided please authenticate it
						if(isset($authtoken->auth_pass))
						$guest_user = $guest_user->where('user_pass', $authtoken->auth_pass);
						
						// if user company is provided please authenticate it
						if(isset($authtoken->auth_comp))
						$guest_user = $guest_user->where('sys_company_id', $authtoken->auth_comp);
						
						// if user name is provided please authenticate it
						if(isset($authtoken->auth_name))
							$guest_user = $guest_user->where('user_name', $authtoken->auth_name)->find_one();
						else
							$guest_user = $guest_user->find_one($authtoken->auth_user);						
										
						// check if user exists
						if(is_object($guest_user))
						{	
							// start session and set session values
							self::set_state(true);
							self::set('user_id', $guest_user->id);
							self::set('user_name', $guest_user->user_name);
							self::set('first_name', $guest_user->first_name);
							self::set('last_name', $guest_user->last_name);
							self::set('full_name', trim($guest_user->first_name.' '.$guest_user->last_name));
							self::set('email', $guest_user->email);
							self::set('mobile', $guest_user->mobile);
							self::set('company_id', (empty($guest_user->sys_company_id) ? $authtoken->company_id : $guest_user->sys_company_id));
							self::set('is_super_admin', $guest_user->is_super_admin);	
							self::set('is_guest', ($authtoken->auth_user==GUEST_ID ? 1 : 0));	
							self::set('last_login', $guest_user->last_login);	
							self::set('logged_with_master_password', false);
							self::set('authtoken', $authtoken);
						}
						else
						{
							// redirect to given path
							header('Location: '.BASE_URL.'/'.$redirect_to_default.'/authtoken_error?authtoken='.$_GET['authtoken']);
						}
                        */
					}
					else
					{
						// redirect to given path
						header('Location: '.BASE_URL.'/'.$redirect_to_default.(empty($returnUrl) ? '' : '?returnUrl='.$returnUrl));
					}					
				}
			}
			/*else
			{
				// check if auth token is submitted
				if(isset($_GET['authtoken']))
				{
					// check for valid auth user
					if($authtoken->auth_user!=GUEST_ID)
					{
						// redirect to given path
						header('Location: '.BASE_URL.'/'.$redirect_to_default.'/authtoken_error?authtoken='.$_GET['authtoken']);
					}
				}
			}*/
		}
		
		/**
		* Set Session State
		*
		* Function set_state
		* @author Susanta Das
		*/
		public static function set_state($state) {								
			self::set('session_state', $state);
		}
		
		/**
		* Set Session State
		*
		* Function set_state
		* @author Susanta Das
		*/
		public static function get_state() {								
			return self::get('session_state');
		}
	}
?>
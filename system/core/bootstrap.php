<?	
	/**
	* Bootstrap Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Bootstrap extends Session {		
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {			
			// prevent XSS
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            parent::__construct();
						
			// create error instance
			$this->error = new Error();
            
            // check for CSRF submission
			if(!empty($_POST)) {
				if (isset($_POST['csrfToken']) && !empty($_POST['csrfToken'])) {
					if (!hash_equals(Session::get('token'), $_POST['csrfToken'])) {
                        header('HTTP/1.0 400 Bad Request');
                        include('./400.html');
                        exit;                    
					}
				} else {
                    header('HTTP/1.0 400 Bad Request');
                    include('./400.html');
                    exit;
                }
			}
					
			// get request uri
			$uri = BASE_URI;
			
			// parse url to array
			$url = parse_url($uri);
			
			// regenerate uri from url
			$uri = $url['path'];
			
			// parse str to array
			if(isset($url['query']))
			parse_str($url['query'], $uri_values);
									
			// format request uri
			$uri = isset($uri) ? $uri : null;
			$uri = rtrim($uri, '/');
			$url_values = explode('/', $uri);
			
			// if uri string exists merge with url parameters
			//if(isset($url['query']) && is_array($uri_values))
			//$url_values = array_merge($url_values, $uri_values);
					
			//add escape character of POST data having single code
			function add_slashes(&$item, &$key)
			{
				$item = addslashes($item);
			}
			
			// add slashes to variable
			if(is_array($_POST)) array_walk_recursive($_POST, 'add_slashes');
			
			// get controller from uri query
			if(is_array($uri_values) && array_key_exists('controller', $uri_values))
			{
				// set controller from uri query
				$url_values[0] = $uri_values['controller'];
				
				// unset controller from uri query
				unset($url_values['controller']);
			}
			
			// get method from uri query
			if(is_array($uri_values) && array_key_exists('method', $uri_values))
			{
				// set method from uri query
				$url_values[1] = $uri_values['method'];
				
				// unset method from uri query
				unset($url_values['method']);
			}
											
			// check if url values
			if(empty($url_values[0]))
			{
				// include controller file
				require "application/controllers/index.php";					
				
				/**	
				* Default Controller
				*/
				define ('CONTROLLER', 'index');
				
				/**	
				* Default Method
				*/
				define ('METHOD', '');
								
				// unset elements
				unset($url_values[0]);
								
				// unset url key
				unset($_GET['url']);
								
				// reset from 0 index for parameters
				if(empty($_GET))
					$parameters = array_values($url_values);
				else
					$parameters = array_merge(array_values($url_values), $_GET);
				
                // sanitize parameters
                //$parameters = filter_input_array($parameters, FILTER_SANITIZE_STRING);
				
				/**	
				* Default Parameters
				*/				
				define ('PARAMETERS', json_encode($parameters));
				
				// check if index controller class exists
				if(class_exists('index'))
					$controller_mod = new index();				
				else
					$this->error->raise("'<span class=\"msgblue\">index</span>' Controller Class not found", 'Object Not Found');										
				
				// call default method index
				if(empty($method))
				{						
					//call index method
					if(method_exists($controller_mod, 'index'))
						$controller_mod->index();
					else
						$this->error->raise("'<span class=\"msgred\">index</span>' Method not found in '<span class=\"msgblue\">$controller</span>' Controller", 'Object Not Found');												
				}
			}
			else
			{				
				/**	
				* Default Controller
				*/
				define ('_CONTROLLER_', $url_values[0]);
				
				/**	
				* Default Method
				*/
				define ('_METHOD_', $url_values[1]);
				
				$controller = str_replace('-', '_', $url_values[0]);
				$method = isset($url_values[1]) ? str_replace('-', '_', $url_values[1]) : null;
												
				// unset elements
				unset($url_values[0]);
				unset($url_values[1]);
								
				// unset url key
				unset($_GET['url']);
								
				// reset from 0 index for parameters
				if(empty($_GET))
					$parameters = array_values($url_values);
				else
					$parameters = array_merge(array_values($url_values), $_GET);
               
				// check uuid
				foreach($parameters as $index=>$parameter)
				{
					if(strlen(trim($parameter)) >= 36 && is_numeric($index))
					{				
						if(!Functions::CheckValidUUID($parameter))
						{
							header('HTTP/1.0 400 Bad Request');
							include('./400.html');		
							exit;
						}
					}
				}

				// sanitize parameters
                //$parameters = filter_input_array($parameters, FILTER_SANITIZE_STRING);
								
				/**	
				* Default Controller
				*/
				define ('CONTROLLER', $controller);
				
				/**	
				* Default Method
				*/
				define ('METHOD', $method);
				
				/**	
				* Default Parameters
				*/				
				define ('PARAMETERS', json_encode($parameters));
								
				// check controller file exits
				if(file_exists("application/controllers/$controller.php")) 
				{					
					// include controller file
					require "application/controllers/$controller.php";			
					
					// check if controller class exists then create controller instance
					if(class_exists($controller))
						$controller_mod = new $controller();
					else
						$this->error->raise("'<span class=\"msgblue\">$controller</span>' Controller Class not found", 'Object Not Found');						
									
					// call default method index
					if(empty($method))
					{						
						//call index method
						if(method_exists($controller_mod, 'index'))
							$controller_mod->index();
						else
							$this->error->raise("'<span class=\"msgred\">index</span>' Method not found in '<span class=\"msgblue\">$controller</span>' Controller", 'Object Not Found');												
					}	
		
					// check if controller method exists
					if(isset($method) && trim($method)!='')
					{				
						if(method_exists($controller_mod, $method))
						{	
							// call the method
							if(count($parameters) > 0)
								call_user_func_array(array($controller_mod, $method), $parameters);
							else
								$controller_mod->{$method}();				
						}
						else
							$this->error->raise("'<span class=\"msgred\">$method</span>' Method not found in '<span class=\"msgblue\">$controller</span>' Controller", 'Object Not Found');												
					}				
				}	
				else
					$this->error->raise("'<span class=\"msgblue\">controllers/$controller.php</span>' Controller File not found", 'File Not Found');																																																			
			}
		}		
	}
?>
<?	
	/**
	* Main MsgBox Class
	*
	* @link http://somnetics.in/
	* @copyright 2010-2011 Somnetics Pvt. Ltd.
	* @author Susanta Das <susanta.das@somnet.co.in>
	* @version 1.0.50
	*/

	/**
	* DIR_SEP isn't used anymore, but third party apps might
	*/
	class MsgBox {
		//set variable
		protected static $variables = array();
		protected static $viewobj = null;
		
		function __construct($view_object=null)
		{
			// creates a view object
			if(is_object($view_object))
				self::$viewobj = $view_object;
			else
				self::$viewobj = null;
		}
		
		/**
		* Message Box to view system message
		*
		* Function show
		* @param $message as string
		* @param $caption as string
		* @param $button_style as string
		* @param $yes_ok_path as string
		* @param $no_cancel_path as string
		* @returns none
		* @author Susanta Das
		*/
		public static function show($message, $caption='Message', $suggestions=null, $window=true, $button_style=0, $icon_class='fa fa-warning text-warning', $yes_ok_path=REQUEST_URL, $no_cancel_path=RETURN_URL) 
		{	
			if(is_object(self::$viewobj))
			{
                // assign message
				self::$viewobj->assign('message', $message);
				
				// assign caption
				self::$viewobj->assign('caption', $caption);
						
				// assign suggestions
				self::$viewobj->assign('suggestions', $suggestions);
				
				// assign button_style
				self::$viewobj->assign('button_style', $button_style);

                // assign icon class
				self::$viewobj->assign('icon_class', $icon_class);				
				
				// assign yes_ok_path
				self::$viewobj->assign('yes_ok_path', $yes_ok_path);
				
				if(empty($no_cancel_path))
				$no_cancel_path = APP_PATH.'/'.self::$viewobj->controller;
				
				// assign no_cancel_path
				self::$viewobj->assign('no_cancel_path', $no_cancel_path);
				
				// window style
				self::$viewobj->assign('window', $window);
				
				// display the error
				self::$viewobj->display(self::$viewobj->msgbox_file, false, false);
			}
			else
			{
				// assign message
				self::assign('message', $message);
				
				// assign caption
				self::assign('caption', $caption);
						
				// assign suggestions
				self::assign('suggestions', $suggestions);
				
				// assign button_style
				self::assign('button_style', $button_style);
				
				// assign icon class
				self::assign('icon_class', $icon_class);	
				
				// assign yes_ok_path
				self::assign('yes_ok_path', $yes_ok_path);
				
				// assign no_cancel_path
				self::assign('no_cancel_path', $no_cancel_path);
				
				// window style
				self::assign('window', $window);
				
				// display the error
				self::display();
			}
			
			exit;
		}
		
		/**
		* Message Box to view system message
		*
		* Function show
		* @param $view_object as object
		* @returns object
		* @author Susanta Das
		*/
		public static function view($view_object) 
		{
			return new self($view_object);
		}
		
		/**
		* Assign Variable to View Template
		*
		* Function assign
		* @param $variable as string
		* @param $value as variant
		* @author Susanta Das
		*/
		protected function assign($variable, $value) {	
			//assign original value to view object variable
			self::$variables[$variable] = $value;
		}
		
		/**
		* Render Template With Cache
		*
		* Function render
		* @author Susanta Das
		*/
		protected function display() {			
			//object start
			ob_start();
			
			//Import variables from an array into the current symbol table. 
			extract(self::$variables);
			
			// include swithboad template file
			require "application/views/".MSGBOX_FILE;
						
			//object flush
			ob_end_flush();				
		}
	}
?>

<?
	/**
	* Emrald Core Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class core {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {				
			// object start
			ob_start('ob_gzhandler');
			
			// include system config	
			require "config/system.config.php";
			
			// include application config	
			require APPLICATION_PATH."/config/app.config.php";
			
			// include lang config	
			require APPLICATION_PATH."/config/lang.class.php";
						
			// include error class
			require "libs/error.class.php";
            
            // include msgbox class	
			require "libs/msgbox.class.php";
						
			// include database wrapper class
			require "libs/orm.class.php";
			
			// include database config file
			require "libs/db.config.php";			
								
			// include function class
			require "libs/functions.class.php";
			
			// include extended function class
			require APPLICATION_PATH."/extended/functions.class.php";
			
			// include image class
			require "libs/image.class.php";
            
            // include session class
			require "libs/session.class.php";
					
			// include cookies class
			require "libs/cookies.class.php";
			
			// include bootstrap class
			require "bootstrap.php";			
			
			// include main controller class
			require "controller.php";
			
			// include extended controller class
			require APPLICATION_PATH."/extended/controller.php";
			
			// include main model class
			require "model.php";
			
			// include extended model class
			require APPLICATION_PATH."/extended/model.php";
			
			// include main form class
			require "libs/form.class.php";
			
			// include extended form class
			require APPLICATION_PATH."/extended/form.class.php";
			
			// include main view class
			require "view.php";
			
			// include extended view class
			require APPLICATION_PATH."/extended/view.php";
			
			// initiate bootstrap class
			$Bootstrap = new Bootstrap();	

			// object flush
			ob_end_flush();	
		}		
	}
    
    /**
	* Page Translator
	*
	* Function translator
	* @author Susanta Das
	* @param $data as string
	*/
	function translator($data) {
		// include lang file
		include "lang/ben.php";
		
		// convert language
		if(!empty($lang))
			return str_replace(array_keys($lang), array_values($lang), $data);		
		else
			return $data;
	}
	
	/**
	* Print Recursive Function
	*
	* Function pr
	* @author Susanta Das
	* @param $data as string
	* @param $exit as boolean
	* @param $is_data as boolean
	*/
	function pr($data, $exit=true, $trace=false, $is_data=true) {		
		echo '<pre style="background:#000;color:#fff;padding:10px;">';
		
		// if trace
		if($trace)
		{
			echo "<b style=\"color:#0ff\">Trace : ".AJAX_URL.'/'.METHOD."</b>";
			
			// loop trace path
			foreach (debug_backtrace() as $l=>$trace)
			{
				echo sprintf("\n\t<span style=\"color:#ff0\">".($l+1)." : Script</span> : %s\n\t\t<span style=\"color:#0f0\">Line</span> : %s\n\t\t<span style=\"color:#f00\">Class</span> : %s\n\t\t<span style=\"color:#f0f\">Function</span> : %s", $trace['file'], $trace['line'], $trace['class'], $trace['function']);
			}
			
			echo "\n\n";
		}
		
		// if is_data print data
		if($is_data)
		{
			echo "<b style=\"color:#0ff\">Data : ".BASE_URI."</b>\n";
			print_r($data);		
		}
		
		echo '</pre>';
		
		// if true exit
		if($exit){exit;}
	}
	
    // hash_equals funtion for lower version of php
	if(!function_exists('hash_equals'))
	{
		function hash_equals($str1, $str2)
		{
			if(strlen($str1) != strlen($str2))
			{
				return false;
			}
			else
			{
				$res = $str1 ^ $str2;
				$ret = 0;
				for($i = strlen($res) - 1; $i >= 0; $i--)
				{
					$ret |= ord($res[$i]);
				}
				return !$ret;
			}
		}
	}
?>
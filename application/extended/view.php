<?
	/**
	* Extends Main View Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class View extends MainView {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct();
                        
            // set title with controller
            $this->title = ucwords(str_replace('_', ' ', $this->controller));
            
            // set title with method
            if(!empty($this->method)) $this->title .= ' - '.ucwords(str_replace('_', ' ', $this->method));
		}
	}
?>
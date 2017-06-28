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
	}
?>
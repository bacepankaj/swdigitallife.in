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
            
            // default operation menu
            $this->operation_menu = array(
                                            'dashboard'=>'<i class="fa fa-dashboard"></i> Dashboard',
                                            'create'=>'<i class="fa fa-plus"></i> Create',												
                                            'search'=>'<i class="fa fa-search"></i> Search',							
                                            'delete'=>'<i class="fa fa-remove"></i> Delete',
                                            'trash'=>'<i class="fa fa-trash"></i> Trash',
                                            //'audit_logs'=>'<i class="fa fa-paw bigger-110 pink"></i> Audit Logs',
                                            //'reports'.(isset($this->parameters['tab']) && $this->method=='reports' ? '?tab='.$this->parameters['tab'] : '?tab=user_activity')=>'<i class="fa fa-bar-chart bigger-110 blue"></i> Reports',
                                            //'faq'=>'<i class="fa fa-question bigger-110 orange"></i> FAQ'
                                        );
            
            // filter operation menu
            if(!isset($this->parameters[0])) unset($this->operation_menu['delete']);
            if(!Session::get('is_admin')) unset($this->operation_menu['trash']);
            
            // module info
            $this->caption = ucwords(str_replace('_', ' ', $this->controller));
            $this->description = null;
            $this->icon = 'fa fa-info-circle';
		}
	}
?>
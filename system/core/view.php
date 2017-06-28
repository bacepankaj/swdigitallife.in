<?
	/**
	* Main View Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class MainView {
		//set variable
		protected $variables = array();
			
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			// get controller name
			$this->controller = CONTROLLER;
			
			// get method name
			$this->method = METHOD;
			
			// get controller parameters
			$this->parameters = json_decode(PARAMETERS, true);
			
			// view path
			$this->view_path = 'application/views';
					
			// header file
			$this->header_file = HEADER_FILE;
														
			// footer file
			$this->footer_file = FOOTER_FILE;
            
            // search file
			$this->search_file = SEARCH_FILE;
			
			// msgbox file
			$this->msgbox_file = MSGBOX_FILE;
			
			// default template
			$this->template = CONTROLLER.'/'.CONTROLLER.'.html';
			
			// set action path
			$this->action_path = APP_PATH.'/'.CONTROLLER;
			
			// default form action
			$this->form_action = FORM_ACTION;
			
			// create Form instance	
			$this->form = new Form();
			
			//initiate function class
			$this->functions = new Functions();			
		}
				
		/**
		* Assign Variable to View Template
		*
		* Function assign
		* @param $variable as string
		* @param $value as variant
		* @param $selected_value as string
		* @author Susanta Das
		*/
		public function assign($variable, $value, $selected_value=null) {	
			//assign original value to view object variable
			$this->variables[$variable] = $value;
		}
		
		/**
		* Display Template
		*
		* Function display
		* @param $template as string
		* @param $view_header_ as boolean
		* @param $view_footer_ as boolean
		* @author Susanta Das
		*/
		public function display($template=null, $view_header_=true, $view_footer_=true) {				
			//get template			
			$template_ = $this->view_path.'/'.$template;	
           				
			// check if file exists
			if(file_exists($template_) || empty($template)) 
			{				
				// display header			
				if($view_header_ && file_exists($this->view_path.'/'.$this->header_file) && trim($this->view_path.'/'.$this->header_file)!='')
				$this->render($this->view_path.'/'.$this->header_file);						
				
				// include template file
				if(!empty($template))
				{					
					// render template
					$this->render($template_);
					
					// application debug
					if(APP_DEBUG){echo "<p>View Initialization - [$template_]</p>";}
				}
				
				// display footer
				if($view_footer_ && file_exists($this->view_path.'/'.$this->footer_file) && trim($this->view_path.'/'.$this->footer_file)!='')
				$this->render($this->view_path.'/'.$this->footer_file);
			}
		}
				
		/**
		* Render Template With Cache
		*
		* Function render
		* @param $template as string
		* @author Susanta Das
		*/
		public function render($template) {			
			//object start
			ob_start();
			
			//Import variables from an array into the current symbol table. 
			extract($this->variables);
			
			// include template file
			include $template;
			
			//object flush
			ob_end_flush();				
		}
		
		/**
		* Fetch Database Table Object
		*
		* Function column_data
		* @param $table as string
		* @param $id as string
		* @param $field as string / array
		* @param $key as string default id
		* @returns string
		* @author Susanta Das
		*/
		function column_data($table, $id, $fields, $key='id'){
			// check if database is used
			if(APP_DATABASE)
			{
				// get table object
				$table_obj = ORM::for_table($table);
				
				// get table rs
				$rs = $table_obj->where($key, $id)->find_one();
											
				// return table field			
				if(is_array($fields))
				{				
					// loop for the array field value
					$value = null;
					foreach($fields as $field)
					{
						if(isset($rs->$field))
							$value .= trim($rs->$field);
						else
							$value .= $field;
					}
				}
				else
					$value = $rs->$fields;
							
				return trim($value);
			}
		}
	}
?>
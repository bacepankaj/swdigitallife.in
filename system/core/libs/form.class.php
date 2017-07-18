<?
	/**
	* Main Form Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class MainForm {				
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
			
			// get form parameters
			$this->parameters = json_decode(PARAMETERS, true);
			
			// set action path
			$this->action_path = APP_PATH.'/'.CONTROLLER;
			
			// default form action
			$this->form_action = FORM_ACTION;
		}
		
		/**
		* Textbox Form Element
		*
		* Function textbox
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function textbox($element_attributes, $disabled=false) {			
			//return element
			return $this->input('text', $element_attributes, $disabled);
		}
		
		/**
		* Password Form Element
		*
		* Function password
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function password($element_attributes, $disabled=false) {			
			//return element
			return $this->input('password', $element_attributes, $disabled);
		}
		
		/**
		* Hidden Form Element
		*
		* Function hidden
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function hidden($element_attributes, $disabled=false) {						
			//return element
			return $this->input('hidden', $element_attributes, $disabled);
		}
		
		/**
		* Submit Form Element
		*
		* Function submit
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function submit($element_attributes, $disabled=false) {						
			//return element
			return $this->input('submit', $element_attributes, $disabled);
		}
		
		/**
		* Reset Form Element
		*
		* Function reset
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function reset($element_attributes, $disabled=false) {						
			//return element
			return $this->input('reset', $element_attributes, $disabled);
		}
		
		/**
		* Button Form Element
		*
		* Function textarea
		* @param $element_name as string
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function button($element_attributes, $disabled=false) {			
			//get attributes
			$attributes = null;
			$get_value = null;
			$state = null;
			
			foreach($element_attributes as $attribute=>$value)
			{
				if($attribute == 'value')
					$get_value = $value;
				else
					$attributes .= "$attribute=\"$value\" ";
					
				if($attribute == 'type')
				$type = $value;
			}
			
			if($disabled || $this->disable)
			$state = ' disabled';	
			
			//get parameters
			if(!empty($this->parameters))
			$parameters = '/'.implode('/', $this->parameters);
			
			//return element
			if($type=='submit' && ($disabled || $this->disable))
				return '<a href="'.APP_PATH.'/'.$this->controller.'/edit'.$parameters.'"><button '.str_replace('type="submit"', 'type="button"', rtrim($attributes, ' ')).'><i class="icon-pencil icon-on-left"></i>Edit</button></a>';
			else
				return '<button '.rtrim($attributes, ' ').$state.'>'.$get_value.'</button>';
		}
		
		/**
		* Button Form Element
		*
		* Function button
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function _button($element_attributes, $disabled=false) {						
			//return element
			return $this->input('button', $element_attributes, $disabled);
		}
		
		/**
		* Input Form Element
		*
		* Function input
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		protected function input($type, $element_attributes, $disabled=false) {			
			//change the caption of submit button on view record operation
			if($type=='submit' && ($disabled || $this->disable))
			$element_attributes['value'] = 'Edit';
			
			//get attributes
			$attributes = null;
			$state = null;
			
			foreach($element_attributes as $attribute=>$value)
			{
				if($attribute == 'value')
				$get_value = $value;
				
				$attributes .= "$attribute=\"$value\" ";
			}
			
			if($disabled || $this->disable)
			$state = ' disabled';	
			            
			//get parameters
			if(!empty($this->parameters))
			$parameters = '/'.implode('/', $this->parameters);
						
			//return element
			if($type=='submit' && ($disabled || $this->disable))
				return '<a href="'.APP_PATH.'/'.$this->controller.'/edit'.$parameters.'"><input type="button" '.rtrim($attributes, ' ').'></a>';
			else
				return '<input type="'.$type.'" '.rtrim($attributes, ' ').$state.' />';
		}		
		
		/**
		* Checkbox Form Element
		*
		* Function checkbox
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function checkbox($element_attributes, $checked=false, $disabled=false) {			
			//get attributes
			$attributes = null;
			$checked_state = null;
			$disabled_state = null;
			$get_checked_value = null;
						
			foreach($element_attributes as $attribute=>$value)
			{
				if($attribute == 'checked_value')
				$get_checked_value = $value;
				
				if($attribute == 'value')
				$get_value = $value;
				
				$attributes .= "$attribute=\"$value\" ";
			}
			
			if(!is_array($get_checked_value) && strstr($get_checked_value, ','))
			$get_checked_value = explode(',', $get_checked_value);
			
			if($checked || (isset($get_value) && $get_value == $get_checked_value) || in_array($get_value, $get_checked_value))
			$checked_state = ' checked';	
			
			if($disabled || $this->disable)
			$disabled_state = ' disabled';	
			
			//return element
			return '<input type="checkbox" '.rtrim($attributes, ' ').$disabled_state.$checked_state.' />';
		}
		
		/**
		* Radio Form Element
		*
		* Function radio
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function radio($element_attributes, $checked=false, $disabled=false) {			
			//get attributes
			$attributes = null;
			$checked_state = null;
			$disabled_state = null;
			
			foreach($element_attributes as $attribute=>$value)
			{
				if($attribute == 'checked_value')
				$get_checked_value = $value;
				
				if($attribute == 'value')
				$get_value = $value;
				
				$attributes .= "$attribute=\"$value\" ";
			}
			
			if(!is_array($get_checked_value) && strstr($get_checked_value, ','))
			$get_checked_value = explode(',', $get_checked_value);
			
			if($checked || (isset($get_value) && $get_value == $get_checked_value) || in_array($get_value, $get_checked_value))
			$checked_state = ' checked';	
			
			if($disabled || $this->disable)
			$disabled_state = ' disabled';	
			
			//return element
			return '<input type="radio" '.rtrim($attributes, ' ').$disabled_state.$checked_state.' />';
		}		
		
		/**
		* Textarea Form Element
		*
		* Function textarea
		* @param $element_name as string
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function textarea($element_attributes, $disabled=false) {			
			//get attributes
			$attributes = null;
			$get_value = null;
			$state = null;
			
			foreach($element_attributes as $attribute=>$value)
			{
				if($attribute == 'value')
				$get_value = $value;
				
				$attributes .= "$attribute=\"$value\" ";
			}
			
			if($disabled || $this->disable)
			$state = ' disabled';				
			
			//return element
			return '<textarea '.rtrim($attributes, ' ').$state.'>'.$get_value.'</textarea>';
		}
		
		/**
		* Textarea Form Element
		*
		* Function textarea
		* @param $element_name as string
		* @param $options as array
		* @param $element_attributes as array
		* @returns element as string
		* @author Susanta Das
		*/
		public function select($options, $element_attributes, $disabled=false) {			
			//get attributes
			$attributes = null;
			$get_value = null;
			$state = null;
			
			foreach($element_attributes as $attribute=>$value)
			{
				if($attribute == 'value')
				$get_value = $value;
								
				if($attribute == 'name')
				$get_name = $value;
				
				if($attribute == 'placeholder')
				$get_placeholder = $value;
				
				if($attribute != 'value')
				$attributes .= "$attribute=\"$value\" ";
			}
			
			if(!is_array($get_value) && strstr($get_value, ','))
			$get_value = explode(',', $get_value);
								
			//create options	
			$get_options = null;			
			if(!empty($options))
			{
				foreach($options as $value=>$label)
				{
					if(empty($value)) $label = $get_placeholder;
                        
                    //get selected option
					if(is_array($get_value)) // check if value is multiple
					{	
						if(in_array($value, $get_value))
							$selected = 'selected="selected"';
						else
							$selected = null;
					}			
					else // check if value is single
					{					
						if($value == trim($get_value))
							$selected = 'selected="selected"';
						else
							$selected = null;	
					}
					
					$get_options .= '<option '.$selected.' value="'.$value.'">'.$label.'</option>';
				}
			}
			
			if($disabled || $this->disable)
			$state = ' disabled';	
			
			//return element
			return '<select '.rtrim($attributes, ' ').$state.'>'.$get_options.'</select>';
		}
		
		/**
		* Open Form Element
		*
		* Function form_open
		* @param $method as string
		* @param $action as string
		* @param $name as string
		* @param $autocomplete as boolean
		* @param $multipart as boolean
		* @param $charset as string
		* @returns element as string
		* @author Susanta Das
		*/
		public function form_open($element_attributes=array()) {			
			//get attributes
			$attributes = null;
						
            // default attributes
            if(!array_key_exists('method', $element_attributes))
            $element_attributes['method'] = 'POST';
                        
            if(!array_key_exists('action', $element_attributes))
                $element_attributes['action'] = $this->action_path.'/'.$this->form_action;
            else
                $element_attributes['action'] = $element_attributes['action'];
            
            if(!array_key_exists('autocomplete', $element_attributes))
            $element_attributes['autocomplete'] = 'off';
            
            if(!array_key_exists('enctype', $element_attributes))
            $element_attributes['enctype'] = 'multipart/form-data';
            
            if(!array_key_exists('charset', $element_attributes))
            $element_attributes['charset'] = 'utf-8';
                                    
            foreach($element_attributes as $attribute=>$value)
            {
                $attributes .= "$attribute=\"$value\" ";
            }            
						
			//return element
			return '<form '.rtrim($attributes, ' ').'><input type="hidden" name="csrfToken" value="'.Session::get('token').'"><input type="hidden" name="returnUrl" value="'.urlencode(BASE_URI).'">';
		}
		
		/**
		* Close Form Element
		*
		* Function form_close
		* @returns element as string
		* @author Susanta Das
		*/
		public function form_close() {
			//return element
			return '</form>';
		}
	}
?>
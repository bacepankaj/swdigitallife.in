<?
	/**
	* Main Function Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/

	/**
	* DIR_SEP isn't used anymore, but third party apps might
	*/
	class MainFunctions {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/		
		function __construct() {						
			
		}
		
		/**
		* Function to Generate Random String
		*
		* Function GenerateRandomString
		* @param $length as string
		* @returns string
		* @author Susanta Das
		*/
		public function GenerateRandomString($length = 10, $characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}

		/**
		* Generate UUID	
		*
		* Function uuid
		* @returns string
		* @author Susanta Das
		*/
		public function uuid()
		{
			$uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
			
			return $uuid;
		}
		
		/**
		* Generate Id
		*
		* Function GenerateId
		* @param $tablename as string
		* @param $fieldname as string
		* @param $prefix as string, default=''
		* @param $generate_date as string, default=''
		* @returns string
		* @author Susanta Das
		*/					
		public function GenerateId($tablename, $fieldname, $prefix="", $generate_date="")
		{
			$l = strlen(trim($prefix));
			
			// get table object
			$rs = ORM::for_table($tablename);
			
			//check null for generate date			
			if($generate_date===false)
			{
				$generate_date = "";
				$date = false;
			}
			elseif(empty($generate_date))
			{
				$generate_date = date('ym');
				$date = true;
			}
			else
			{
				$generate_date = date('ym', strtotime($generate_date));
				$date = true;
			}
			
			$d = strlen($generate_date) + 1;
			
			if($date)
				$sql = "SELECT if(max(substr($fieldname, ".($l + $d).", 4)) is null, concat('".$generate_date."', '00001'), concat('".$generate_date."', lpad(max(substr($fieldname, ".($l + $d).", 5)) + 1, 5, '0'))) maxid FROM $tablename where substr($fieldname, ".($l + 1).", 4) = '".$generate_date."' and substr($fieldname, 1, $l) = '$prefix' $company_cond";
			else
				$sql = "SELECT if(max(substr($fieldname, ".($l + $d).", 4)) is null, concat('".$generate_date."', '00001'), concat('".$generate_date."', lpad(max(substr($fieldname, ".($l + $d).", 5)) + 1, 5, '0'))) maxid FROM $tablename where substr($fieldname, 1, $l) = '$prefix' $company_cond";
			
			// get recordset
			$max = $rs->raw_query($sql)->find_one();
	
			return $prefix.$max->maxid;
		}
		
		/**
		* Generate Serial Number
		*
		* Function GenSerialNumber
		* @param count as number
		* @returns array
		* @author Susanta Das
		*/
		public function GenSerialNumber($count=1)
		{
			$collection = array();
			
			for($i = 1; $i <= $count; $i++){
				$ukey = strtoupper(substr(sha1(microtime() . $i), rand(0, 5), 30));
				if(!in_array($ukey, $collection)){ // you can check this in database as well.
					$collection[] = implode("-", str_split($ukey, 5));
				}
			}

			return $collection;
		}

		/**
		* Check Valid UUID
		*
		* Function CheckValidUUID
		* @param $uuid as string
		* @returns boolean
		* @author Susanta Das
		*/	
		public function CheckValidUUID($uuid)
		{	
			if(preg_match('/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/', $uuid)) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		* Copy Array Value to Key	
		*
		* Function arrayCopyValue2Key
		* @param array
		* @returns array()
		* @author Susanta Das
		*/	
		public function arrayCopyValue2Key($array)
		{	
			foreach($array as $array_val)
			{
				$final_array[$array_val] = $array_val;
			}
			
			return $final_array;
		}

		/**
		* Copy Key to Array Value	
		*
		* Function arrayCopyKey2Value
		* @param $array
		* @returns array()
		* @author Susanta Das
		*/
		public function arrayCopyKey2Value($array)
		{	
			foreach($array as $array_key=>$array_val)
			{
				$final_array[$array_key] = $array_key;
			}
			
			return $final_array;
		}
			
		/**
		* Format Number	
		*
		* Function FormatNumber
		* @param $amount as string
		* @param $decimal_place as string, default=2
		* @param $show_zero_balance as string, defaut='false'
		* @param $seperator as string, default=','
		* @returns string
		* @author Susanta Das
		*/
		public function FormatNumber($amount, $decimal_place=2, $show_zero_balance=false, $seperator=',')
		{
			$format_amount = number_format($amount, $decimal_place, '.', $seperator);
			
			if($show_zero_balance == false && intval($amount) == '0')
			$format_amount = '';
			
			return $format_amount;
		}
		
		//Average from Array
		public function array_avg($arr) 
		{
			return array_sum($arr) / count(array_filter($arr));
		} 

		//pad with zeros
		public function PadNumber($number, $pad_num) 
		{
			return sprintf("%0" . $pad_num . "d", $number);
		}

		//get month name
		function GetMonthString($n)
		{
			$timestamp = mktime(0, 0, 0, $n, 1, 2005);
			
			return date("F", $timestamp);
		}
		
		//get Priority
		public function Priority($n)
		{
			switch($n){
				case 1:
					$priority = 'Urgent';
					break;
				case 2:				
					$priority = 'High';
					break;
				case 3:
					$priority = 'Medium';
					break;
				case 4:
					$priority = 'Low';
					break;				
			}
			
			return $priority;
		}

		/**
		* Bytes Conversion	
		*
		* Function BytesConversion
		* @param $amount as string
		* @param $show_zero_balance as string, defaut='false'
		* @param $decimal_place as string, default=2
		* @param $seperator as string, default=','
		* @returns string
		* @author Dipika Das
		*/
		public function BytesConversion($bytes)
		{			
			if($bytes < 1024)
			{	
				$bytes = $this->FormatAmount($bytes, true);
				$result = $bytes." B";
			}
			elseif($bytes >= pow(1024, 1) && $bytes < pow(1024, 2))
			{
				$bytes = $bytes / pow(1024, 1);
				$bytes = $this->FormatAmount($bytes, true);
				
				$result = "$bytes KB";
			}
			elseif($bytes >= pow(1024, 2) && $bytes < pow(1024, 3))
			{
				$bytes = $bytes / pow(1024, 2);
				$bytes = $this->FormatAmount($bytes, true);
				
				$result = "$bytes MB";
			}
			elseif($bytes >= pow(1024, 3) && $bytes < pow(1024, 4))
			{
				$bytes = $bytes / pow(1024, 3);
				$bytes = $this->FormatAmount($bytes, true);
				
				$result = "$bytes GB";
			}
			
			return $result;
		}	
		
		/**
		* Format String	
		*
		* Function FormatString
		* @param $string as string
		* @param $align as string, default='LEFT'
		* @param $pad_length as string
		* @param $pad_char as string, default=''
		* @returns string
		* @author Susanta Das
		*/
		public function FormatString($string, $align=LEFT, $pad_length, $pad_char=' ')
		{
			$string = trim($string);
			
			if($align==LEFT)
				$format_string = $string.str_repeat($pad_char, $pad_length - strlen($string));
			else
				$format_string = str_repeat($pad_char, $pad_length - strlen($string)).$string;
			
			return $format_string;
		}
					
		/**
		* Convert PHP Date format	
		*
		* Function date_format
		* @param $date as string
		* @param $format as string
		* @returns string
		* @author Susanta Das
		*/
		function date_format($date, $format='Y-m-d', $show_current_date=false)
		{	
			//if(!empty($date))
			if(!empty($date) && ($date + 0) > 0)
				return date($format, strtotime($date));
			else
			{
				if($show_current_date)
					return date($format);	
				else
					return '';//return preg_replace('/[0-9]/s', '0', date($format));								
			}
		}
		
		/**
		* Convert Date Time to PHP Date	
		*
		* Function FormatDateTime
		* @param $date_php as string
		* @param $format as string
		* @returns string
		* @author Susanta Das
		*/
		public function FormatDateTime($date_php, $format="d-m-Y h:i A")
		{
			return date($format, strtotime($date_php));
		}
		
		/**
		* Get File Name Extension
		*
		* Function GetFileNameExtension
		* @param $filename as string
		* @returns array
		* @author Susanta Das
		*/
		public function GetFileNameExtension($filename)
		{
			$file_name_extension = explode('.', trim($filename));
			
			if(count($file_name_extension) > 1)
			{
				$arr_cnt = count($file_name_extension) - 1;
				$real_extension = $file_name_extension[$arr_cnt];					
				$file_extension_len = strlen($real_extension) + 1;
				$real_filename = substr($filename, 0, -$file_extension_len);			
			}
			else
			{
				$real_filename = $filename;
				$real_extension = "";
			}
			
			return array('file_name'=>$real_filename, 'file_ext'=>$real_extension);
		}

		/**
		* Filter Special Charatars
		*
		* Function FilterSpecialChars
		* @param $string as string
		* @returns array
		* @author Susanta Das
		*/
		public function FilterSpecialChars($string)
		{
			return str_replace('^~^', '+', str_replace('~^~', '&', $string));
		}
		
		/**
		* Remove Common Words
		*
		* Function RemoveCommonWords
		* @param $string as string
		* @returns array
		* @author Susanta Das
		*/
		public function RemoveCommonWords($string)
		{
			$string = preg_replace('/[^a-zA-Z0-9@.,\']/', ' ', $string);		
			$string = preg_replace('/[.]+/', '.', $string);		
			$string = preg_replace('/[@]+/', '@', $string);	
			$string = preg_replace('#(?:\s+\S{1,3}.?)+\s+#', ' ', $string);
			$string = preg_replace('/\s\s+/', ' ', $string);
			
			$old_array = explode(' ', $string);  
			$new_string = implode(' ', array_unique($old_array));  
			
			return addslashes($new_string);
		}					
		
		/**
		* Function to get difference between two date
		*
		* Function dateDiff
		* @param $time1 as string
		* @param $time2 as string
		* @param $precision as string, default=6
		* @returns string
		* @author Susanta Das
		*/	
		public function dateDiff($time1, $time2, $precision = 6) 
		{
			// If not numeric then convert texts to unix timestamps
			if(!is_int($time1))
			$time1 = strtotime($time1);
					
			if(!is_int($time2))
			$time2 = strtotime($time2);
				 
			// If time1 is bigger than time2
			// Then swap time1 and time2
			if($time1 > $time2)
			{
				$ttime = $time1;
				$time1 = $time2;
				$time2 = $ttime;
			}
		 
			// Set up intervals and diffs arrays
			$intervals = array('year','month','day','hour','minute','second');
		   
			$diffs = array();
		 
			// Loop thru all intervals
			foreach($intervals as $interval)
			{
				// Set default diff to 0
				$diffs[$interval] = 0;
				// Create temp time from time1 and interval
				$ttime = strtotime("+1 " . $interval, $time1);
				// Loop until temp time is smaller than time2
				while($time2 >= $ttime)
				{
					$time1 = $ttime;
					$diffs[$interval]++;
					// Create new temp time from time1 and interval
					$ttime = strtotime("+1 " . $interval, $time1);
				}
			}
		 
			$count = 0;
			$times = array();
			
			// Loop thru all diffs
			foreach($diffs as $interval => $value)
			{
				// Break if we have needed precission
				if ($count >= $precision)
				break;

				// Add value and interval 
				// if value is bigger than 0
				if($value > 0)
				{
					// Add s if value is not 1
					if($value != 1)
					$interval .= "s";
					
					// Add value and interval to times array
					$times[] = $value . " " . $interval;
					$count++;
				}
			}
		 
			// Return string with times
			return implode(", ", $times);
		}

		/**
		* Function to get dates between two date
		*
		* Function DatesInBetween
		* @param $date1 as string
		* @param $date2 as string
		* @returns array()
		* @author Susanta Das
		*/		
		public function DatesInBetween($date1, $date2, $interval=null)
		{
			$day = 60*60*24;

			$start_date[] = $date1;	
			$date1 = strtotime($date1);
			$date2 = strtotime($date2);

			$dates_array = array();
			$final_array = array();
		   
			
			if($interval != null)
			{
				$days_diff = round((($date2 - $date1)/$day)/$interval); // Unix time difference divided in a number of days interval to get total days in between

				for($x = 1; $x < $days_diff; $x++){
					$dates_array[] = date('Y-m-d',($date1+($day*$x*$interval)));
				}

			}
			else
			{
				$days_diff = round(($date2 - $date1)/$day); // Unix time difference divided by 1 day to get total days in between

				for($x = 1; $x < $days_diff; $x++){
					$dates_array[] = date('Y-m-d',($date1+($day*$x)));
				}
			}

			$dates_array[] = date('Y-m-d',$date2);
			$final_array = array_merge($start_date,$dates_array);
		
			return $final_array;
		}

		/**
		* Function to get dates after adding
		*
		* Function DateAdd
		* @param $date as string
		* @param $addwith as string
		* @returns string
		* @author Susanta Das
		*/		
		public function DateAdd($date, $addwith)
		{
			$date = strtotime(date("d-m-Y", strtotime($date)) . " +".strtolower($addwith));
			return date('d-m-Y', $date);
		}
		
		/**
		* Function time_passed
		*
		* Function time_passed
		* @param $timestamp as integer
		* @returns string
		* @author Susanta Das
		*/		
		public function time_passed($datetime)
		{
			$timestamp = strtotime($datetime);
			$diff = time() - (int)$timestamp;

			if ($diff == 0) 
			return 'Just Now';

			$intervals = array
			(
				1                   => array('year',    31556926),
				$diff < 31556926    => array('month',   2628000),
				$diff < 2629744     => array('week',    604800),
				$diff < 604800      => array('day',     86400),
				$diff < 86400       => array('hour',    3600),
				$diff < 3600        => array('minute',  60),
				$diff < 60          => array('second',  1)
			);

			$value = floor($diff/$intervals[1][1]);
			return $value.' '.$intervals[1][0].($value > 1 ? 's' : '').' ago';
		}
		
		/**
		* Function Get User Name
		*
		* Function get_user_name
		* @param $full_name as string
		* @returns string
		* @author Susanta Das
		*/
		public function get_user_name($full_name){
			if($full_name == Session::get('full_name'))
				return 'You';
			else
				return $full_name;				
		}
		
		public function browser_info($agent=null)
		{
			$known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');
			$agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
			$pattern = '#(?<browser>' . join('|', $known).')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';

			if (!preg_match_all($pattern, $agent, $matches)) return array();
			$i = count($matches['browser'])-1;
				
			//return array($matches['browser'][$i] => $matches['version'][$i]);
			return $matches['browser'][$i];
		}
		
		public function array_put_to_position(&$array, $position, $object, $name = null)
		{
			$count = 0;
			$return = array();
			
			foreach ($array as $k => $v)
			{  
				// insert new object
				if ($count == $position)
				{  
					if (!$name) $name = $count;
					$return[$name] = $object;
					$inserted = true;
				}  
				// insert old object
				$return[$k] = $v;
				$count++;
			}  
			
			if (!$name) $name = $count;
			if (!$inserted) $return[$name];
			$array = $return;			
			return $array;
		}
		
		/**
		* get Mac Address
		*
		* Function getMacAddress		
		* @returns string
		* @author Susanta Das
		*/
		public function getMacAddress(){
			if(strtolower(PHP_OS)=='linux')
			{
				exec("ifconfig", $output);
				
				foreach($output as $line){
					if (preg_match("/(.*)Ethernet  HWaddr(.*)/", $line)){
						$mac = substr($line, -17);	
						break;
					}
				}
			}
			else
			{
				exec("ipconfig /all", $output);		
				
				foreach($output as $line){
					if (preg_match("/(.*)Physical Address(.*)/", $line)){
						$mac = substr($line, -17);						
						break;
					}
				}
			}
			
			return str_replace(':', '-', $mac);
		}
		
		/**
		* Remove Recursive Dir
		*
		* Function rmdir_recursive	
		* @param dir as string
		* @returns string
		* @author Susanta Das
		*/	
		public function RmdirRecursive($dir) {
			foreach(scandir($dir) as $file) {
				if ('.' === $file || '..' === $file) continue;
				if (is_dir("$dir/$file")) $this->RmdirRecursive("$dir/$file");
				else unlink("$dir/$file");
			}
			
			rmdir($dir);
		}
		
		/**
		* Remove Recursive Dir
		*
		* Function rmdir_recursive	
		* @param dir as string
		* @returns string
		* @author Susanta Das
		*/	
		public function DirRecursive($dir) {
			static $dir;
			
			foreach(scandir($dir) as $file) {
				if ('.' === $file || '..' === $file) continue;
				if (is_dir("$dir/$file")) $this->RmdirRecursive("$dir/$file");
				$dir[$dir] = $file;
			}
			
			return $dir;
		}
		
		/**
		* Function to Convert Amount in Words
		*
		* Function AmtInWords
		* @param $var_Amt as string
		* @returns string
		* @author Susanta Das
		*/		
		public function AmtInWords($var_Amt)
		{
			if($var_Amt < 0)
			{
				$var_Amt = abs($var_Amt);
				$refund = ' [Refunded]';
			}
				
			$power_name[1] = 'Arab'; 
			$power_value[1] = 1000000000000;
			$power_name[2] = 'Crore';  
			$power_value[2] = 100000000;
			$power_name[3] = 'Lakh';  
			$power_value[3]= 100000;
			$power_name[4] = 'Thousand'; 
			$power_value[4] = 1000;
			$power_name[5] = ''; 
			$power_value[5] = 1;

			for($i=1; $i<=5; $i++)
			{		
				if ($var_Amt >= $power_value[$i])
				{
					$digits = intval($var_Amt / $power_value[$i]);			
					
					if (strlen($result) > 0)
					{
						$result = $result . ', ';
					}
					
					$result = $result . $this->Words_1_999($digits) . ' ' . $power_name[$i];
					$var_Amt = intval($var_Amt - $digits * $power_value[$i]);			
				}
			}

			$result = ucwords(trim($result)).' Only.'.$refund;
			
			if ($result == ' Only.')
				return '';
			else
				return 'Rs. '.$result;		
		}

		/**
		* Function to Convert Amount in Words
		*
		* Function Words_1_999
		* @param $num as string
		* @returns string
		* @author Susanta Das
		*/	
		protected function Words_1_999($num)
		{
			$hundreds = intval($num / 100);
			$remainder = intval($num - $hundreds * 100);
			
			if ($hundreds > 0)
			{
				$result = $this->Words_1_19($hundreds).' hundred ';
			}
				
			if ($remainder > 0) 
			{
				$result = $result.$this->Words_1_99($remainder);
			}
			
			return trim($result);
		}

		/**
		* Function to Convert Amount in Words
		*
		* Function Words_1_99
		* @param $num as string
		* @returns string
		* @author Susanta Das
		*/	
		protected function Words_1_99($num)
		{
			$tens = intval($num / 10);
			
			if ($tens <= 1)
			{
				$result = $result.' '.$this->Words_1_19($num);
			}	
			else
			{        
				switch ($tens)
				{
					case 2:
						$result = 'twenty';
						break;
					case 3:
						$result = 'thirty';
						break;
					case 4:
						$result = 'forty';
						break;
					case 5:
						$result = 'fifty';
						break;
					case 6:
						$result = 'sixty';
						break;
					case 7:
						$result = 'seventy';
						break;
					case 8:
						$result = 'eighty';
						break;
					case 9:
						$result = 'ninety';
						break;
				}
				
				$result = $result . ' ' . $this->Words_1_19($num - $tens * 10);
			}

			return trim($result);
		}

		/**
		* Function to Convert Amount in Words
		*
		* Function Words_1_19
		* @param $num as string
		* @returns string
		* @author Susanta Das
		*/
		protected function Words_1_19($num) 
		{
		   switch ($num)
		   {
				case 1:
					return 'one';
					break;
				case 2:
					return 'two';
					break;
				case 3:
					return 'three';
					break;
				case 4:
					return 'four';
					break;
				case 5:
					return 'five';
					break;
				case 6:
					return 'six';
					break;
				case 7:
					return 'seven';
					break;
				case 8:
					return 'eight';
					break;
				case 9:
					return 'nine';
					break;
				case 10:
					return 'ten';
					break;
				case 11:
					return 'eleven';
					break;
				case 12:
					return 'twelve';
					break;
				case 13:
					return 'thirteen';
					break;
				case 14:
					return 'fourteen';
					break;
				case 15:
					return 'fifteen';
					break;
				case 16:
					return 'sixteen';
					break;
				case 17:
					return 'seventeen';
					break;
				case 18:
					return 'eightteen';
					break;
				case 19:
					return 'nineteen';
					break;
			}
		}
		
		/**
		* Function to Get Rounded Amount
		*
		* Function RoundedAmount
		* @param $value as string
		* @returns string
		* @author Susanta Das
		*/
		protected function RoundedAmount($value)
		{
			$decimal_value = ($value - intval($value)) * 100;
			$rounded_value = round($value) - $value;
			$tot_rounded_value = round($rounded_value, 2);	
			
			return $tot_rounded_value;
		}
        
        /**
		* Http Build Query Function
		*
		* Function http_build_query_curl
		* @author Susanta Das
		*/
		function http_build_query_curl($arrays, &$new=array(), $prefix=null)
		{
			if(is_object($arrays))
			$arrays = get_object_vars($arrays);
			
			foreach($arrays as $key=>$value)
			{
				$k = isset($prefix) ? $prefix.'['.$key.']' : $key;	
				
				if(is_array($value) || is_object($value))
					self::http_build_query_curl($value, $new, $k);
				else
					$new[$k] = $value;
			}
		}
		
		/**
		* simple method to encrypt or decrypt a plain text string
		* initialization vector(IV) has to be the same when encrypting and decrypting
		* PHP 5.4.9
		*
		* this is a beginners template for simple encryption decryption
		* before using this in production environments, please read about encryption
		*
		* @param string $action: can be 'encrypt' or 'decrypt'
		* @param string $string: string to encrypt or decrypt
		*
		* Usage
		*
		* $plain_txt = "This is my plain text";
		*
		* $encrypted_txt = encrypt_decrypt('encrypt', $plain_txt, 'my_secret_key');
		* echo "Encrypted Text = $encrypted_txt\n";
		*
		* $decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt, 'my_secret_key');
		* echo "Decrypted Text = $decrypted_txt\n";
		*
		* @return string
		*/
		function encrypt_decrypt($action, $string, $secret_key="\x73\x6f\x6d\x31\x34\x31\x30\x40\x73\x6f\x6d\x6e\x65\x74\x69\x63\x73") {
			$output = false;

			$encrypt_method = "AES-256-CBC";
			//$secret_iv = 'This is my secret iv';

			// hash
			$key = hash('sha256', $secret_key);
			
			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
			// $iv = substr(hash('sha256', $secret_iv), 0, 16);

			if( $action == 'encrypt' ) {
				$output = openssl_encrypt($string, $encrypt_method, $key, 0);
				$output = base64_encode($output);
			}
			else if( $action == 'decrypt' ){
				$string = base64_decode($string);
				$output = openssl_decrypt($string, $encrypt_method, $key, 0);
			}

			return $output;
		}
	}
?>

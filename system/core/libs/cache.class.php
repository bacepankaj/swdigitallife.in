<?
	/**
	* Simple Cache Class for APC Cache / Memcache
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Cache {
		// ----------------------- //
        // --- CLASS CONSTANTS --- //
        // ----------------------- //

		// memcache server 
		const SERVER = 'localhost';
		
		// memcache port 
		const PORT = 11211;	
		
		// tile to live		
		const TTL = 0;	
		
		/**
		* Innitaite Memcache Server
		*
		* Function inniMemcache
		* @param $server as string
		* @param $port as integer
		* @author Susanta Das
		*/
		protected function inniMemcache($server=self::SERVER, $port=self::PORT){
			// innitiate memcache class
			$cache = new Memcache();
			
			// add server
			$cache->connect($server, $port) or die("Could not connect to Memcache Server.");
			
			// return cache object
			return $cache;
		}
		
		/**
		* Set Cache to Memory
		*
		* Function setCache
		* @param $cachekey as string
		* @param $data as string
		* @author Susanta Das
		*/
		static function setCache($cachekey, $data, $ttl=self::TTL){
			//echo "Set Cache : ".strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey.'<br>';
			
			if(CACHE_ENGINE=='APC') // for APC Cache
				apc_store(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey, $data, $ttl);
			elseif(CACHE_ENGINE=='MEMCACHE') // for Memcache
				self::inniMemcache()->set(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey, $data, 0, $ttl);			
		}
		
		/**
		* Add a new variable to existing Cache Memory
		*
		* Function addCache
		* @param $cachekey as string
		* @param $data as string
		* @author Susanta Das
		*/
		static function addCache($cachekey, $data, $ttl=self::TTL){
			//echo "Add Cache : ".strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey.'<br>';
			
			if(CACHE_ENGINE=='APC') // for APC Cache
				apc_add(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey, $data, $ttl);
			elseif(CACHE_ENGINE=='MEMCACHE') // for Memcache
				self::inniMemcache()->append(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey, $data);
		}
		
		/**
		* Get Cache from Memory
		*
		* Function getCache
		* @param $cachekey as string
		* @param $bool_success as string
		* @return cached data
		* @author Susanta Das
		*/
		static function getCache($cachekey, &$bool_success=null){							
			//echo "Get Cache : ".strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey.'<br>';
			
			if(CACHE_ENGINE=='APC') // for APC Cache
				return apc_fetch(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey, $bool_success);					
			elseif(CACHE_ENGINE=='MEMCACHE') // for Memcache
			{
				// get state & data
				$bool_success = self::inniMemcache()->get(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey);

				// return data
				return $bool_success;
			}
		}
		
		/**
		* Clear Cached File and Render
		*
		* Function clearCache
		* @param $cachekey as string
		* @author Susanta Das
		*/
		static function clearCache($cachekey=null){							
			//echo "Delete Cache : ".strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey.'<br>';
			if(empty($cachekey))
			{
				if(CACHE_ENGINE=='APC') // for APC Cache
					apc_clear_cache('user');				
				elseif(CACHE_ENGINE=='MEMCACHE') // for Memcache
					self::inniMemcache()->flush();
			}
			else
			{
				if(CACHE_ENGINE=='APC') // for APC Cache
					apc_delete(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey);
				elseif(CACHE_ENGINE=='MEMCACHE') // for Memcache				
					self::inniMemcache()->delete(strtolower(str_replace(' ', '_', APP_NAME)).'_'.$cachekey);
			}
		}
	}	
?>
<?php
final class Cache { 
	private $expire = 3600; 

  	public function __construct() {
  		
  		if(!is_dir(DIR_CACHE.NOME_LOJA))
  		mkdir(DIR_CACHE.NOME_LOJA, 0777);
  		
		$files = glob(DIR_CACHE . NOME_LOJA . '/cache.*');
		
		if ($files) {
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);

      			if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);
					}
      			}
    		}
		}
  	}

	public function get($key) {
		$files = glob(DIR_CACHE . NOME_LOJA . '/cache.' . $key . '.*');
		
		if ($files) {
    		foreach ($files as $file) {
    			if (file_exists($file)) {    
      				$handle = @fopen($file, 'r');
      				$cache = @fread($handle, @filesize($file));
		  
      				@fclose($handle);

	      			return unserialize($cache);
				}
   		 	}
		}
  	}

  	public function set($key, $value) {
    	$this->delete($key);
		
		$file = DIR_CACHE . NOME_LOJA . '/cache.' . $key . '.' . (time() + $this->expire);
    	
		$handle = fopen($file, 'w');

    	fwrite($handle, serialize($value));
		
    	fclose($handle);
  	}
	
  	public function delete($key) {
		$files = glob(DIR_CACHE . NOME_LOJA . '/cache.' . $key . '.*');
		
		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file)) {
					unlink($file);
					clearstatcache();
				}
    		}
		}
  	}
}
?>

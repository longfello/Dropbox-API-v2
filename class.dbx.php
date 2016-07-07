<?

class dbxAPI {
      
	protected $token = Null;
	protected $method = Null;
	public $methods = array(
		
		'auth/token/revoke'=>'',
		'files/list_folder'=>'path',
		'files/delete'=>'path',
		'files/copy'=>'from_path,to_path',
		'files/copy_reference/get'=>'path',
		'files/copy_reference/save'=>'copy_reference,path',
		'files/create_folder'=>'path',
		'files/get_temporary_link'=>'path',
		'files/get_metadata'=>'path',
		'sharing/get_shared_links'=>''
	); 
      
    function __construct ($token=Null) {
          
        if ( $token ) $this->token = $token;
    }
    
    private function getData($data,$url) {
          
		// $data - array of input variables & flags
		// $url - final part of API url
		
		$headers = array('Authorization: Bearer '.$this->token, 'Content-Type: application/json');
		$apiUrl = 'https://api.dropboxapi.com/2/'.$url;
		$postData = json_encode((object)$data);

		$ch = curl_init($apiUrl);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	
    	$result = curl_exec($ch);
    	curl_close($ch);
    	
    	return json_decode($result);
    }
    
    public function __get($name) {
		
		$this->method .= $name.'/';
		return $this;
	}
	
	public function __call($function, $args) {
		
		$url = $this->method.$function;
		$this->method = Null;
		if (!isset($this->methods[$url])) return false;
		
		if (is_array($args[0])) $data = $args[0];
		else {
				$keys = explode(',',$this->methods[$url]);
				foreach ($args as $key=>$value) $data[ $keys[$key] ] = $value;
		}
		
		return $this->getData($data,$url);
	}
}
 
?>
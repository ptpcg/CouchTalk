<?php
	class CouchTalk{
		private $protocol;
		private $host;
		private $port;
		private $db;
		private $usr;
		private $pwd;
		private $talking = false;
		
		public function __construct($opt){
	        
	        foreach($opt as $key => $value) {
				$this->$key = $value;
			}
	    }
	    	    
	    private function talk($think){
	    	
	    	$mthd = $think[0];
	    	$db = $think[2];
	    	
	    	$ch = curl_init();
	    	
			// User
			curl_setopt($ch, CURLOPT_USERPWD, $this->usr.":".$this->pwd);
			
			// Host
			if($think[1] == "doc"){
				 if($think[3] != null){
					$doc = $think[3];
				 }else{
				 	$doc = "";
				 	$mthd = "POST";
				 }
		    	if(isset($think["say"])){
		    		$payload = json_encode($think["say"]);   
		    	}
				curl_setopt($ch, CURLOPT_URL, "http://".$this->host.":".$this->port."/$db/$doc");
			}else{
				curl_setopt($ch, CURLOPT_URL, "http://".$this->host.":".$this->port."/$db");
			}
			//Request Type
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $mthd);
			
			
			if(isset($think["say"])){
				//Send Payload
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			}
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set Data Type
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-type: application/json',
				'Accept: */*'
			));
			
			$couch_said = curl_exec($ch);
			curl_close($ch);	
			
			$couch = "http://".$this->host.":".$this->port."/";
			$req = "$mthd /$db/$doc"; 
			//Production
			
			return $couch_said;
	    }
	    
	    //DB Methods
	    public function mkDB($db_name){
	    	$words = array(
	    		"PUT",
	    		"db",
	    		$db_name
	    	);
	    	echo $this->talk($words);
	    }
	    public function lsDB($db_name,$view,$key){
	    	if(isset($view)){
	    		if(isset($key)){
	    			$_db = $db_name."/$view?key=".'"'.$key.'"';	
	    		}else{
	    			$_db = $db_name."/$view";
	    		}
	    	}else{
	    		$_db = $db_name."/_all_docs";
	    	}
	    	$words = array(
	    		"GET",
	    		"db",
	    		$_db
	    	);
	    	// echo $_db;
	    	return $this->talk($words);
	    }
	    
	    public function rmDB($db_name){
	    	$words = array(
	    		"DELETE",
	    		"db",
	    		$db_name
	    	);
	    	echo $this->talk($words);
	    }
	    public function lsDBs(){
	    	$words = array(
	    		"GET",
	    		"db",
	    		"_all_dbs"
	    	);
	    	echo $this->talk($words);
	    }
	    public function getCurDB(){
	    	return "<br />Couch: ".$couch."<br />DB: ".$db;
	    }
	    public function logCatDB($db_name,$docs){
	    	if(isset($docs) && $docs == true){
	    		$inc_docs = "?include_docs=true";
	    	}
	    	$words = array(
	    		"GET",
	    		"db",
	    		$db_name."/_changes".$inc_docs,
	    	);
	    	echo $this->talk($words);
	    }
	    public function setDB($new_db){
	    	$this->db = $new_db;
	    	return json_encode(array("db_set_to"=>$this->db));
	    }
	    
	    //Doc Methods
	    public function mkDoc($name,$data){
	    	$words = array(
	    		"PUT",
	    		"doc",
	    		$this->db,
	    		$name,
	    		"say"=>$data
	    	);
	    	return $this->talk($words);
	    }
	    public function getDoc($name){
	    	$words = array(
	    		"GET",
	    		"doc",
	    		$this->db,
	    		$name,
	    	);
	    	return $this->talk($words);
	    }
	    public function updateDoc($name,$rev,$fields,$data){
	    	$orgDoc = json_decode($this->getDoc($name));
	    	$revDoc = $orgDoc;
	    	if(is_array($fields)){
	    		foreach($fields as $f){
	    			$revDoc->$f = $data[$f]; 
	    		}
	    	}else{
	    		$revDoc->$fields = $data;
	    	}
	    	if(isset($rev)){
	    		$revDoc["_rev"] = $rev;
	    	}
	    	return $this->mkDoc($name,$revDoc);
	    }
	    public function rmDoc($name,$rev){
	    	if(!isset($rev)){
	    		$doc = json_decode($this->getDoc($name));
	    		$rev = $doc->_rev;
	    	}
	    	$words = array(
	    		"DELETE",
	    		"doc",
	    		$this->db,
	    		$name."?rev=$rev"
	    	);
	    	echo $this->talk($words);
	    }
	    //Replication Methods
	    	//in next version
	}

?>

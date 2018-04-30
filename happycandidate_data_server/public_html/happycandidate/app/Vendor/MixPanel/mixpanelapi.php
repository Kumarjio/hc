<?php
/*
 * PHP library for Mixpanel data API -- http://www.mixpanel.com/
 * Requires PHP 5.2 with JSON
 */

class Mixpanel
{
    private $api_url = 'http://mixpanel.com/api';
    private $version = '2.0';
    private $api_key;
    private $api_secret;
    
    public function __construct($api_key, $api_secret) {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }
    
    public function request($methods, $params, $format='json') {
        // $end_point is an API end point such as events, properties, funnels, etc.
        // $method is an API method such as general, unique, average, etc.
        // $params is an associative array of parameters.
        // See http://mixpanel.com/api/docs/guides/api/

        if (!isset($params['api_key']))
            $params['api_key'] = $this->api_key;
        
        $params['format'] = $format;
        
        if (!isset($params['expire'])) {
            //$current_utc_time = time() - date('Z');
			$current_utc_time = time();
            $params['expire'] = $current_utc_time + 600; // Default 10 minutes
        }
        
        $param_query = '';
        foreach ($params as $param => &$value) {
            if (is_array($value))
                $value = json_encode($value);
            $param_query .= '&' . urlencode($param) . '=' . urlencode($value);
        }
        
        $sig = $this->signature($params);
        
        
        
        $uri = '/' . $this->version . '/' . join('/', $methods) . '/';
        $request_url = $uri . '?sig=' . $sig . $param_query;
		
//		echo "__".$request_url;exit;
		
		
//		echo "hi";print_r($methods);exit;
//		echo "data.mixpanel.com".$this->api_url.$request_url;
//		exit;
        if($methods[0] == 'export'){
            $requestUrl = "https://data.mixpanel.com/api". $request_url;
        }else{
            $requestUrl = $this->api_url . $request_url;
        }
       
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $requestUrl);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($curl_handle);
        
        return json_decode($data);
    }
    
    private function signature($params) {
        ksort($params);
        $param_string ='';
        foreach ($params as $param => $value) {
            $param_string .= $param . '=' . $value;
        }
        
        return md5($param_string . $this->api_secret);
    }
}
    
// Example usage
//$api_key = 'fcc0f003c489660edb0330fd4b137e9c';
//$api_secret = '64d62995fded6f1f0841585b8dad842f';
 
 //$mp = new Mixpanel($api_key, $api_secret);
 /*$data = $mp->request(array('events', 'properties'), array(
     'event' => 'Portal User Logged In',
     'name' => 'Portal Name',
	 'values' => array('Monster'),
     'type' => 'general',
     'unit' => 'day',
     'interval' => '30'
     //'limit' => '20'
 ));*/
 
 /*$data = $mp->request(array('events'), array(
     'event' => array('Portal User Logged In',"Portal User Logged Out","Portal User Registered","Portal Visit","Portal User"),
     'type' => 'general',
     'unit' => 'day',
     'interval' => '30'
     //'limit' => '20'
 ));*/
 
 /*$data = $mp->request(array('events', 'names'), array(
     //'event' => 'pages',
     //'name' => 'page',
     'type' => 'general'
     //'unit' => 'day',
     //'interval' => '20',
     //'limit' => '20'
 ));*/
 
 //print("<pre>");
 //print_r($data);
//var_dump($data);
?>
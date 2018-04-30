<?php
App::uses('Component', 'Controller');
class MixPanelComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnGetTrends($arrEvent = array())
	{
		$arrPortalEvents = $arrEvent;
		App::import('Vendor', 'MixPanel/mixpanelapi');
		
		// Example usage
		$api_key = '621e436b4d937bfd4bbcc753f164b3bf';
		$api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

		$mp = new Mixpanel($api_key, $api_secret);
		$data = $mp->request(array('events'), array(
		 'event' => $arrPortalEvents,
		 'type' => 'general',
		 'unit' => 'day',
		 'interval' => '20'
		 //'limit' => '20'
		));
		
		return $data;
	}
	
	public function fnGetPortalTrends($arrEvent = array())
	{
		$arrPortalEvents = $arrEvent;
		App::import('Vendor', 'MixPanel/mixpanelapi');
		
		// Example usage
		$api_key = '621e436b4d937bfd4bbcc753f164b3bf';
		$api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

		$mp = new Mixpanel($api_key, $api_secret);
		$data = $mp->request(array('events'), array(
		 'event' => $arrPortalEvents,
		 'type' => 'general',
		 'unit' => 'day',
		 'interval' => '20'
		 //'limit' => '20'
		));
		
		return $data;
	}
	
	public function fnGetPropertiesFilteredData($strEvent = "",$arrPropertiesRequest = array())
	{
		$strPortalEvent = $strEvent;
		App::import('Vendor', 'MixPanel/mixpanelapi');
		
		// Example usage
		$api_key = '621e436b4d937bfd4bbcc753f164b3bf';
		$api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

		$mp = new Mixpanel($api_key, $api_secret);
		$data = $mp->request(array('events','properties'), array(
		'event' => $strPortalEvent,
		'name' => $arrPropertiesRequest['key'],
		'values' => $arrPropertiesRequest['keyvalue'],
		'type' => 'general',		
		'unit' => 'day',
		'interval' => '20'
		//'limit' => '20'
		));
		
		return $data;
	}
}
?>
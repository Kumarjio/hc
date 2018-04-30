<?php

App::uses('Component', 'Controller');

class MixPanelComponent extends Component {

    public $components = array('Session');

    public function startup(Controller $controller) {
        $this->Controller = $controller;
    }

    public function fnGetPropertyWiseData($arrEvents = "", $strFromDate = "", $strTodate = "", $strProperty = "") {
        $arrPortalEvents = $arrEvents;
        App::import('Vendor', 'MixPanel/mixpanelapi');

        // Example usage
        $api_key = '621e436b4d937bfd4bbcc753f164b3bf';
        $api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

        switch ($strProperty) {
            case "Browser" : $strProperty = "\$browser";
                break;
            case "Country" : $strProperty = "mp_country_code";
                break;
            case "OS" : $strProperty = "\$os";
                break;
            case "Region" : $strProperty = "\$region";
                break;
            case "City" : $strProperty = "\$city";
                break;
            case "Device" : $strProperty = "\$device";
                break;
        }

        $mp = new Mixpanel($api_key, $api_secret);
        $endpoint = array('segmentation');
        if ($strFromDate == "") {
            $strFromDate = date('Y-m-d', strtotime('19 days', strtotime(date('Y-m-d'))));
        }

        if ($strTodate == "") {
            $strTodate = date('Y-m-d');
        }


        $parameters = array(
            'event' => $arrPortalEvents[0],
            'from_date' => $strFromDate,
            'to_date' => $strTodate,
            'on' => 'properties["' . $strProperty . '"]',
        );
        $data = $mp->request($endpoint, $parameters);
        return $data;
    }

    public function fnSaleTotal($strFromDate = "", $strTodate = "") {

        

        $arrPortalEvents = $arrEvent;
        App::import('Vendor', 'MixPanel/mixpanelapi');

        // Example usage
        $api_key = '621e436b4d937bfd4bbcc753f164b3bf';
        $api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';
        $mp = new Mixpanel($api_key, $api_secret);
        if ($strFromDate && $strTodate) {
            $endpoint = array('segmentation');
            $parameters = array(
                'event' => "Monster Sale",
                'from_date' => $strFromDate,
                'to_date' => $strTodate,
//                'unit' => 'month',
//                'type'=> 'general',
                'on' => 'properties["Sale amount"]'
            );
        }
        $data = $mp->request($endpoint, $parameters);
        return $data;
    }

    public function fnGetTrends($arrEvent = array(), $strFromDate = "", $strTodate = "", $strPeriod = "") {
        $arrPortalEvents = $arrEvent;
        App::import('Vendor', 'MixPanel/mixpanelapi');

        // Example usage
        $api_key = '621e436b4d937bfd4bbcc753f164b3bf';
        $api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

        $mp = new Mixpanel($api_key, $api_secret);
        if ($strFromDate && $strTodate) {
            $endpoint = array('segmentation');
            if ($strPeriod == 'curr_year') {
                $parameters = array(
                    'event' => $arrEvent[0],
                    'from_date' => $strFromDate,
                    'to_date' => $strTodate,
                    'unit' => 'day',
                    'limit' => '1'
                );
            } else if ($strPeriod == '30') {
                $parameters = array(
                    'event' => $arrEvent[0],
                    'from_date' => $strFromDate,
                    'to_date' => $strTodate,
                    'unit' => 'month',
                );
            } else {
                $parameters = array(
                    'event' => $arrEvent[0],
                    'from_date' => $strFromDate,
                    'to_date' => $strTodate,
                );
            }

            $data = $mp->request($endpoint, $parameters);
        } else {
            $data = $mp->request(array('events'), array(
                'event' => $arrPortalEvents,
                'type' => 'general',
                'unit' => 'day',
                'interval' => '20'
                    //'limit' => '20'
            ));
        }

//		print('<pre>');
//		print_r($data);
//		exit;

        return $data;
    }

    public function fnGetPortalTrends($arrEvent = array()) {
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

    public function fnGetPropertiesFilteredData($strEvent = "", $arrPropertiesRequest = array()) {
        $strPortalEvent = $strEvent;
        App::import('Vendor', 'MixPanel/mixpanelapi');

        // Example usage
        $api_key = '621e436b4d937bfd4bbcc753f164b3bf';
        $api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

        $mp = new Mixpanel($api_key, $api_secret);
        $data = $mp->request(array('events', 'properties'), array(
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

    public function fnGetVisitorsTrends($arrEvent = array(), $strFromDate = "", $strTodate = "", $strPeriod = "") {
        $arrPortalEvents = $arrEvent;
        App::import('Vendor', 'MixPanel/mixpanelapi');

        // Example usage
        $api_key = '621e436b4d937bfd4bbcc753f164b3bf';
        $api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

        $mp = new Mixpanel($api_key, $api_secret);
        if ($strFromDate && $strTodate) {
            $endpoint = array('segmentation');
            if ($strPeriod == 'curr_year') {
                $parameters = array(
                    'event' => $arrEvent[0],
                    'from_date' => $strFromDate,
                    'to_date' => $strTodate,
                    'type' => 'unique',
                    'unit' => 'day',
                    'limit' => '1'
                );
            } else if ($strPeriod == '30') {
                $parameters = array(
                    'event' => $arrEvent[0],
                    'from_date' => $strFromDate,
                    'to_date' => $strTodate,
                    'type' => 'unique',
                    'unit' => 'month',
                );
            } else {
                $parameters = array(
                    'event' => $arrEvent[0],
                    'from_date' => $strFromDate,
                    'to_date' => $strTodate,
                    'type' => 'unique',
                );
            }

            $data = $mp->request($endpoint, $parameters);
        } else {
            $data = $mp->request(array('events'), array(
                'event' => $arrPortalEvents,
                'type' => 'unique',
                'unit' => 'day',
                'interval' => '20'
                    //'limit' => '20'
            ));
        }
        return $data;
    }

    public function fnGetVisitorsFilteredData($arrEvents = "", $strFromDate = "", $strTodate = "", $strProperty = "City", $strPeriod = "") {
        $arrPortalEvents = $arrEvents;
        App::import('Vendor', 'MixPanel/mixpanelapinew');

        // Example usage
        $api_key = '621e436b4d937bfd4bbcc753f164b3bf';
        $api_secret = '5ac88bd4ce84ba09af733ecc3c8ce1da';

        $mp = new Mixpanel($api_secret);
        $endpoint = array('export');
      
        if ($strPeriod == 'curr_year') {
            $parameters = array(
                'event' => ['"'.$arrPortalEvents[0].'"'],
                'from_date' => $strFromDate,
                'to_date' => $strTodate,
            );
        } else if ($strPeriod == '30') {
            $parameters = array(
                'event' => $arrPortalEvents[0],
                'from_date' => $strFromDate,
                'to_date' => $strTodate,
            );
        } else {
            $parameters = array(
                'event' => $arrPortalEvents[0],
                'from_date' => $strFromDate,
                'to_date' => $strTodate,
            );
        }
       
        $data = $mp->request($endpoint, $parameters);
        return $data;
    }

}

?>
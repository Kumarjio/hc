<?php

session_start();

require_once '../vendor/autoload.php';

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
    'clientId' => '5hp62j2b5wb8xntudcj4uzj3',
    'clientSecret' => 'P2TQtRf3cK',
    'redirectUri' => 'http://localhost/infusionsoft/samples/getForm.php',
));

// By default, the SDK uses the Guzzle HTTP library for requests. To use CURL,
// you can change the HTTP client by using following line:
// $infusionsoft->setHttpClient(new \Infusionsoft\Http\CurlClient());

// If the serialized token is available in the session storage, we tell the SDK
// to use that token for subsequent requests.
if (isset($_SESSION['token'])) {
    $infusionsoft->setToken(unserialize($_SESSION['token']));
}

// If we are returning from Infusionsoft we need to exchange the code for an
// access token.
if (isset($_GET['code']) and !$infusionsoft->getToken()) {
    $infusionsoft->requestAccessToken($_GET['code']);
}

function getForm($infusionsoft) {
    $contact = array('FirstName' => 'TESTJohn', 'LastName' => 'TESTDoe', 'Email' => 'testjohndoe@mailinator.com');
	//echo "HI";exit;
    return  $infusionsoft->webForms->getHTML("75");
    //return  $infusionsoft->webForms->getMap();
}

if ($infusionsoft->getToken()) {
    try {
        $strContactForm = getForm($infusionsoft);
    } catch (\Infusionsoft\TokenExpiredException $e) {
        // If the request fails due to an expired access token, we can refresh
        // the token and then do the request again.
        $infusionsoft->refreshAccessToken();

        $strContactForm = getForm($infusionsoft);
    }

    //$contact = $infusionsoft->contacts->load($cid, array('Id', 'FirstName', 'LastName', 'Email'));

   // print("<pre>");
	//print_r($strContactForm);
	
	//echo "--".$strContactForm;
	//var_dump($contact);

    // Save the serialized token to the current session for subsequent requests
    $_SESSION['token'] = serialize($infusionsoft->getToken());
} else {
    echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}

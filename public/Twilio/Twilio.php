<?php
/*
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
//require_once '/path/to/vendor/autoload.php';

use Twilio\Rest\Client;

// Find your Account Sid and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = "AC3069ffe566b2673d7c6b030eeb44e5d4";
$token ="4e08167a5c2b94fb4381a69cacb88668";
$twilio = new Client($sid, $token);

$new_key = $twilio->newKeys
                  ->create();
				  
print($new_key->sid);exit;*/
?>

<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once '/path/to/vendor/autoload.php';

use Twilio\Rest\Client;

// Find your Account Sid and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = "AC3069ffe566b2673d7c6b030eeb44e5d4";
$token ="4e08167a5c2b94fb4381a69cacb88668";
$twilio = new Client($sid, $token);

$new_key = $twilio->newKeys
                  ->create();

print($new_key->sid);

exit;

?>
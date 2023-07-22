## Banks list
This a tutorial on how to get a list of financial institutions in Nigeria
```PHP
use Flutterwave\Banks;
use Flutterwave\Flutterwave;

//merchantKey and apiKey can be found in your flutter developer console
//env can be production or staging depending on your stage of development
//you must always remember to set client credentials before any operation
$merchantKey = ""; //can be found on flutterwave dev portal
$apiKey = ""; //can be found on flutterwave dev portal
$env = "staging"; //this can be production when ready for deployment
Flutterwave::setMerchantCredentials($merchantKey, $apiKey, $env, $version); //version is optional and can be 1 or 2, when not passed, it defaults to 1

$result = Banks::allBanks();
//$result is an instance of ApiResponse class which has
//methods like getResponseData(), getStatusCode(), getResponseCode(), isSuccessfulResponse()
```

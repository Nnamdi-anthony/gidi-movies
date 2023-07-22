<?php
namespace Flutterwave;

/**
* Can be used to get details of a valid ip address
*/
class Ip {

  //@var array respresents both staging and production server url
  private static $url = [
    "v1" => [
      "staging" => "http://staging1flutterwave.co:8080/pwc/rest/fw/ipcheck/",
      "production" => "https://prod1flutterwave.co:8181/pwc/rest/fw/ipcheck/"
    ],
    "v2" => [
      "staging" => "https://flutterwavestagingv2.com/pwc/rest/fw/ipcheck/",
      "production" => "https://flutterwaveprodv2.com/pwc/rest/fw/ipcheck/"
    ]
  ];

  /**
  * @param string ip
  * @return ApiResponse
  */
  public static function check($ip) {
    $resource = self::$url[Flutterwave::getVersionName()][Flutterwave::getEnv()];
    return (new ApiRequest($resource))
            ->addBody("ip", $ip)
            ->makePostRequest();
  }
  
}

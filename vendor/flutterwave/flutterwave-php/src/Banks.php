<?php
namespace Flutterwave;

/**
 * can get list of all banks
 */
class Banks {

  /**
   * urls to both staging and production server for banks
   * @var array
   */
  private static $resources = [
    "v1" => [
      "staging" => "http://staging1flutterwave.co:8080/pwc/rest/fw/banks/",
      "production" => "https://prod1flutterwave.co:8181/pwc/rest/fw/banks/"
    ],
    "v2" => [
      "staging" => "https://flutterwavestagingv2.com/pwc/rest/fw/banks/",
      "production" => "https://flutterwaveprodv2.com/pwc/rest/fw/banks/"
    ]
  ];

  /**
   *
   * @return [type] [description]
   */
  public static function allBanks() {
    $resouce = self::$resources[Flutterwave::getVersionName()][Flutterwave::getEnv()];
    $resp = (new ApiRequest($resouce))
              ->makePostRequest();
    return $resp;
  }
}

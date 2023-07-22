<?php
namespace Flutterwave;

/**
* A base class for setting commonly needed values for
* flutterwave api integration
*
* Class Flutterwave
*
* @package Flutterwave
*/
class Flutterwave {

  const VOICE = "voice";
  const SMS = "sms";

  //@var string The merchant key to be used for requests
  private static $merchantKey;

  //@var string The api key to be used for encryption
  private static $apiKey;

  //@var string represents the development environment as either staging or production
  private static $env = "staging";

  //@var string represents the version to be used as either 1 or 2
  private static $version = "1";

  /**
  * construct the Flutterwave client
  * @param string $merchantKey
  * @param string $apiKey
  */
  public static function setMerchantCredentials($merchantKey, $apiKey, $env = "staging", $version = "1") {
    if (empty($merchantKey)) {
      throw new \InvalidArgumentException("Merchant key can not be empty");
    }

    if (empty($apiKey)) {
      throw new \InvalidArgumentException("Api key can not be empty");
    }

    if (empty($env) || ($env !== "staging" && $env !== "production")) {
      throw new \InvalidArgumentException("env variable can only be `staging` or `production`");
    }

    if (empty($version) || ($version !== "1" && $version !== "2")) {
      throw new \InvalidArgumentException("version variable can only be `1` or `2`");
    }

    self::$merchantKey = $merchantKey;
    self::$apiKey = $apiKey;
    self::$env = $env;
    self::$version = $version;
  }

  /**
  * get the merchant key
  * @return string $merchantKey
  */
  public static function getMerchantKey() {
    return self::$merchantKey;
  }

  /**
  * get the api key
  * @return string $apiKey
  */
  public static function getApiKey() {
    return self::$apiKey;
  }

  /**
  * get env name. It can either be staging or production
  * @return string $env
  */
  public static function getEnv() {
    return self::$env;
  }

  /**
  * get version name. It can either be 1 or 2
  * @return string $version
  */
  public static function getVersion() {
    return self::$version;
  }

  /**
  * get version name with 'v' prefix.
  * @return string $version
  */
  public static function getVersionName() {
    return 'v' . self::$version;
  }
}

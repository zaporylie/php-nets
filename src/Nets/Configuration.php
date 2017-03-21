<?php

namespace zaporylie\Nets;

class Configuration {
  public static $global;

  private $_environment;
  private $_merchantId;
  private $_token;

  public function __construct($attribs = [])
  {
    foreach ($attribs as $kind => $value) {
      if ($kind == 'environment') {
        $this->_environment = $value;
      }
      if ($kind == 'merchantId') {
        $this->_merchantId = $value;
      }
      if ($kind == 'token') {
        $this->_token = $value;
      }
    }
    if (empty($this->_environment)) {
      throw new \InvalidArgumentException('You must set at least value for environment');
    }
  }

  /**
   * resets configuration to default
   * @access public
   */
  public static function reset()
  {
    self::$global = new Configuration();
  }

  public static function environment()
  {
    return self::$global->getEnvironment();
  }

  public function getEnvironment() {
    return $this->_environment;
  }

  public static function merchantId($value = null)
  {
    if (empty($value)) {
      return self::$global->getMerchantId();
    }
    self::$global->setMerchantId($value);
  }

  public function getMerchantId()
  {
    return $this->_merchantId;
  }

  public function setMerchantId($value)
  {
    return $this->_merchantId = $value;
  }

  public static function token($value = null)
  {
    if (empty($value)) {
      return self::$global->getToken();
    }
    self::$global->setToken($value);
  }

  public function getToken()
  {
    return $this->_token;
  }

  public function setToken($value)
  {
    return $this->_token;
  }

  public function baseUrl()
  {
    return sprintf('%s://%s:%d', $this->protocol(), $this->serverName(), $this->portNumber());
  }

  public function basePath()
  {
    return '/';
  }

  /**
   * @return string
   * @todo: Allow http?
   */
  public function protocol() {
    return 'https';
  }

  public function serverName() {
    switch ($this->getEnvironment()) {
      case 'production':
        return 'payment.nets.eu';
      case 'sandbox':
        return 'test.epayment.nets.eu';
    }
    throw new \InvalidArgumentException('Invalid environment');
  }

  public function portNumber() {
    return 80;
  }
}
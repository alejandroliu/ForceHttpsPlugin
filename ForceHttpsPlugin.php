<?php

/**
 * force https plugin - a plugin to make sure that https is used
 *
 * Checks the URL and make sure that we are using https
 *
 * @author  Alejandro Liu Ly
 * @link    https://www.linkedin.com/in/alejandro-liu-ly/
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0.0
 */

final class ForceHttpsPlugin extends AbstractPicoPlugin
{
    /**
     * This plugin is enabled by default?
     *
     * @see AbstractPicoPlugin::$enabled
     * @var boolean
     */
    protected $enabled = true;

    /**
     * This plugin depends on ...
     *
     * @see AbstractPicoPlugin::$dependsOn
     * @var string[]
     */
    protected $dependsOn = array();


    /**
     * Triggered after Pico has evaluated the request URL
     *
     * @see    Pico::getRequestUrl()
     * @param  string &$url part of the URL describing the requested contents
     * @return void
     */
    public function onRequestUrl(&$url)
    {
      if ($this->is_ssl()) return;
      $new_uri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      header('Location: '.$new_uri);
      echo 'Redirecting to <a href="'.$new_uri.'">'.$new_uri.'</a>';
      exit;
    }
    private function is_ssl() {
      if (isset($_SERVER['HTTPS'])) {
	if ('on' == strtolower($_SERVER['HTTPS'])  || '1' == $_SERVER['HTTPS'] ) return true;
      }
      if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') return true;
      if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') return true;
      if (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') return true;
      return false;
    }
}

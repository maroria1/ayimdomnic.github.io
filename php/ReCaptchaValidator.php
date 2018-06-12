<?php
/**
 * Created by PhpStorm.
 * User: ayim
 * Date: 12/06/2018
 * Time: 15:23
 */

namespace FormGuide\Handlx;


class ReCaptchaValidator
{
    private $enabled;
    private $secret;
    /**
     * ReCaptchaValidator constructor.
     */
    public function __construct()
    {
        $this->enabled=false;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function enable($enable)
    {
        $this->enabled = $enable;
    }

    public function initSecretKey($key)
    {
        $this->secret = $key;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if(empty($_POST['g-recaptcha-response']))
        {
            return false;
        }

        $captcha=$_POST['g-recaptcha-response'];

        $url =
            'https://www.google.com/recaptcha/api/siteverify?secret='.$this->secret.'&response='.$captcha.'&remoteip='.$_SERVER['REMOTE_ADDR'];

        $resp_raw = file_get_contents($url);

        $response=json_decode($resp_raw, true);

        if(!empty($response['success']) && $response['success'])
        {
            return true;
        }
        return false;
    }
}
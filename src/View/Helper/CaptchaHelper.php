<?php
namespace Recaptcha\View\Helper;

use Cake\View\Helper;
use Captcha\Captcha;

/**
 * A helper for displaying reCAPTCHA request to the user.
 * Works in combination with the CaptchaComponent.
 *
 * Note:
 * Your reCAPTCHA public key must be set in the configuration when adding the helper.
 *
 * @author Jason Burgess <jason@notplugged.in>
 * @version 3.0
 * @see http://www.google.com/recaptcha/intro/index.html
 * @see \Recaptcha\Controller\Component\CaptchaComponent
 */
class CaptchaHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    public $_defaultConfig = [
        'public_key' => false
    ];

    /**
     * Show the reCAPTCHA form on the page.
     *
     * @param string[] $options
     *            JavasScript options for the reCAPTCHA form.
     * @return string HTML for display
     * @see https://developers.google.com/recaptcha/docs/customization
     */
    public function show($options = array())
    {
        $options = array_merge($this->config(), $options);

        $captcha = new Captcha();

        // Just in case the public key is set at the last minute.
        $captcha->setPublicKey($options['public_key']);

        unset($options['public_key']);

        if (! empty($options)) {
            $code = '<script type="text/javascript">var RecaptchaOptions = ' . json_encode($options) . ';</script>';
        } else {
            $code = '';
        }

        $code .= $captcha->html();

        return $code;
    }
}
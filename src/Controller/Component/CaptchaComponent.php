<?php
namespace Recaptcha\Controller\Component;

use Cake\Controller\Component;
use Captcha\Captcha;

/**
 * A component for validating reCAPTCHA requests.
 * Works in combination with the CaptchaHelper.
 *
 * Note:
 * Your reCAPTCHA private key must be set in the configuration when adding the component.
 *
 * @author Jason Burgess <jason@notplugged.in>
 * @version 3.0
 * @see http://www.google.com/recaptcha/intro/index.html
 * @see \Recaptcha\View\Helper\CaptchaHelper
 */
class CaptchaComponent extends Component
{

    /**
     * Default configuration options.
     *
     * @var array
     */
    public $_defaultConfig = [
        'private_key' => false
    ];

    /**
     * Error message from last validate() call, if any.
     *
     * @var string
     * @see \Recaptcha\Controller\Component\CaptchaComponent::validate()
     */
    public $error = false;

    /**
     * Validate the Recaptcha request.
     *
     * Any error messages will be set on Recaptcha\Controller\Component\CaptchaComponent::$error.
     *
     * @return boolean Success
     */
    public function validate()
    {
        // New captcha instance
        $captcha = new Captcha\Captcha();
        $captcha->setPrivateKey($this->config('private_key'));

        $response = $captcha->check();
        $this->error = $response->getError();

        return $response->isValid();
    }
}
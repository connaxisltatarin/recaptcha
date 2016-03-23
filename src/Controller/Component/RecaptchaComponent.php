<?php
namespace Recaptcha\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Captcha\Captcha;
use Captcha\Exception;

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
 * @see \Recaptcha\View\Helper\RecaptchaHelper
 */
class RecaptchaComponent extends Component
{

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
        $captcha = new Captcha();
        $captcha->setPrivateKey($this->_getPrivateKey());

        $response = $captcha->check();
        $this->error = $response->getError();

        return $response->isValid();
    }
	
	private function _getPrivateKey(){
		$publicKey = Configure::read('Recaptcha.privateKey');
		if (!$publicKey) {
            throw new Exception('Please add Configure::write(\'Recaptcha.privateKey\', \'PRIVATE_KEY\') to your bootstrap.php');
        }

		return $publicKey;
	}	
}
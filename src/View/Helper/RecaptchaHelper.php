<?php
namespace Recaptcha\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Captcha\Captcha;
use Captcha\Exception;

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
 * @see \Recaptcha\Controller\Component\RecaptchaComponent
 */
class RecaptchaHelper extends Helper
{
	private $_fields = array();
	private $_initiated = false;
	
	public function init($fields){
		if(!is_array($fields)){
			$fields = [$fields];
		}
        
        foreach ($fields as $field => $options) {
            if (is_array($options)) {
                $this->_fields[$field] = $options;
            }
            else {
                $this->_fields[$options] = null;
            }
        }
        
		$fields = $this->_fields;
		
		$html = '<script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>';
		$html .= '<script type="text/javascript">';
		
		foreach($fields as $field => $options){
			$html .= 'var recaptcha'.$field.';';
		}
		
		$html .= 'var CaptchaCallback = function(){';
		
		foreach($fields as $field => $options){
            $text = '';
            if ($options) {
                foreach($options as $k => $v) {
                    $text = ",\"$k\" : \"$v\"";
                }
            }
			$html .= 'recaptcha'.$field.' = grecaptcha.render("'.$field.'", {"sitekey" : "'.$this->_getPublicKey().'" '.$text.'});';
		}
				
		$html .= '};';
		$html .= '</script>';
		
		$this->_initiated = true;
		
		return $html;
	}

    /**
     * Show the reCAPTCHA form on the page.
     *
     * @param string[] $options
     *            JavasScript options for the reCAPTCHA form.
     * @return string HTML for display
     * @see https://developers.google.com/recaptcha/docs/customization
     */
    public function showSimple($options = array())
    {
		if($this->_initiated){
			throw new Exception('Dont execute init() if using showSimple()');
		}
		
        $captcha = new Captcha();

        $captcha->setPublicKey($this->_getPublicKey());

        if (! empty($options)) {
            $code = '<script type="text/javascript">var RecaptchaOptions = ' . json_encode($options) . ';</script>';
        } else {
            $code = '';
        }

        $code .= $captcha->html();

        return $code;
    }
	
	public function showMultiple($field){
		if(!key_exists($field, $this->_fields)){
			throw new Exception('Please add \''.$field.'\' param to init(), example: $this->Recaptcha->init([\''.$field.'\'])');
		}
		
		return '<div class="recaptchaWidget" id="'.$field.'"></div>';
	}
	
	private function _getPublicKey(){
		$publicKey = Configure::read('Recaptcha.publicKey');
		if (!$publicKey) {
            throw new Exception('Please add Configure::write(\'Recaptcha.publicKey\', \'PUBLIC_KEY\') to your bootstrap.php');
        }

		return $publicKey;
	}
}
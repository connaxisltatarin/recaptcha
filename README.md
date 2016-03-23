reCAPTCHA Plugin for CakePHP 3.x
Version 3.0

# General Information

Allows for easy use of recatpcha api from Google.

# Release Information

## Version 3.0

- Updated to work with CakePHP 3.0
- Switched to use recaptcha-php-5 library instead of the function based library.

## Version 2.1

- Updated to work with CakePHP 2.5

## Setup

To include the Recaptcha plugin in your project, add the following code to your *app/Config/bootstrap.php* file: 

``` php
CakePlugin::load('Recaptcha');
```

In your Controller:
``` php
	public $helpers = array(
		'Form',
		'Recaptcha.Recaptcha'
	);
	public $components = array(
		'Recaptcha.Recaptcha'
	);
```

## Usage

To display the reCapthca widget on your form in your View:
``` php
$this->Captcha->showSimple(array $optional_settings);
```
Multiple recaptcha on a same page
$this->Captcha->init(['field1', 'field2']);
$this->Captcha->showMultiple('field1');
$this->Captcha->showMultiple('field2');

Then to verify the reCAPTCHA in your Controller:
``` php
if (!$this->Captcha->validate()) {
	// Add whatever code you need to use to show an error.
}
```

### Customization Settings

For a full description of the customization options, please visit the [reCAPTCHA customization page](https://developers.google.com/recaptcha/docs/customization).
Below are the three most common settings.  These can be set in the helper settings directly, or passed as an array when calling CaptchaHelper::show().

- **theme**
-- *red* - The default theme.
-- *white*
-- *blackglass*
-- *clean*
-- *custom* [See the documentation.](https://developers.google.com/recaptcha/docs/customization)
- **lang**
-- *en* - English (the default)
-- *nl* - Dutch
-- *fr* - French
-- *de* - German
-- *pt* - Portuguese
-- *ru* - Russian
-- *es* - Spanish
-- *tr* - Turkish
- **tabindex** - Sets a tabindex for the reCAPTCHA text box. If other elements in the form use a tabindex, this should be set so that navigation is easier for the user.  The default is 0.

## License
This plugin is released under the BSD License.  You can find a copy of this licenese in [LICENSE.md](LICENSE.md).
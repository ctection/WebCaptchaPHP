# WebCaptchaPHP
PHP Wrapper for the WebCaptcha API

## Usage
### Implementing a Captcha Frame Client
Must be called inline within a form element.
```php
$cc = new CaptchaClient();
echo $cc->initialize();
```
### Checking Captcha Entry Validity
Assuming there is only one captcha and the forms arguments point towards the script using a POST request:
```php
$ver = new CaptchaVerifier();
	if($ver->check($_POST["ctec_captcha_vc_0"],$_POST["ctec_captcha_txt_0"])){
		echo "good";
	}else{
		echo "bad";
	}
```
or (compatible with multiple CAPTCHA frames):
```php
$ver = new CaptchaVerifier();
$ver->parseFromPostBody($_POST);
$firstCaptchaState = $ver->captchas[0];
if($firstCaptchaState->solved){
  echo "good";
}else{
	echo "bad";
}
```

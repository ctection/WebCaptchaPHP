<?PHP
class CaptchaClient {

    function initialize(){
		return '<div class="ctec_captcha"></div><script src="https://ctection.com/cdn/captcha.js"></script>';
	}
	
}

class CaptchaState{
	
	var $code;
	var $solved;
	
	function __construct($c, $s){
		$this->code = $c;
		$this->solved = $s;
	}
	
}

class CaptchaVerifier {

    var $captchas;
	
	function __construct(){
		$captchas = array();
	}
	
	function parseFromPostBody($postbody){
		for($i=0;isset($postbody["ctec_captcha_vc_".$i]);$i++){
			$api_ret = json_decode(file_get_contents("https://ctection.com/api/v1/check_captcha.php?c=".urlencode($_POST["ctec_captcha_txt_".$i])."&uid=".urlencode($_POST["ctec_captcha_vc_".$i])),true);
			if(isset($api_ret["valid"])){
				if($api_ret["valid"]){
					array_push($this->captchas, new CaptchaState($postbody["ctec_captcha_vc_".$i],true));
				}else{
					array_push($this->captchas, new CaptchaState($postbody["ctec_captcha_vc_".$i],false));
				}
			}
		}
	}
	
	function check($id,$text){
		$api_ret = json_decode(file_get_contents("https://ctection.com/api/v1/check_captcha.php?c=".urlencode($text)."&uid=".urlencode($id)),true);
		if(isset($api_ret["valid"])){
			if($api_ret["valid"]){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
}


?>

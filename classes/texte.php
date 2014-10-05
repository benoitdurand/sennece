<?php 

/**
* texte
*/
class Texte{
	
	public static function limit($texte,$nbr){
		return (strlen($texte) > $nbr ? substr(substr($texte,0,$nbr),0,strrpos(substr($texte,0,$nbr)," "))." ..." :$texte);
	}

	public static function french_date($d){
		$mois =array('Jan','Fev','Mars','Avr','Mai','Juin','Juil','Aout','Sep','Oct','Nov','Dec');
		$blocs = explode(' ',$d);
		$date = explode ('-',$blocs[0]);
		$french =$date[2].' '.$mois[$date[1]-1].' '.$date[0];
		return $french;
	}

	public static function french_date_time($d){
		$mois =array('Jan','Fev','Mars','Avr','Mai','Juin','Juil','Aout','Sep','Oct','Nov','Dec');
		$blocs = explode(' ',$d);
		$date = explode ('-',$blocs[0]);
		$time= explode(':',$blocs[1]);
		$french =$date[2].' '.$mois[$date[1]-1].' '.$date[0].' à '.$time[0].':'.$time[1];
		return $french;
	}

	public static function short_french_date_time($d){
		$blocs = explode(' ',$d);
		$date = explode ('-',$blocs[0]);
		$time= explode(':',$blocs[1]);
		$french =$date[2].'/'.$date[1].'/'.$date[0].' à '.$time[0].':'.$time[1];
		return $french;
	}

	public static function extract_time($d){
		$blocs = explode(' ',$d);
		return $blocs[1];
	}

	public static function generer($nbr){
		$string ='';
		$chaine ="abcdefghijklmnopqrstuvwxyz0123456789@!-/*()ABCEFGHIJKLMNOPQRSTUVWXYZ";
		//srand((double)microtime()*1000000);
		for($i=0; $i<$nbr; $i++){
			$string .=$chaine[rand()%strlen($chaine)];
		}
		return $string;
	}

	public static function cleantext($txt){
		return htmlspecialchars(trim($txt),ENT_QUOTES,'UTF-8',false);

	}

	public static function isNotEmptyStr($str) {
		return !empty($str) ? 1 : 0;
	}

	public static function minLength($str, $length) {
		return strlen($str) < $length ? 1 : 0;
	}	

	public static function maxLength($str, $length) {
		return strlen($str) > $length ? 1 : 0;
	}

	public static function minValue($str, $min) {
		return ($str > (int) $min) ? 1 : 0;
	}

	public static function maxValue($str, $max) {
		return ($str < (int) $max) ? 1 : 0;
	}

	public static function validate_date ($dateToValidate) {
		$tabDate  = explode('/', $dateToValidate);
		if (count($tabDate) == 3) {
		        return checkdate($tabDate[1], $tabDate[0], $tabDate[2]);
		} else {
    		return false;
    	}
	}


	public static function paginateTable ($nbrPage, $currentPage, $pageName){
		if ($nbrPage > 1) {
					for($i=1;$i<=$nbrPage;$i++){
						if($i == $currentPage){
							echo "<li  class='active'><a href=''>$i</a></li>";
						}else{
							echo "<li><a href=$pageName&page=$i>$i</a></li>";
						}
					}
				}
	}

	public static function calculatePage ($nb, $maxPerPage) {
		$nbr_pages = ceil($nb/$maxPerPage);
		return $nbr_pages;
	}

	public static function validatePage($value, $maxValue) {
		if (is_numeric($value) && ($value <= $maxValue) && ($value > 0)) {
			return $value;
		}
		else {
			return 1;
		}

	}

	public static function upperAfterPoint($str){
		$phrases = explode(".", $str);
		$strTmp = "";
		foreach ($phrases as $phrase) {
			if (trim($phrase) != "" ){
				$strTmp .= " ".ucfirst(trim(mb_strtolower($phrase))).".";
			}
		}
	return trim($strTmp);
	}

	public static function left($str, $length) {
     return substr($str, 0, $length);
	}

	public static function right($str, $length) {
     return substr($str, -$length);
	}


}

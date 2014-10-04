<?php 
/**
* User
*/
class User{

	// vérifier si l'user est logger
	public static function islog($db){

		if(isset($_SESSION['user']) && isset($_SESSION['user']['email']) && isset($_SESSION['user']['password']) && isset($_SESSION['token'])){
			$data =array(
				'email'		=>$_SESSION['user']['email'],
				'password'	=>$_SESSION['user']['password']
				);
			$sql = 'SELECT * FROM users WHERE email=:email AND password=:password limit 1' ;
    		$req = $db->tquery($sql,$data);

    		if(!empty($req)){
    			if(User::hashPassword($_SESSION['token_uncrypted']) == $_SESSION['token']){
    				$_SESSION['authentificated'] = true;
    				return true;
    			}    			
    		}    		
		}
		$_SESSION['authentificated'] = false;
		return false;
	}

	public static function hashPassword($pass){
		return sha1(SALT.md5($pass.SALT).sha1(SALT).md5($pass.SALT));
	}


	public static function auth(){
		if(isset($_SESSION['token']) && (User::hashPassword($_SESSION['token_uncrypted']) == $_SESSION['token']) ){
			$_SESSION['authentificated'] = true;
			return true;
		}else{
			$_SESSION['authentificated'] = false;
			return false;
		}
	}

	public static function isadmin($db){
		if(isset($_SESSION['user']['role']) && User::hashPassword('admin') == $_SESSION['user']['role'] && User::islog($db)){
			return true;
		}
		return false;
	}

	public static function isResponsable($db, $id) {
		$sql = "SELECT id, id_service FROM operateurs WHERE id_service=".$_SESSION['user']['id_service']." AND id={$id}";
		$req = $db->tquery($sql);
		return !empty($req);
	}
}
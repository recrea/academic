<?php
class UserModelHelper extends AppHelper {
	function full_name($user){
		return $user['User']['first_name'].($user['User']['last_name'] != '' ? ' '.$user['User']['last_name'] : '');
	}
	
	function full_name_surname_first($user){
		return ($user['User']['last_name'] != '' ? $user['User']['last_name'].', ' : '').$user['User']['first_name'];
	}
}
?>
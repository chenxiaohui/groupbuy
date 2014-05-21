<?php

class ZUser
{
	const SECRET_KEY = '@4!@#$%@';
	
	/**生成密码
	 * @param unknown_type $p
	 */
	static public function GenPassword($p) {
		return md5($p . self::SECRET_KEY);
	}

	static public function Create($user_row, $uc=true) {//注册,传入需要的参数
		if (function_exists('zuitu_uc_register') && $uc) {
			$pp = $user_row['password'];
			$em = $user_row['email'];
			$un = $user_row['username'];
			$ret = zuitu_uc_register($em, $un, $pp);
			if (!$ret) return false;
		}

		$user_row['password'] = self::GenPassword($user_row['password']);
		$user_row['create_time'] = $user_row['login_time'] = time();
		$user_row['ip'] = Utility::GetRemoteIp();
		$user_row['secret'] = md5(rand(1000000,9999999).time().$user_row['email']);
		$user_row['id'] = DB::Insert('user', $user_row);
		$_rid = abs(intval(cookieget('_rid')));
		if ($_rid && $user_row['id']) {//邀请id，注册用户id
			$r_user = Table::Fetch('user', $_rid);
			if ( $r_user ) {
				ZInvite::Create($r_user, $user_row);
				ZCredit::Invite($r_user['id']);//看看是不是邀请注册
			}
		}
		if ( $user_row['id'] == 1 ) {//id为1的是管理员
			Table::UpdateCache('user', $user_row['id'], array(
						'manager'=>'Y',
						'secret' => '',
						));
		}
		return $user_row['id'];
	}

	static public function GetUser($user_id) {
		if (!$user_id) return array();
		return DB::GetTableRow('user', array('id' => $user_id));
	}

	/** 从cookie获取用户信息
	 * @param unknown_type $cname
	 */
	static public function GetLoginCookie($cname='ru') {
		$cv = cookieget($cname);//从cookie里获取
		if ($cv) {
			$zone = base64_decode($cv);
			$p = explode('@', $zone, 2);
			return DB::GetTableRow('user', array(
				'id' => $p[0],
				'password' => $p[1],
			));
		}
		return Array();
	}
	//修改用户信息
	static public function Modify($user_id, $newuser=array()) {
		if (!$user_id) return;
		/* uc */
		$curuser = Table::Fetch('user', $user_id);
		if ($newuser['password'] && function_exists('zuitu_uc_updatepw') ) {
			$em = $curuser['email'];
			$un = $newuser['username'];
			$pp = $newuser['password'];
			if ( ! zuitu_uc_updatepw($em, $un, $pp)) {
				return false;
			}
		}

		
		$table = new Table('user', $newuser);
		$table->SetPk('id', $user_id);
		if ($table->password) {
			$plainpass = $table->password;
			$table->password = self::GenPassword($table->password);
		}
		return $table->Update( array_keys($newuser) );
	}

	/** 登陆函数
	 * @param unknown_type $email
	 * @param unknown_type $unpass
	 * @param unknown_type $en
	 */
	static public function GetLogin($email, $unpass, $en=true) {
		if($en) $password = self::GenPassword($unpass);//生成密码
		$field = strpos($email, '@') ? 'email' : 'username';//用户名还是email
		$zuituuser = DB::GetTableRow('user', array(
					$field => $email,
					'password' => $password,
		));
		if ($zuituuser)  return $zuituuser;//查到用户
		if (function_exists('zuitu_uc_login')) {//UC登陆
			return zuitu_uc_login($email, $unpass);
		}
		return array();
	}

	static public function SynLogin($email, $unpass) {
		if (function_exists('zuitu_uc_synlogin')) {
			return zuitu_uc_synlogin($email, $unpass);
		}
		return true;
	}

	static public function SynLogout() {
		if (function_exists('zuitu_uc_synlogout')) {
			return zuitu_uc_synlogout();
		}
		return true;
	}
}

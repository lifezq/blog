<?php
/**
 * 用户管理
 * @copyright (c) Emlog All Rights Reserved
 */

class User_Model {

	private $db;

	function __construct() {
        $this->db = Database::getInstance();
	}
        function qqLogin($username,$photo,$is_sina=0){
            /*
            $name_pre='qq-';
              if($is_sina)  $name_pre='sina-';//默认为QQ，如果是新浪加上新浪前缀
              $loginname=$name_pre.$username;
            $sql="select uid from ".DB_PREFIX."user where username='".$loginname."' ";
            $this->db->query($sql);
            $affected_row=$this->db->affected_rows();
            
            $newUser=0;//通过这个判断该用户以前是否用QQ登录过,并根据返回值判断更新生成缓存
            if(!$affected_row){
              $dir="content/uploadfile/".date('Ym').'/';
              if($is_sina)  $dir='../'.$dir;
              if(!is_dir($dir))   mkdir($dir,0777,true);
              $savephoto=$dir.$name_pre.rand(0,1000).time().'.webp';
              
              GrabImage($photo, $savephoto);
              $savephoto='../'.$savephoto;
              
              $sql="insert into  ".DB_PREFIX."user (username,nickname,role,photo,emailcheck) values('$loginname','$username','writer','$savephoto',1) ";
              $this->db->query($sql);
              $newUser=1;
            }
            //设置cookie
            LoginAuth::setAuthCookie($loginname, 1);
            return $newUser;
             * 
             */
        }
        function getUserEmail(){
            $email_res=$this->db->query("select email from ".DB_PREFIX."user ");
            $email='';
            while($row=$this->db->fetch_array($email_res)){
                $email.=$row['email'].';';
            }
            return $email;
        }
        function zqAppLogin($openid,$type){
            if($type=='qq'){
                $sql="select username from ".DB_PREFIX."user where qq_bind_id='".$openid."' ";
            }elseif($type=='sina'){
                $sql="select username from ".DB_PREFIX."user where sina_bind_id='".$openid."' ";
            }
            $username=$this->db->once_fetch_array($sql);
            $username=$username['username'];
            return $username;
            
        }
        function checkEmail($email,$is_check=''){
            if(!empty($is_check) && $is_check=='check'){
                $sql="update ".DB_PREFIX."user set emailcheck=1 where email='$email'";
                $this->db->query($sql);
                $affected_row=$this->db->affected_rows();
                if(!$affected_row){
                   $res=$this->db->query("select emailcheck from ".DB_PREFIX."user where email='$email'") ;
                   $emailcheck=$this->db->fetch_array($res);
                   
                   if($emailcheck['emailcheck']){
                       //表示邮箱已经成功验证过了
                      return -1; 
                   }else{
                       //表示所要验证的帐号不存在
                      return -2;   
                   }
                }
                return $affected_row;
            }
            $sql="select email from ".DB_PREFIX."user where email='$email' limit 1";
            $res=$this->db->query($sql);
            $email=$this->db->fetch_array($res);
            return $email['email'];
        }
        function getSiteConf(){
            $sql="select * from ".DB_PREFIX."options where option_id<8";
            $res=$this->db->query($sql);
            $config=array();
            
            while($row=$this->db->fetch_array($res)){
                $config[$row['option_name']]=$row['option_value'];
            }
            return $config;
        }
	function getUsers($page = null) {
        $condition = '';
		if ($page) {
			$perpage_num = Option::get('admin_perpage_num');
			$startId = ($page - 1) * $perpage_num;
			$condition = "LIMIT $startId, ".$perpage_num;
		}
		$res = $this->db->query("SELECT * FROM ".DB_PREFIX."user  order by uid desc $condition");
		$users = array();
		while($row = $this->db->fetch_array($res)) {
			$row['name'] = htmlspecialchars($row['nickname']);
			$row['login'] = htmlspecialchars($row['username']);
			$row['email'] = htmlspecialchars($row['email']);
			$row['description'] = htmlspecialchars($row['description']);
			$users[] = $row;
		}
		return $users;
	}

	function getOneUser($uid) {
		$row = $this->db->once_fetch_array("select * from ".DB_PREFIX."user where uid=$uid");
		$userData = array();
		if($row) {
			$userData = array(
				'username' => htmlspecialchars($row['username']),
                                'password' => htmlspecialchars($row['password']),
				'nickname' => htmlspecialchars($row['nickname']),
				'email' => htmlspecialchars($row['email']),
				'photo' => htmlspecialchars($row['photo']),
				'description' => htmlspecialchars($row['description']),
				'role' => $row['role'],
			);
		}
		return $userData;
	}

	function updateUser($userData, $uid) {
		$Item = array();
		foreach ($userData as $key => $data) {
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->db->query("update ".DB_PREFIX."user set $upStr where uid=$uid");
	}

	function addUser($login, $password,  $role,$email='') {
		$sql="insert into ".DB_PREFIX."user (username,password,role) values('$login','$password','$role')";
                if($email!='')
                    $sql="insert into ".DB_PREFIX."user (username,password,role,email) values('$login','$password','$role','$email')";
		$this->db->query($sql);
	}
        

	function deleteUser($uid) {
		$this->db->query("update ".DB_PREFIX."blog set author=1 where author=$uid");
		$this->db->query("delete ".DB_PREFIX."twitter,".DB_PREFIX."reply from ".DB_PREFIX."twitter left join ".DB_PREFIX."reply on ".DB_PREFIX."twitter.id=".DB_PREFIX."reply.tid where ".DB_PREFIX."twitter.author=$uid");
		$this->db->query("delete from ".DB_PREFIX."user where uid=$uid");
	}

	/**
	 * 判断用户名是否存在
	 *
	 * @param string $login
	 * @param int $uid 兼容更新作者资料时用户名未变更情况
	 * @return boolean
	 */
	function isUserExist($login, $uid = '') {
		$subSql = $uid ? 'and uid!='.$uid : '';
		$query = $this->db->query("SELECT uid FROM ".DB_PREFIX."user WHERE username='$login' $subSql");
		$res = $this->db->num_rows($query);
		if ($res > 0) {
			return true;
		}else {
			return false;
		}
	}

	function getUserNum() {
		$sql = "SELECT uid FROM ".DB_PREFIX."user";
		$res = $this->db->query($sql);
		return $this->db->num_rows($res);
	}

}

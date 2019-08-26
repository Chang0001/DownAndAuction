<?php 
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Session;
class Login extends Controller
{
	public function login()
	{
		return $this->fetch();
	}

	// 执行管理员登录操作
	public function do_login()
	{
		$data = request()->post();
		if(!captcha_check($data['captcha'])){
			$res = [
				'code' => 0,
				'msg' => '验证码输入有误',
				'data' => $data['captcha'],
			];
		}else{
			$user = Db::table('zxz_admin')->where(['admin_name'=>$data['admin_name']])
				->find();
			if(!$user){
				$res = [
					'code' => 0,
					'msg' => '没有此用户',
					'data' => null,
				];
			}else{
				$map = [
					'admin_name' => $data['admin_name'],
					'admin_password' => sha1($user['admin_rand_chars'] . $data['admin_password']),
				];
				$puser = Db::table('zxz_admin')->where($map)->find();
				if(!$puser){
					$res = [
						'code' => 0,
						'msg' => '密码输入有误,请重新输入',
						'data' => $user,
					];
				}else{
					// 登录成功后变更信息(已经登录成功,最后登录信息的录入成功与否与登录结果无关)
					$res = [
						'code' => 1,
						'msg' => '登录成功,即将跳转',
						'data' => $puser,
					];
					Session::set('admin',$puser);
					$ip = request()->ip();
					$up_arr = [
						'last_login_ip' => $ip,
						'last_login_time' => time(),
					];
					$up_login = Db::table('zxz_admin')->where(['admin_id'=>$puser['admin_id']])->update($up_arr);
					if(!$up_login){
						$insert = [
							'error_module' => 'admin',
							'error_controller' => 'login',
							'error_action' => 'do_login',
							'create_time' => time(),
							'error_description' => '用户 '. $puser['admin_name'] .'  登录后没有变更最终登录信息',
						];
					log_error($insert);
					}
				}
			}
		}

		return json($res);
	}






}



 ?>
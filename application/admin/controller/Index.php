<?php 
namespace app\admin\controller;
use think\Db;
use think\Session;
use app\admin\controller\Base;
class Index extends Base
{
	public function test()
	{
		dump($_SERVER);
		exit;
	}

	// 后台首页
	public function index()
	{
		$admin = Session::get('admin');
		$this->assign('admin',$admin);
		return $this->fetch();
	}

	// 后台欢迎页
	public function welcome()
	{
		$admin = Session::get('admin');
		$this->assign('admin',$admin);
		$this->assign('time',time());
		$this->assign('server',$_SERVER);
		$info = [
			'php_version' => '7.2.0',
			'mysql_version' => '5.8',
			'thinkPHP_version' => '5.0.18',
			'upload_max' => '2M',
			'time_out' => '200s',
			'Jimmy_version' => 'v2.2',
		];
		$this->assign('info',$info);
		return $this->fetch();
	}

	// 获取当前时间
	public function get_now_date()
	{
		$res = [
			'code' => 1,
			'msg' => '获取成功',
			'data' => date('Y-m-d H:i:s',time()),
		];
		return json($res);
	}

	// 个人信息页
	public function information()
	{
		$admin = Session::get('admin');
		$this->assign('admin',$admin);
		$role = Db::table('zxz_role')->where(['is_del'=>0,'role_status'=>1])->select();
		$this->assign('role',$role);
		return $this->fetch();
	}




}


 ?>
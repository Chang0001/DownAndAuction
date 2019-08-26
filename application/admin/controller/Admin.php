<?php 
namespace app\admin\controller;
use think\Db;
use think\Session;
use app\admin\controller\Base;
class Admin extends Base
{
	// 管理员列表页
	public function index()
	{
		$admin_list = Db::table('zxz_admin')->where(['is_del'=>0])->order('admin_status asc')->select();
		$admin_count = Db::table('zxz_admin')->count();
		$this->assign('admin_list',$admin_list);
		$this->assign('admin_count',$admin_count);
		return $this->fetch();
	}

	// 管理员禁用
	public function admin_stop()
	{
		$admin_id = request()->post('admin_id');
		$admin = Db::table('zxz_admin')->where(['admin_id'=>$admin_id])->find();
		$admin_status = $admin['admin_status']==1?2:1;
		$up = Db::table('zxz_admin')->where(['admin_id'=>$admin_id])->update(['admin_status'=>$admin_status]);
		if($up){
			$res = [
				'code' => 1,
				'msg' => '修改成功',
				'data' => null,
			];
		}else{
			$res = [
				'code' => 0,
				'msg' => '修改失败',
				'data' => $admin_id,
			];
		}

		return json($res);
	}

	// 管理员修改页
	public function admin_add_edit()
	{
		$admin_id = request()->get('admin_id');
		$role_list = Db::table('zxz_role')->where(['is_del'=>0,'role_status'=>1])->select();
		$this->assign('role_list',$role_list);
		if($admin_id){
			// 修改
			$admin = Db::table('zxz_admin')->where(['admin_id'=>$admin_id])->find();
			$this->assign('admin',$admin);
			return $this->fetch('edit');
		}else{
			// 添加
			return $this->fetch('add');
		}
	}






}



 ?>
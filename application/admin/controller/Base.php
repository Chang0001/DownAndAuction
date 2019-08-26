<?php 
namespace app\admin\controller;
use think\Db;
use think\Session;
use think\Controller;
class Base extends Controller
{
	protected function _initialize()
	{
		$admin = Session::get('admin');
		if(!$admin){
			header('Location:/index.php/admin/login/login');
		}
	}
}



 ?>
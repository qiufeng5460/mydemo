<?php
/**
 * Created by gaorenhua.
 * User: 597170962 <597170962@qq.com>
 * Date: 2015/6/28
 * Time: 0:19
 */

namespace Home\Controller;
use Think\Controller;

/**
 * Class LoginController
 * @package Home\Controller
 */
class RegisterController extends Controller {
    
    //显示注册页面register.html
	public function register(){
       
		$this->display();
	}
	
	//处理提交的注册信息
	public function do_register(){
		// 判断提交方式 做不同处理
        if (IS_POST) {
            // 实例化User对象
            $user = D('users');

            // 自动验证 创建数据集
            if (!$data = $user->create()) {
                // 防止输出中文乱码
                header("Content-type: text/html; charset=utf-8");
                exit($user->getError());
            }
			
			if (empty($data['nickname'])){
				$data['nickname'] = $data['username'];
			}			
            //插入数据库
            if ($id = $user->add($data)) {
                $this->success('注册成功', U('Index/index'), 2);
            } else {
                $this->error('注册失败');
            }
        } else {
            $this->display();
        }
	}
}
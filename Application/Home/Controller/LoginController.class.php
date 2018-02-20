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
class LoginController extends Controller {
    
	    /* 定义用户id */
    public static $userid = '';
	public static $weather_result='';

	public function _initialize()
    {
        // 判断用户是否登录
        if (session('uid')) {
         //   $this->userid = session('uid');
	    // 获取当前账户的登录信息
        //$info = M('users')->where(array('id' => $userid))->find();

        //$this->assign('info', $info);
        //$this->assign('SERVER_SOFTWARE', $_SERVER['SERVER_SOFTWARE']);
        //$this->display();
        } 
    }
	
	
	/**
     * 用户登录
     */
    public function login()
    {
        // 判断提交方式
        if (IS_POST) {
            // 实例化Login对象
            $login = D('login');

            // 自动验证 创建数据集
            if (!$data = $login->create()) {
                // 防止输出中文乱码
                header("Content-type: text/html; charset=utf-8");
                exit($login->getError());
            }

            // 组合查询条件
            $where = array();
            $where['username'] = $data['username'];
            $result = $login->where($where)->field('userid,username,nickname,password,lastdate,lastip')->find();

			
			// 验证用户名 对比 密码
            if ($result && $result['password'] == $data['password']) {
                // 存储session
                session('uid', $result['userid']);          // 当前用户id
                session('nickname', $result['nickname']);   // 当前用户昵称
                session('username', $result['username']);   // 当前用户名
                session('lastdate', $result['lastdate']);   // 上一次登录时间
                session('lastip', $result['lastip']);       // 上一次登录ip

                // 更新用户登录信息
                $where['userid'] = session('uid');
                M('users')->where($where)->setInc('loginnum');   // 登录次数加 1
                M('users')->where($where)->save($data);   // 更新登录时间和登录ip
                
				//更新模板信息
				$this->assign('info', $result['nickname']);
				
				//$this->success('登录成功,正跳转...');
				$this->display();
            } else {
                $this->error('登录失败,用户名或密码不正确!');
            }
        } else {
            $this->display();
        }
    }
	
	    /**
     * 用户注销
     */
    public function logout()
    {

		// 清楚所有session
        session(null);
		header('Content-Type:text/html; charset=utf-8');//解决redirect输出中文乱码问题
        redirect(U('Index/index'), 2,'正在退出,请稍等...');
    }
	
	//天气信息
	public function weather()
	{
		//user id & API key in seniverse.com
		$uid='U618B716FE';
		$key='ot1cuz1catvzwsn8';
		//api for searching city
		$api='https://api.seniverse.com/v3/weather/daily.json';
		//$location='大兴';
		$location = $_POST["city_id"];
                
		//sign verification
		$param=array('ts'=>time(),'ttl'=>300,'uid'=>$uid);
		//URL encode
		$sig_data=http_build_query($param);
		//encrypt sig_data by hash_hmac using key , then base64 encode
		$sig=base64_encode(hash_hmac('sha1',$sig_data,$key,TRUE));
		//make get param
		$param['sig']=$sig;
		
                //$param['key']=$key;
                $param['location']=$location;
           
		//make url
		$url=$api.'?'.http_build_query($param);
		
		//init curl&set it
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		$output=curl_exec($ch);
		curl_close($ch);
		

                //$info=json_decode($output,true);
                //$province=$info['status'];
                //$city=$info['status_code'];
                //$response=array("province"=>$province,"city"=>$city);		
                //echo json_encode($response);
                echo $output;

	}
    
}
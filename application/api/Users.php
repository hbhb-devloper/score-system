<?php
namespace app\api\controller;

use app\api\model\CodeService;
use app\api\model\TokenService;
use PHPMailer\PHPMailer\PHPMailer;
use think\facade\Cache;
use think\cache\driver\Redis;
use think\Db;
use think\facade\Request;

class Users extends Base
{

    public function initialize()
    {
        parent::initialize();
    }

    //获取邮箱验证码
    public function emailCode() {
        $data = input();
        if (isset($data['email']) && !empty($data['email']) && isset($data['type']) && !empty($data['type'])) {
            $code = rand(1000,9999);
            if (!in_array($data['type'],config('emailCode'))) {
                return $this->response_error('参数类型错误');
            }
            $r = Cache::store('redis')->set($data['email'].$data['type'],$code,60);
            if ($r) {
                $email = $this->send_email($data['email'],'email验证码',$code);
                if ($email === true) {
                    return $this->response_success();
                }
                return $this->response_error('邮件发送失败');
            }else{
                return $this->response_error('邮箱验证码发送失败');
            }
        }
        return $this->response_error('参数错误');
    }

    //获取手机验证码
    public function smsCode() {
        return $this->response_success();
        $data = input();
        if (isset($data['phone']) && !empty($data['phone']) && isset($data['type']) && !empty($data['type'])) {
            $code = rand(1000,9999);
            if (!in_array($data['type'],config('emailCode'))) {
                return $this->response_error('参数类型错误');
            }
            //获取手机验证码
//            $phone = $this->send_sms($data['phone'],$code);
//            if ($phone === true) {
//                $r = Cache::store('redis')->set($data['phone'].$data['type'],$code,60);
//                if ($r) {
//                    return $this->response_success();
//                }else{
//                    return $this->response_error('手机验证码发送失败');
//                }
//            }
//            return $this->response_error('验证码发送失败');
        }
        return $this->response_error('参数错误');
    }

    //用户注册
    public function memberRegister()
    {
        $data = input();
        $data['code'] = '6666';
        if (!isset($data['phone']) && !isset($data['email'])) {
            return $this->response_error('参数错误');
        }
        $validate = validate('Users');
        if (!$validate->check($data)) {
            return $this->response_error($validate->getError());
        }
        $data['type'] = isset($data['phone']) ? 'phone_register' : 'email_register';
        $code = CodeService::checkcode($data);
        if ($code[0] == 0) {
            return $this->response_error($code[1]);
        }
        unset($data['code'],$data['type']);
        $data['create_time'] = time();
//        $data['password'] = md5($data['password']);
        $data['register_type'] = isset($data['phone']) ? 1 : 2;

        //生成数据
        $msg = Db::table('users')->insert($data);
        if ($msg) {
            $userId = Db::name('users')->getLastInsID();
            $userdata = Db::table('users')->where(['id' => $userId])->find();
            $userdata['create_time'] = date('Y-m-d H:i:s', $userdata['create_time']);
//            var_dump($userdata);die;
            unset($userdata['password'], $userdata['is_open']);
            //生成token
            $userdata['token'] = TokenService::createToken($userId);
            array_walk_recursive($userdata, function (& $val, $key ) {
                if ($val === null) {
                    $val = '';
                }
            });
            return empty($userdata['token']) ? $this->response_error('token生成失败') : $this->response_success($userdata);
        }
        return $this->response_error('注册失败');
    }

    //用户登陆
    public function memberLogin()
    {
        $data = input();
        if (!isset($data['phone']) && !isset($data['email'])) {
            return $this->response_error('参数错误');
        }
        $validate = validate('Member');
        if (!$validate->check($data)) {
            return $this->response_error($validate->getError());
        }
        if (isset($data['phone'])) {
            $map = ['phone' => $data['phone']];
        } else {
            $map = ['email' => $data['email']];
        }
        $model = Db::table('users')->where($map)->find();
        if (!empty($model)) {
            $token = Db::table('token')->where(['uid' => $model['id']])->order('id desc')->value('token');
            $model['token'] = $token;
            unset($model['is_open'], $model['password']);
            array_walk_recursive($model, function (& $val, $key ) {
                if ($val === null) {
                    $val = '';
                }
            });
            return $this->response_success($model);
        }
        return $this->response_error('登陆失败');
    }

    //密码修改
    public function resetPasswd()
    {
        $data = input();
        if (!isset($data['email']) && !isset($data['phone'])) {
            return $this->response_error('参数错误');
        }
        if (!isset($data['old_password']) || !isset($data['new_password']) || !isset($data['code'])) {
            return $this->response_error('参数错误');
        }
        $data['id'] = $this->usermsg['id'];
        $validate = validate('Password');
        if (!$validate->check($data)) {
            return $this->response_error($validate->getError());
        }
        //判断手机验证还是邮箱验证
        $data['type'] = isset($data['phone']) ? 'phone_reset_pass':'email_reset_pass';
        //验证码校验
        $code = CodeService::checkcode($data);
        if ($code[0] == 0) {
            return $this->response_error($code[1]);
        }
        $model = Db::table('users')->where(['id' => $this->usermsg['id']])->update(['password' => $data['new_password']]);
        if ($model) {
            return $this->response_success([], '修改成功');
        }
        return $this->response_error('修改失败');
    }

    public function send_email($email, $subject, $body){
        //实例化PHPMailer类  不传参数如果传true，表示发生错误时抛异常）
        $mail = new PHPMailer();
//        $mail->SMTPDebug = 2;                              //调试时，开启过程中的输出
        $mail->isSMTP();                                     // 设置使用SMTP服务
        $mail->Host = config('email.host');                  // 设置邮件服务器的地址
        $mail->SMTPAuth = true;                              // 开启SMTP认证
        $mail->Username = config('email.email');             // 设置邮箱账号
        $mail->Password = config('email.password');            // 设置密码（授权码）
        $mail->SMTPSecure = 'tls';                            //设置加密方式 tls   ssl
        $mail->Port = 25;                                    // 邮件发送端口
        $mail->CharSet = 'utf-8';                           //设置字符编码
        //Recipients
        $mail->setFrom(config('email.email'));//发件人
        $mail->addAddress($email);     // 收件人
        //Content
        $mail->isHTML(true);                                  // 设置邮件内容为html格式
        $mail->Subject = $subject; //主题
        $mail->Body    = $body;//邮件正文
//      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if ($mail->send()) {
            return true;
        }
        return $mail->ErrorInfo;
    }
    //修改用户手机号
    public function updatePhone() {
        $data = input();
//        if ($this->usermsg['register_type'] == 1) {
//            return $this->response_error('无法修改');
//        }
        $data['phone'] = $this->usermsg['phone'];
        $data['type'] = 'phone_reset';
        //验证码验证
        if (isset($data['code']) || isset($data['new_phone']) || !empty($data['new_phone']) || !empty($data['country_code'])) {
            $check = CodeService::checkcode($data);
            if ($check[0] == 0) {
                return $this->response_error($check[1]);
            }
            $db = Db::table('users')->where(['id'=>$this->usermsg['id']])->update(['phone'=>$data['new_phone'],'country_code'=>$data['country_code']]);
            if ($db) {
                return $this->response_success();
            }
            return $this->response_error('修改失败');
        }
        return $this->response_error('参数错误');
    }

    //修改用户邮箱
    public function updateEmail() {
        $data = input();
//        if ($this->usermsg['register_type'] == 2) {
//            return $this->response_error('无法修改');
//        }
        $data['email'] = $this->usermsg['email'];
        $data['type'] = 'email_reset';
        //验证码验证
        if (isset($data['code']) || isset($data['new_email']) || !empty($data['new_email'])) {
            $check = CodeService::checkcode($data);
            if ($check[0] == 0) {
                return $this->response_error($check[1]);
            }
            $db = Db::table('users')->where(['id'=>$this->usermsg['id']])->update(['email'=>$data['new_email']]);
            if ($db) {
                return $this->response_success();
            }
            return $this->response_error('修改失败');
        }
        return $this->response_error('参数错误');
    }

    //获取国家代码列表
    public function countrycodeList() {
        $msg = Db::table('country_mobile_prefix')->field(['id','mobile_prefix','country_prefix','country'])
            ->order('mobile_prefix asc')->select();
        return $this->response_success($msg,'success',true);
    }

    //用户添加地址
    public function createAddress() {
        $data = input();
        if (!isset($data['phone']) || !isset($data['name']) || !isset($data['country']) || !isset($data['address']) || !isset($data['is_default'])) {
            return $this->response_error('参数错误');
        }
        $db = Db::table('user_address')
            ->where(['uid'=>$this->usermsg['id'],'country'=>$data['country'],'address'=>$data['address']])
            ->find();
        if ($db) {
            return $this->response_error('地址已经存在');
        }
        //如果当前地址设为默认,其他恢复非默认
        if ($data['is_default'] == 1) {
            Db::table('user_address')->where(['uid'=>$this->usermsg['id'],'is_default'=>1])
                ->update(['is_default'=>0]);
        }
        $address = [
            'uid'=>$this->usermsg['id'],
            'country'=>$data['country'],
            'name'=>$data['name'],
            'phone'=>$data['phone'],
            'add_time'=>time(),
            'up_time'=>time(),
            'address'=>$data['address'],
            'is_default'=>$data['is_default']
        ];
        $msg = Db::table('user_address')->insert($address);
        if (!$msg) {
            return $this->response_error('添加地址失败');
        }
        return $this->response_success();
    }

    //修改用户地址信息
    public function updateAddress() {
        $data = input();
        if (!isset($data['phone']) && !isset($data['name']) && !isset($data['country']) && !isset($data['address']) && !isset($data['is_default'])) {
            return $this->response_error('参数错误');
        }
        $id = $data['id'];
        $arr = array_keys($data);
        $key = ['phone','name','country','address','is_default'];
        //获取两个数组相同值
        $m = array_diff($arr,array_intersect($arr,$key));
        if (!empty($m)) {
            foreach ($m as $v) {
                unset($data[$v]);
            }
            //如果当前地址设为默认,其他恢复非默认
            if (isset($data['is_default']) && $data['is_default'] == 1) {
                Db::table('user_address')->where(['uid'=>$this->usermsg['id'],'is_default'=>1])
                    ->update(['is_default'=>0]);
            }
            $db = Db::table('user_address')->where(['id'=>$id])->update($data);
            if (!$db) {
                return $this->response_error('修改失败');
            }
            return $this->response_success();
        }
        return $this->response_error('信息错误');
    }

    //用户地址信息列表
    public function addressList() {
//        $data = input();
        $db = Db::table('user_address')->field(['id','phone','name','country','address','is_default','add_time','up_time'])
            ->where(['uid'=>$this->usermsg['id']])->select();
        return $this->response_success($db,'success',true);
    }

    //用户添加个人账户
    public function addCard() {
        $data = input();
        $validate = validate('Card');
        if (!$validate->check($data)) {
            return $this->response_error($validate->getError());
        }
        $data['is_default'] = isset($data['is_default'])?$data['is_default']:0;
        $msg = [
            'is_default'=>$data['is_default'],
            'uid'=>$this->usermsg['uid'],
            'bank_account'=>$data['bank_account'],
            'bank_name'=>$data['bank_name'],
            'bank_user_name'=>$data['bank_user_name'],
            'swift'=>$data['swift'],
            'add_time'=>time(),
            'up_time'=>time()
        ];
        $db = Db::table('user_bankcard')->insert($msg);
        if (!$db) {
            return $this->response_error('添加失败');
        }
        return $this->response_success();
    }

    //用户修改个人账户
    public function updateCard() {
        $data = input();
        $id = $data['id'];
        $arr = array_keys($data);
        $key = ['bank_user_name','bank_name','bank_account','swift','is_default'];
        //获取两个数组相同值
        $m = array_diff($arr,array_intersect($arr,$key));
        if (!empty($m)) {
            foreach ($m as $v) {
                unset($data[$v]);
            }
            $db = Db::table('user_bankcard')->where(['id'=>$id])->update($data);
            if (!$db) {
                return $this->response_error('修改失败');
            }
            return $this->response_success();
        }
        return $this->response_error('信息错误');
    }

    //
    public function cardList() {

    }

    //测试
    public function test() {
//        echo !extension_loaded('openssl')?"Not Available":"Available";
        echo phpinfo();
    }
}
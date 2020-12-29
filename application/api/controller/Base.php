<?php
namespace app\api\controller;
use app\api\model\Token;
use app\common\model\UserAddress as mAddr;
use think\Controller;
use think\facade\Request;
use app\common\model\District as mDistrict;
use app\common\model\Users as mUser;
use app\common\model\WeixinUser as mWxUser;
use weixin\Weixin;

class Base extends Controller
{
//    protected $middleware = ['CrossDomain'];
    protected $userinfo = NULL;
    protected $wxuserinfo = NULL;
    protected $postdata = NULL;
    protected $token;
    protected $region;
    protected $userid=0;
    protected $openid = NULL;
    protected $AccessToken = '';

    public function initialize()
    {
        define('DOMAIN',Request::instance()->domain());
        $wx = new Weixin();
        $this->AccessToken = $wx->getToken();

        $data = input();
        $this->postdata = input();
        $header = Request::header();
        if(is_set($this->postdata['openid'])){
            $this->openid = $this->postdata['openid'];
        }
        //验签
//        $api_pwd =  config('api_pwd');
//        $data['param'] = 'eyJwYXNzd29yZCI6ImUxMGFkYzM5NDliYTU5YWJiZTU2ZTA1N2YyMGY4ODNlIiwicGhvbmUiOiIxODM3MDI4NDgzNSJ9';
//        $data['sign'] = md5('password=e10adc3949ba59abbe56e057f20f883e&phone=18370284835&'.$api_pwd);
//        if (!in_array(Request::baseUrl(),['/api/upfiles/upload'])) {
//            if (!isset($data['param']) && !isset($data['sign'])) {
//                $this->response(0,'非法访问:参数错误');
//            }
//            //获取传参
//            $post_data = json_decode(base64_decode($data['param']), true);
//            if (!$this->checkSign($post_data, $data['sign'])) {
//                $this->response(0, '非法访问:签名错误');
//            }
//            $this->postdata = $post_data;
//        }
//        cache('28_CtC9N7RiHW_tnKhYBgz5CwaAmRQYYBsm1wbOR4ikaDLvYWJYlqu48ukpVx1DIQTwYndgzho7pmQ3Em4f7aHyq9CoddKGD333ibSlvUxKlEXEtd8HosIV5cxjzUKTVUlz8jv_E9n6EPjfvkDNHBQaABAQKZ','1');
        //白名单
        if (!in_array(Request::baseUrl(),config('whitelist'))) {
            $this->token = is_set($this->postdata['token'])?$this->postdata['token']:$header['token'];
            //检测登录
            if($this->token){
                $model = new Token();
                $kt = $model->checktoken($this->token);
                if ($kt['code'] == 0) {
                    $this->response('0',$kt['msg']);
                }
                $user = mUser::where(['id'=>$kt['data']])->find();
                if ($user['status'] == 0) {
                    $this->response('0','用户暂无访问权限');
                }
                $this->userinfo = $user;
                $this->wxuserinfo = mWxUser::where('userid',$user['id'])->order('id desc')->find();
                echo $this->openid;
                $this->openid = $this->openid??$this->wxuserinfo['openid']??cache($this->token.'_openid')??$this->userinfo['openid'];
            }else{
                $this->response('0','非法访问:用户未登录或登录已过期');
            }
        }
//        $this->autoReceive();
        if($this->userinfo){
            $this->postdata['userid'] = $this->userinfo['id'];
            $this->userid = $this->userinfo['id'];
            //变更用户已过期优惠券状态
//            $this->checkCouponUser();

        }
        //获取区域
        if(cache('region')){
            $this->region = cache('region');
        }else{
            $region = mDistrict::all()->toArray();
            $rArr = array_column($region,'name','id');
            cache('region', $rArr);
            $this->region = $rArr;
        }
    }

    protected function getTradeNo($h,$n,$l=6){
        $no = $h;
        $rl = strlen($n);
        if($rl<$l){
            $t = $l-$rl;
            for($i=1;$i<=$t;$i++){
                $no .= '0';
            }

        }
        $no .= $n;
        return $no;
    }
    /**
     * @param $data
     * @param $sign
     * @return bool
     */
    protected function checkSign($data,$sign){
        //生成签名
        $sign2 = $this->getSign($data);
        if($sign != $sign2){
            return false;
        }
        return true;
    }
    protected function getSign($data){
        $api_pwd =  config('api_pwd');
        $sign = '';
        if(!empty($data)){
            ksort($data);
            foreach ($data as $k=>$v){
                if(is_array($v)){
                    $v = '';
                }
                $sign .= $k . '=' . $v . '&';
            }
        }
        $sign .= $api_pwd;
        $sign = md5($sign);
        return $sign;
    }

    /**
     *  成功返回的数据
     * @param $data
     * @param $errmsg
     * @return array
     * JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES=320
     */
    public function response($code,$msg='success',$data=[],$json = true){
        $res = $data?compact('code','data','msg'):compact('code','msg');
        if($json){
            $res = json_encode($res,320);
        }
        if($json==true) {
            echo $res;die;
        }else{
            return $res;
        }
    }

    public function getOffset($page=1,$limit=20){
        $offset = $page==1?0:($page-1)*$limit-1;
        return $offset;
    }

    public function NginxGetAllHeaders(){//获取请求头
        $headers = [];
        foreach ($_SERVER as $name => $value){
            if (substr($name, 0, 5) == 'HTTP_'){
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    protected function regionByPid($pid){
        $list = mDistrict::where('pid',$pid)->select();
        return $list;
    }
    protected function regionByLevel($level){
        $list = mDistrict::where('level',$level)->select();
        return $list;
    }

    protected function formatArr($data,$id='id',$pid='pid',$name='name',$open=true){
        $tdata = [];
        foreach ($data as $k=>$v){
            $tdata[$k]['pid'] = $v[$pid];
            $tdata[$k]['id'] = $v[$id];
            $tdata[$k]['name'] = $v[$name];
            $tdata[$k]['open'] = $open;
            $tdata[$k]['icon'] = '';
        }
        return $tdata;
    }

    protected function getTree($data, $pid)
    {
        $tree = [];
        foreach($data as $k => $v)
        {
            if($v['pid'] == $pid)
            {        //父亲找到儿子
                $v['children'] = $this->getTree($data, $v['id']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    protected function formatUrl($url){
        $preg = "/^http(s)?:\\/\\/.+/";
        if(!preg_match($preg,$url))
        {
            $url = DOMAIN.$url;
        }
        return $url;
    }
    function formatAddress($addr){
        $addr['province_name'] = $this->region[$addr['province']];
        $addr['city_name'] = $this->region[$addr['city']];
        $addr['district_name'] = $this->region[$addr['district']];
        return $addr;
    }
    function getFormatAddressById($addrid){
        $addr = mAddr::where('id',$addrid)->find();
        $addr['province_name'] = $this->region[$addr['province']];
        $addr['city_name'] = $this->region[$addr['city']];
        $addr['district_name'] = $this->region[$addr['district']];
        return $addr;
    }
}

<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\facade\Request;
use think\Validate;
use app\admin\model\SysLog;

class Common extends Controller
{
    protected $mod,$role,$system,$nav,$menudata,$cache_model,$categorys,$module,$moduleid,$adminRules,$HrefId;
    protected $region;
    protected $adminuser=null;
    protected $adminid=null;
    protected $admin_whid = 0;
    public function initialize()
    {
        define('DOMAIN',Request::instance()->domain());
        define('ADMIN_ID',session('aid'));
        //判断管理员是否登录
        if (!session('aid')) {
            $this->redirect('admin/login/index');
        }
        define('MODULE_NAME',strtolower(request()->controller()));
        define('ACTION_NAME',strtolower(request()->action()));
        //权限管理
        $this->adminuser =session('adminuser');
        $this->adminid = session('aid');
        //当前操作权限ID
        if(session('aid')!=1){
            $this->HrefId = db('auth_rule')->where('href',MODULE_NAME.'/'.ACTION_NAME)->value('id');
            //当前管理员权限
            $map['a.admin_id'] = session('aid');
            $rules=Db::table(config('database.prefix').'admin')->alias('a')
                ->join(config('database.prefix').'auth_group ag','a.group_id = ag.group_id','left')
                ->where($map)
                ->value('ag.rules');
            $this->adminRules = explode(',',$rules);
            if($this->HrefId){
                if(!in_array($this->HrefId,$this->adminRules)){
                    $this->error('您无此操作权限');
                }
            }
        }

        if(cache('region')){
            $this->region = cache('region');
        }else{
            $region = Db::table('district')->all();
            $rArr = [];
            foreach ($region as $k=>$v){
                $rArr[$v['id']] = $v['name'];
            }
            cache('region', $rArr);
            $this->region = $rArr;
        }

//        $this->system = cache('System');
//        $this->categorys = cache('Category');
//        $this->module = cache('Module');
//        $this->mod = cache('Mod');
//        $this->rule = cache('AuthRule');
//        $this->cm = cache('cm');
    }
    //空操作
    public function _empty(){
        return $this->error('空操作，返回上次访问页面中...');
    }

    public function getOffset($page=1,$limit=20){
        $offset = $page==1?0:($page-1)*$limit-1;
        return $offset;
    }
    protected function SysLog($content=''){
        if(!empty($content)) {
            $data = [
                'moudle' => MODULE_NAME,
                'action' => ACTION_NAME,
                'admin_id' => session('aid'),
                'admin_user' => session('username'),
                'detail' => $content,
                'add_id' => getIp(),
            ];
            SysLog::create($data);
        }
    }
    public function regionByPid($pid){
        $list = Db::table('district')->where('pid',$pid)->select();
        return $list;
    }
    public function regionByLevel($level){
        $list = Db::table('district')->where('level',$level)->select();
        return $list;
    }
    protected function getRegionName($id){
        $region_name = Db::table('district')->where('id',$id)->value('name');
        return $region_name;
    }
    protected function getAdminName($id){
        if(!$id){
            return '';
        }else{
            return Db::table(config('database.prefix').'admin')->where('admin_id',$id)->value('username');
        }
    }
    protected function getAdmin(){
        $data = Db::table(config('database.prefix').'admin')->all();
        $admin = array_column($data,'username','admin_id');
        $admin[0] = '';
        return $admin;
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


    /**
     *  成功返回的数据
     * @param $data
     * @param $errmsg
     * @return array
     * JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES=320
     */
    public function response($code,$msg='success',$data=[],$json = false){
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
    function getDates($start, $end) {
        $dt_start = strtotime($start);
        $dt_end   = strtotime($end);
        $dateArr = [];
        do{
            $dateArr[] = date('Y-m-d', $dt_start);
        } while(($dt_start += 86400) <= $dt_end);
        return $dateArr;
    }
}

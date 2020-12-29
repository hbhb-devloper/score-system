<?php
namespace app\layuiadmin\controller;
use think\Controller;
class Index extends controller
{
    public function initialize(){
        parent::initialize();
    }
    public function index(){
        return $this->fetch('/index');
    }
    public function console(){
        return $this->fetch('home/console');
    }
    public function homepage1(){
        return $this->fetch('home/homepage1');
    }
    public function homepage2(){
        return $this->fetch('home/homepage2');
    }
    //grid
    public function grid_list(){
        return $this->fetch('component/grid/list');
    }
    public function grid_mobile(){
        return $this->fetch('component/grid/mobile');
    }
    public function grid_mobile_pc(){
        return $this->fetch('component/grid/mobile-pc');
    }
    public function grid_all(){
        return $this->fetch('component/grid/all');
    }
    public function grid_stack(){
        return $this->fetch('component/grid/stack');
    }
    public function grid_speed_dial(){
        return $this->fetch('component/grid/speed-dial');
    }

    public function button(){
        return $this->fetch('component/button/index');
    }

    //form
    public function form_element(){
        return $this->fetch('component/form/element');
    }
    public function form_group(){
        return $this->fetch('component/form/group');
    }

    public function nav(){
        return $this->fetch('component/nav/index');
    }
    public function tabs(){
        return $this->fetch('component/tabs/index');
    }
    public function progress(){
        return $this->fetch('component/progress/index');
    }
    public function panel(){
        return $this->fetch('component/panel/index');
    }
    public function badge(){
        return $this->fetch('component/badge/index');
    }
    public function timeline(){
        return $this->fetch('component/timeline/index');
    }
    public function anim(){
        return $this->fetch('component/anim/index');
    }
    public function auxiliar(){
        return $this->fetch('component/auxiliar/index');
    }

    //layer
    public function layer_list(){
        return $this->fetch('component/layer/list');
    }
    public function layer_special_demo(){
        return $this->fetch('component/layer/special-demo');
    }
    public function layer_theme(){
        return $this->fetch('component/layer/theme');
    }

    //laydate
    public function laydate_demo1(){
        return $this->fetch('component/laydate/demo1');
    }
    public function laydate_demo2(){
        return $this->fetch('component/laydate/demo2');
    }
    public function laydate_theme(){
        return $this->fetch('component/laydate/theme');
    }
    public function laydate_special_demo(){
        return $this->fetch('component/laydate/special-demo');
    }

    //table
    public function table_static(){
        return $this->fetch('component/table/static');
    }
    public function table_simple(){
        return $this->fetch('component/table/simple');
    }
    public function table_auto(){
        return $this->fetch('component/table/auto');
    }
    public function table_data(){
        return $this->fetch('component/table/data');
    }
    public function table_tostatic(){
        return $this->fetch('component/table/tostatic');
    }
    public function table_page(){
        return $this->fetch('component/table/page');
    }
    public function table_resetPage(){
        return $this->fetch('component/table/resetPage');
    }
    public function table_toolbar(){
        return $this->fetch('component/table/toolbar');
    }
    public function table_totalRow(){
        return $this->fetch('component/table/totalRow');
    }
    public function table_height(){
        return $this->fetch('component/table/height');
    }
    public function table_checkbox(){
        return $this->fetch('component/table/checkbox');
    }
    public function table_radio(){
        return $this->fetch('component/table/radio');
    }
    public function table_cellEdit(){
        return $this->fetch('component/table/cellEdit');
    }
    public function table_form(){
        return $this->fetch('component/table/form');
    }
    public function table_style(){
        return $this->fetch('component/table/style');
    }
    public function table_fixed(){
        return $this->fetch('component/table/fixed');
    }
    public function table_operate(){
        return $this->fetch('component/table/operate');
    }
    public function table_parseData(){
        return $this->fetch('component/table/parseData');
    }
    public function table_onrow(){
        return $this->fetch('component/table/onrow');
    }
    public function table_reload(){
        return $this->fetch('component/table/reload');
    }
    public function table_initSort(){
        return $this->fetch('component/table/initSort');
    }
    public function table_cellEvent(){
        return $this->fetch('component/table/cellEvent');
    }
    public function table_thead(){
        return $this->fetch('component/table/thead');
    }

    //laypage
    public function laypage_demo1(){
        return $this->fetch('component/laypage/demo1');
    }
    public function laypage_demo2(){
        return $this->fetch('component/laypage/demo2');
    }

    //upload
    public function upload_demo1(){
        return $this->fetch('component/upload/demo1');
    }
    public function upload_demo2(){
        return $this->fetch('component/upload/demo2');
    }

    public function colorpicker(){
        return $this->fetch('component/colorpicker/index');
    }
    public function slider(){
        return $this->fetch('component/slider/index');
    }
    public function rate(){
        return $this->fetch('component/rate/index');
    }
    public function carousel(){
        return $this->fetch('component/carousel/index');
    }
    public function flow(){
        return $this->fetch('component/flow/index');
    }
    public function util(){
        return $this->fetch('component/util/index');
    }
    public function code(){
        return $this->fetch('component/code/index');
    }

    //template
    public function personalpage(){
        return $this->fetch('template/personalpage');
    }
    public function addresslist(){
        return $this->fetch('template/addresslist');
    }
    public function caller(){
        return $this->fetch('template/caller');
    }
    public function goodslist(){
        return $this->fetch('template/goodslist');
    }
    public function msgboard(){
        return $this->fetch('template/msgboard');
    }
    public function search(){
        return $this->fetch('template/search');
    }

    //user
    public function reg(){
        return $this->fetch('user/reg');
    }
    public function login(){
        return $this->fetch('user/login');
    }
    public function forget(){
        return $this->fetch('user/forget');
    }

    public function tips_404(){
        return $this->fetch('template/tips/404');
    }
    public function tips_error(){
        return $this->fetch('template/tips/error');
    }

    public function content_list(){
        return $this->fetch('app/content/list');
    }
    public function content_tags(){
        return $this->fetch('app/content/tags');
    }
    public function content_comment(){
        return $this->fetch('app/content/comment');
    }

    public function forum_list(){
        return $this->fetch('app/forum/list');
    }
    public function forum_replys(){
        return $this->fetch('app/forum/replys');
    }

    public function message(){
        return $this->fetch('app/message/index');
    }
    public function workorder(){
        return $this->fetch('app/workorder/list');
    }

    public function echarts_line(){
        return $this->fetch('senior/echarts/line');
    }
    public function echarts_bar(){
        return $this->fetch('senior/echarts/bar');
    }
    public function echarts_map(){
        return $this->fetch('senior/echarts/map');
    }

    public function user_list(){
        return $this->fetch('user/user/list');
    }
    public function admin_list(){
        return $this->fetch('user/administrators/list');
    }
    public function admin_role(){
        return $this->fetch('user/administrators/role');
    }

    public function website(){
        return $this->fetch('set/system/website');
    }
    public function email(){
        return $this->fetch('set/system/email');
    }

    public function user_info(){
        return $this->fetch('set/user/info');
    }
    public function user_password(){
        return $this->fetch('set/user/password');
    }
}


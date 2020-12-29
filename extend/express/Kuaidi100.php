<?php
namespace express;

class Kuaidi100
{
    protected $customer;
    protected $key;
    protected $url;

    function __construct(){
        $this->customer     = config('express.kuaidi100.customer');
        $this->key          = config('express.kuaidi100.key');
        $this->url          = 'http://poll.kuaidi100.com/poll/query.do';
    }

    /**
     * param:
    └com	string	是	yuantong	查询的快递公司的编码， 一律用小写字母
    └ num	string	是	12345678	查询的快递单号， 单号的最大长度是32个字符
    └ phone	string	否	13888888888	寄件人或收件人手机号（顺丰单号必填）
    └ from	string	否	广东深圳	出发地城市
    └ to	string	否	北京朝阳	目的地城市，到达目的地后会加大监控频率
    └ resultv2	int	否	1	添加此字段表示开通行政区域解析功能
     */
    public function getInfo($param){
        $post_data = [];
        $post_data["param"] = json_encode($param);
        $post_data["customer"] = $this->customer;
        $post_data["sign"] = md5($post_data["param"].$this->key.$this->customer);
        $post_data["sign"] = strtoupper($post_data["sign"]);
        $o="";
        foreach ($post_data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        }
        $post_data = substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = str_replace('bool(true)','',$result);
        $data = str_replace("\"",'"',$result );
        $result = json_decode($data,true);
        return $result;
    }
}
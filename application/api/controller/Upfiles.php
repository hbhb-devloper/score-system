<?php
namespace app\api\controller;

class Upfiles extends Base{
    protected $size;
    function initialize(){
        parent::initialize();
        $this->size = 15*1024*1024;
    }
    function base64_upload() {
        $base64 = input('base64');
        $base64_image = str_replace(' ', '+', $base64);
        //post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)){
            //匹配成功
            $savepath = 'uploads';
            if(input('savepath')){$savepath .= '/'.input('savepath');}
            $path = __DIR__."/../../../public".$savepath;
            if (!file_exists ( $path )) {
                mkdir ( "$path", 0777, true );
            }
            $image_name = date('YmdHis').uniqid().'.'.$result[2];
            $image_file = $path."/{$image_name}";
            //服务器文件存储路径
            if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))){
                $this->response(1,'图片上传成功',DOMAIN.$savepath.$image_name);
            }else{
                $this->response(0,'上传失败');
            }
        }else{
            $this->response(0,'上传失败');
        }
    }
    public function upload($inputname=''){
        // 获取上传文件表单字段名
        if($inputname!=''){
            $fileKey = array_keys(request()->file($inputname));
        }else {
            $fileKey = array_keys(request()->file());
        }
        if (empty($fileKey)) {
            $this->response(0,'请上传图片');
        }
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下

        $savepath = 'uploads';
        if(input('savepath')){$savepath .= '/'.input('savepath');}
//        $path = __DIR__."/../../../public".$savepath;
//        if (!file_exists ( $path )) {
//            mkdir ( "$path", 0777, true );
//        }
        $info = $file->validate(['size'=>$this->size,'ext' => 'jpg,png,gif,jpeg'])->move($savepath);
        if($info){
            $path=str_replace('\\','/',$info->getSaveName());
            $url = DOMAIN.'/'.$savepath.'/'. $path;
            $this->response(1,'图片上传成功',$url);
        }else{
            // 上传失败获取错误信息
            $this->response(0,$file->getError());
        }
    }
    public function file($inputname=''){
        if($inputname!=''){
            $fileKey = array_keys(request()->file($inputname));
        }else {
            $fileKey = array_keys(request()->file());
        }
        if (empty($fileKey)) {
            $this->response(0,'请上传文件');
        }
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $savepath = 'uploads';
        if(input('savepath')){$savepath .= '/'.input('savepath');}
//        $path = __DIR__."/../../../public".$savepath;
//        if (!file_exists ( $path )) {
//            mkdir ( "$path", 0777, true );
//        }
        $info = $file->validate(['size'=>$this->size,'ext' => 'zip,rar,pdf,swf,ppt,psd,ttf,txt,xls,doc,docx'])->move($savepath);
        if($info){
            $result['code'] = 1;
            $result['info'] = '文件上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());

            $result['url'] = DOMAIN.'/'.$savepath.'/'. $path;
            $result['ext'] = $info->getExtension();
            $result['size'] = byte_format($info->getSize(),2);
            return $result;
        }else{
            // 上传失败获取错误信息
            $result['code'] = 0;
            $result['info'] = '文件上传失败!';
            $result['url'] = '';
            return $result;
        }
    }
    //多图上传
    public function upImages($inputname=''){
        if($inputname!=''){
            $fileKey = array_keys(request()->file($inputname));
        }else {
            $fileKey = array_keys(request()->file());
        }
        if (empty($fileKey)) {
            $this->response(0,'请上传');
        }
        $imgarr = [];
        foreach ($fileKey as $item) {
            // 获取表单上传文件
            $file = request()->file($item);
            // 移动到框架应用根目录/public/uploads/ 目录下
            $savepath = 'uploads';
            if (input('savepath')) {
                $savepath .= '/' . input('savepath');
            }
            $info = $file->validate(['size'=>$this->size,'ext' => 'jpg,png,gif,jpeg'])->move($savepath);
            if ($info) {
                $path = str_replace('\\', '/', $info->getSaveName());
                $url = DOMAIN.'/' . $savepath . '/' . $path;
                $imgarr[] = $url;
            }
        }
        $this->response(1,'',$imgarr);
    }
    public function del(){
        if(!$this->postdata['fileurl']){
            $this->response(0,'请选择要删除的文件');
        }
        $path = str_replace(DOMAIN,'',$this->postdata['fileurl']);
        $path = ROOT_PATH.$path;
        if(unlink($path)){
            $this->response(1,'删除成功');
        }else{
            $this->response(0,'删除失败');
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
{

    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initNav();
        $this->load->library('session');
        $this->load->library('Ucloud/Proxy');
        $this->load->model('adprice_model');
        $this->load->model('advertiser_model');
        //$this->load->model('plugin_building_model');
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

    /**
     * 客户数据首页
     */
    public function index()
    {
        $this->layout->view('/ad/ad_index', $this->data);
    }

    /**
     * 数据列表
     */
    public function lists()
    {

        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
        $info = $this->advertiser_model-> adlist($this->user['code'],$limit = $pagesize, $offset = $offset);
        foreach ( $info as $key => &$item) {
            $item['price'] = number_format((floor($item['price']/100)).".".($item['price']%100),2,'.','');
            $item['ad_sumprice'] = number_format((floor($item['ad_sumprice']/100)).".".($item['ad_sumprice']%100),2,'.','');
            $item['cpccpm'] = $item['cpc'] + $item['cpm'];
            $item['pv'] = $item['totalcpc'] + $item['totalcpm'];
           $item['active'] = $item['audit_status'] == 0?"active":"";
           $item['audit_status'] = $item['audit_status'] == 0?"未审核":($item['audit_status'] == 1?"通过审核":"未过审核");
        }
//      var_dump($info); die;
        $total = count($info);
        $this->data['list'] = $info;

        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
        }

        $this->layout->view('/ad/list', $this->data);
    }


    public function add()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method == 'get')
        {
            $this->layout->view('/ad/add', $this->data);
        }
        if($method == 'post'){
//            var_dump($_REQUEST);die;
            if(count($_FILES )>1){
                foreach($_FILES as $fileinfo){
                    if($fileinfo['size'] < 1024000 || ($fileinfo['type'] =="image/png" ||$fileinfo['type']=="image/jpeg" ) ){
                        $status = true;
                    }else{
                        ci_redirect('/ad/index/add', 1, '图片格式或大小不对');
                    }
                }
            }
            //判断上传文件类型为png或jpg且大小不超过1024000B
            if($status)
            {

                $filename1 =date('Y/m/d')."/img/".time().$_FILES["file1"]["name"];
                $filename1 =iconv("UTF-8","gb2312",$filename1);
                $filename2 =date('Y/m/d')."/img/".time().$_FILES["file2"]["name"];
                $filename2 =iconv("UTF-8","gb2312",$filename2);
                $filename3 =date('Y/m/d')."/img/".time().$_FILES["file3"]["name"];
                $filename3 =iconv("UTF-8","gb2312",$filename3);
             $upload_file_url1 = $this->proxy->UploadFiles($filename1,$_FILES["file1"]["tmp_name"]);
             $upload_file_url2 = $this->proxy->UploadFiles($filename2,$_FILES["file2"]["tmp_name"]);
             $upload_file_url3 = $this->proxy->UploadFiles($filename3,$_FILES["file3"]["tmp_name"]);
            }
            //测试阶段可用
            $upload_file_url = '/2018/07/21/img/1532151910bg_lq.png';

            if ( $form = $this->input->post() )
            {
                if($form['platform'] == '01'){
                    $platform = "H5";
                    $link = $form['link1'];
                }
                elseif($form['platform'] == '02'){
                    $platform = "android";
                    $link = $form['link2'];
                }
                else{
                  $platform = "wechat";
                    $link = $form['link3'];
            }
                $data['code'] = md5($this->user['code'].rand(0,10000));
                $data['owner'] = $this->user['code'];
                $data['name'] = trim($form['title']);
                $data['info'] = $form['contact'];
                $data['icon'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url1;
                $data['image'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url2;
                $data['banner'] ="http://osv.ufile.ucloud.com.cn/".$upload_file_url3;
                $data['platform'] = $platform;
                $data['link'] = $link;
                $data['status'] = 1;
                $data['audit_status'] = 0;
                $data['created_time'] = date('Y-m-d H:i:s');
                $data['updated_time'] = date('Y-m-d H:i:s');
                $price['user_code'] = $this->user['code'];
                $price['ad_code'] = $data['code'];
                $price['type'] = 0;
                $price['code'] = md5($this->user['code'].rand(0,10000));
                $price['price'] = $form['price'] * 100;
                $price['status'] = 0;
                $price['created_time'] = date('Y-m-d H:i:s');
                $res1 = $this->advertiser_model->add($data);
                $res2 = $this->adprice_model->add($price);
                if($res1 && $res2){
                    ci_redirect('/ad/index/lists', 3, '添加成功');
                }else{
                    ci_redirect('/ad/index/add', 3, '添加失败');
                }
            }
        }
    }
    /**
     * 图片上传
     */
    public function  setimg(){
        $targetFolder = date('Y/m/d')."/img/"; // Relative to the root
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            $newname =$this->user['code']."_".time();//图片名字
            $fileTypes = array('jpg','jpeg','gif','png','pdf'); // 文件类型
            $fileParts = pathinfo($_FILES['file']['name']);
            $size = getimagesize($tempFile);
            $width = $size[0];
            $height = $size[1];
            if($width>100 || $height>100){
                unlink($tempFile);
                $arr = array('status' => 0,'type' => $type,'msg' => "图片的宽高不符要求!" );
                echo json_encode($arr);
                exit;
            }
            $filename = rtrim($targetFolder). $newname.'.'.$fileParts['extension'];//图片路径
            sleep(2);
            if (in_array($fileParts['extension'],$fileTypes)) {
                $filename =iconv("UTF-8","gb2312",$filename);
                $upload_file_url = $this->proxy->UploadFiles($filename,$_FILES["file"]["tmp_name"]);
                $upload_file_url = 'http://osv.ufile.ucloud.com.cn/'.$upload_file_url;
                $imgInfo['name']=$filename;
                $imgInfo['url'] =$upload_file_url;
                $imgInfo['status'] = 1;
                echo json_encode($imgInfo,true);
            }else{
                $arr = array('status' =>0,'type' => $type,'msg' => "上传文件不符合要求!" );
                echo json_encode($arr);
                exit;
            }
        }
    }
    public function details(){
        $this->layout->view('/ad/detail', $this->data);
    }
    public function edit()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method == 'get')
        {
            if (!$id = $this->input->get('id')) {
                ci_redirect('/ad/index/lists', 3, '参数错误');
            }
            if (!$info = $this->ad_model->findByPk($id)) {
                ci_redirect('/ad/index/lists', 3, '数据错误');
            }
            //var_dump($info);die;
            $citys = $this->house_city_model->findAll();
            $this->data['citys'] = $citys;
            $this->data['info'] = $info;
            $this->data['user_citys'] = explode(',', $info['city']);
            $this->layout->view('/ad/edit', $this->data);
        }
        
        if ($method == 'post')
        {
            $res = array('status'=>false, 'msg'=>'');
            $post = $this->input->post();
            if(!$post['id']){
                $res['msg'] = '参数错误';
                $this->_outputJSON($res);
            }
            if(!$info = $this->ad_model->findByPk($post['id'])){
                $res['msg'] = '数据错误';
                $this->_outputJSON($res);
            }
            if (isset($post['card']) && !empty($post['card']))
            {
                $post['pic_url'] = $post['card'];
                unset($post['card']);
            }
            if (isset($post['logo']) && !empty($post['logo']))
            {
                $post['choice_pic'] = $post['logo'];
                unset($post['logo']);
            }
            if (isset($post['openAd']) && !empty($post['openAd']))
            {
                $post['pic_url_x'] = $post['openAd'];
                unset($post['openAd']);
            }
            $filter = array('link'=>'','title'=>'','type'=>'','place'=>'','valid_start'=>'','valid_end'=>'','citys'=>'','is_choice'=>'','pic_url'=>'','choice_pic'=>'','pic_url_x'=>'');
            $data = array_intersect_key($post,$filter);
            
            $time = time();
            $extra = array('update_time'=>$time,'operator_id'=>$this->user['uid'],'operator_name'=>$this->user['truename']);
            $data = array_merge($data,$extra);
            $data['city'] = $data['citys'];
            unset($data['citys']);
            $data['valid_start'] = strtotime($data['valid_start']);
            $data['valid_end'] = strtotime($data['valid_end'].' 23:59:59');
            //var_dump($this->ad_model->insertData($data));die;
            if ($this->ad_model->edit($post['id'],$data))
            {
                //插入ad_city表
                $this->ad_city_model->deleteAll(array('aid'=>$post['id']));
                $temp_city = explode(',',$data['city']);
                foreach ($temp_city as $v){
                    $this->ad_city_model->insertData(array('aid'=>$post['id'],'city'=>$v));
                }
                $res['status'] = true;
                $this->_outputJSON($res);
            }
            else
            {
                $res['msg'] = '编辑失败';
                $this->_outputJSON($res);
            }
            
        }
    }
    
    public function detail()
    {
        $id = (int)$this->input->get('id');
        $info = $this->ad_model->findByPk($id);
        //print_r($info);die;
        if ($info)
        {
            $info['city'] = $this->_getCityName($info['city']);
            //var_dump($info);die;
            $this->data['info'] = $info;
            $this->layout->view('/ad/detail', $this->data);
        }
        else
            ci_redirect('/ad/', 3, 'ID错误或信息不存在');
    }
    
   
    /**
     * 发布消息
     */
    public function pub()
    {
        $id = $this->input->get_post('id');
        $result = array('status'=>false,'msg'=>'操作失败');
        if ($info = $this->ad_model->findByPk($id))
        {
            $time = time();
            if($time>$info['valid_end']){
                $result['msg'] = '有效期过期，请修改后发布';
                $this->_outputJSON($result);
            }
            if($time<$info['valid_start']){
                $msg= "广告将于".date("Y年m月d日",$info['valid_start'])."展示";
                $status = 5;
            }else{
                $msg= '广告发布成功';
                $status = 2;
            }
            $this->ad_model->updateByPk($id,array('status'=>$status,'pub_time'=>$time,'operator_id'=>$this->user['uid'],'operator_name'=>$this->user['truename']));
            $result['status'] = true; 
            $result['msg'] = $msg;
        }
        $this->_outputJSON($result);
    }

    public function del()
    {
        $id = (int)$this->input->get_post('id');
        $result = array('status'=>false,'msg'=>'操作失败');
        if ($info = $this->ad_model->findByPk($id))
        {
            if ($info['status'] != 1)
            {
                $result['msg'] = '只有未发布状态才可以删除';
            }
            else
            {
                $data['status'] = -1;
                $data['operator_id'] = $this->user['uid'];
                $data['operator_name'] = $this->user['truename'];
                if ($this->ad_model->updateByPk($info['id'],$data))
                {
                    $result['msg'] = '删除成功';
                    $result['status'] = true;
                }
                else
                {
                    $result['msg'] = '删除失败';
                }
            }
            
        }
        else
        {
            $result['msg'] = '数据不存在';
        }
        
        $this->_outputJSON($result);
    }
    
    public function down()
    {
        $id = (int)$this->input->get_post('id');
        $result = array('status'=>false,'msg'=>'操作失败');
        if ($info = $this->ad_model->findByPk($id))
        {
            if (($info['status'] == 2) || ($info['status'] == 5))
            {
                
                $data['status'] = 3;
                $data['operator_id'] = $this->user['uid'];
                $data['operator_name'] = $this->user['truename'];
                $data['down_time'] = time();
                if ($this->ad_model->updateByPk($info['id'],$data))
                {
                    $result['msg'] = '下架成功';
                    $result['status'] = true;
                }
                else
                {
                    $result['msg'] = '下架失败';
                }
            }
            else
            {
                $result['msg'] = '只有已发布/未开始状态才可以下架';
            }
            
        }
        else
        {
            $result['msg'] = '数据不存在';
        }
        
        $this->_outputJSON($result);
    }
    
    /**
     * 置业顾问排序操作
     */
    public function upsort() {
        $data = $this->input->post();
        $res = array('status' => false, 'msg' => '');
        $id = (int) $data['id'];
        $sort = $data['new_sort'];
        if (!$zygwInfo = $this->ad_model->findByPk($id)) {
            $res['msg'] = '广告不存在';
            $this->_outputJSON($res);
        }

        if ($sort >= 1000 || $sort < 0) {
            $res['msg'] = '请输入0-999之间的排序';
            $this->_outputJSON($res);
        }
        
        if ($zygwInfo['sort'] == $sort) {
            $res['status'] = true;
            $this->_outputJSON($res);
            exit;
        }
        $r = $this->ad_model->updateByPk($id, array('sort' => $sort));
        if($r){
            $res['status'] = true;
        }    
        $this->_outputJSON($res);
    }
    
}


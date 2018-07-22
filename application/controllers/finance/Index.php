<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {
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
        $this->load->model('audit_model');
		$this->load->model('invoice_model');
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        if ( $method == 'lists' ) 
        {
            $nav[] = array('name' => '财务', 'url' => '');
        }
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

	public function lists()
	{
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
        $urlParam   = $this->_generalUrl($validData);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		$where ='1 = 1 ANd id>0 AND subject=1';
        $total = $this->audit_model->getCount($where);
        $list = $this->audit_model->findAlls($where,$pagesize,$offset);
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		//分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
        }
		$this->layout->view('/finance/list', $this->data);
	} 
	public function invoice()
	{
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
        $urlParam   = $this->_generalUrl($validData);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		$where = $this->audit_model->conditions($search);
        $total = $this->audit_model->getInvoiceCount($where);
        $list = $this->audit_model->findInvoice($where,$pagesize,$offset);
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		//分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['page'] = page($query_str, $total, $pagesize);
	
        }
		$this->layout->view('/finance/invoice', $this->data);
	} 
	public function present()
	{
       $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
        $urlParam   = $this->_generalUrl($validData);
       $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		$where ='1 = 1 ANd id>0 AND subject=0';
        $total = $this->audit_model->getCount($where);
        $list = $this->audit_model->findAlls($where,$pagesize,$offset);
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		//分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
        }
		$this->layout->view('/finance/present', $this->data);
	} 

    /**
     * 添加
     */
    public function add()
    {
        $input = array_merge($this->input->get(), $this->input->post());
		if($input){
			$update['code'] = strtoupper(md5($input['tradid'].time()));
			$update['operator'] = $this->user['code'];
			$update['owner'] = $input['owner'];
			$update['money'] =$input['money']*100;//转化分
			$update['subject']=1;
            $update['bank'] = $input['bank'];
            $update['cardid'] = $input['cardid'];
            $update['tradid'] = $input['tradid'];
			$update['status'] = $input['status']?$input['status']:0;
			$update['comment'] = $input['comment'];
            $update['created_time'] = date("Y-m-d H:i:s");
            $update_info = $this->audit_model->add($update);
            if ($update_info) {
                ci_redirect('/finance/index/lists', 3, '添加成功');
            }
            exit;
		}
		$list = $this->audit_model->getUserCode($where=' 1=1 AND type!=2',$pagesize,$offset);
		$this->data['list'] = $list;
		$this->layout->view('/finance/add', $this->data);
    }
public function listrecord(){
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
        $info = $this->audit_model->getList(
            $where = array(
                'owner'=>$this->user['code'],
                'subject'=>1,
            ),
                $limit = $pagesize,
                $offset = $offset,
                $sort = 'created_time');
        foreach ( $info['list']as &$item) {
            $item['created_time'] = date('Y-m-d',strtotime($item['created_time']));
            $item['money'] = number_format($item['money'],2,'.','');
            switch($item['status']){
                case 0: $item['status'] = '充值成功';
                    break;
                case 1: $item['status'] = '未充值';
                    break;
                default:
            }
        }
        $total = $info['cnt'];
        $this->data['list'] = $info['list'];
        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['page'] = page($query_str, $total, $pagesize);

        }
        $this->layout->view('/finance/listrecord', $this->data);
    }
    public function adinvoice(){
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
        $info = $this->invoice_model-> getList($where = array('owner'=>$this->user['code']),$limit = $pagesize, $offset = $offset, $sort = 'created_time');
        foreach ( $info['list']as &$item) {
            $item['created_time'] = date('Y-m-d',strtotime($item['created_time']));
            $item['money'] = number_format($item['money'],2,'.','');
        }
        $total = $info['cnt'];
        $this->data['list'] = $info['list'];
        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['page'] = page($query_str, $total, $pagesize);

        }
        $this->layout->view('/finance/adinvoice', $this->data);
    }
    /**
     *
     */
    public function add_adinvoice(){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method == 'post'){
            $post = $this->input->post();
            $arr['code'] = gen_pwd($post['invoiceid']);
            $arr['owner'] = $this->user['code'];
            $arr['title'] = $post['title'];
            $arr['taxid'] = $post['invoiceid'];
            $arr['money'] = $post['amount'];
            $arr['comment'] = $post['contact'];
            $arr['status'] = 0;
            $arr['created_time'] = date('Y-m-d H:i:s',time());
            $arr['updated_time'] = date('Y-m-d H:i:s',time());
            $res = $this->invoice_model->add($arr);
            if($res){
                ci_redirect('/finance/index/adinvoice', 3, '添加成功');
            }

        }else{
            $this->layout->view('/finance/add_adinvoice', $this->data);
        }
    }
    
    
    
  
   

    protected function _getConditions(& $data)
    {
        $where = array();
        $filters = array('time_type', 'city_en', 'date_start', 'date_end'); // 跳过
        foreach ($data as $k=>$v)
        {
            if ( $k == 'username' ) {
                $where['zygw.username like'] = "%{$v}%";
            } else if ( $k == 'role' ) {
                $v && $where['zygw.role ='] = $v;
            } else if ( $k == 'status' ) {
                $v && $where['zygw.status ='] = $v;
            } else if ( in_array($k, $filters) ) {
                continue;
            } else {
                $where["zygw.{$k} ="] = $v;
            }
        }
        // echo 'data:' . var_export($data, true);
        if (isset($data['date_start']) && $data['date_start']) {
            $where['zygw.create_time >'] = strtotime($data['date_start']);
        } else {
            $data['date_start'] = date('Y-m-d', strtotime('-30 day'));// 默认前一天
            $where['zygw.create_time >'] = strtotime($data['date_start']);
        }

        if (isset($data['date_end']) && $data['date_end']) {
            $where['zygw.create_time <='] = strtotime($data['date_end']) +3600*24;
        } else {
            $data['date_end'] = date('Y-m-d', time());
            $where['zygw.create_time <='] = strtotime($data['date_end']) + 3600*24;
        }

        if (isset($data['city_en']) && $data['city_en']) {
            $where['zygw.city_en ='] = $data['city_en'];
        } else {
            if (!empty($this->user['city_rights'])) {
                $citys = explode(',', $this->user['city_rights']);
                $citys = "'" . implode("','", $citys) . "'";
                $where["zygw.city_en in ({$citys}) AND "] = "1";
                // $where['city'] = "`city` in ('$citys')";
            } else {
                $where['zygw.city_en ='] = '-1';// 无城市权限
            }
        }
        //不展示删除的数据
        $where['zygw.status != '] = '6';
        return $where;
    }



}
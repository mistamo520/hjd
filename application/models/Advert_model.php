<?php
/**
 * 流量主 model
 * @package models.audit
 * @since 1.0
 */
class Advert_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
	public $wy_user = 'user';
	public $wy_ad = 'ad';
	public $wy_ad_price = 'ad_price';
    public $primaryKey = 'id';

    /**
     * 构造方法
     *
     * @return void
     */
    public function __construct()
    {
		$this->wy_user = $this->db->dbprefix.$this->wy_user;
		$this->wy_ad = $this->db->dbprefix.$this->wy_ad;
		$this->wy_ad_price = $this->db->dbprefix.$this->wy_ad_price;
        parent::__construct();
    }
    /**
     * Find Record By Attributes
     *
     * @param array $where
     * @return array
     */
    public function findByAttributes($where = array(), $order = '')
    {
        return parent::findByAttributes($where, $order);
    }
    public function findAlls($where = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
	   $sql = "SELECT c.id, c.`code`,c.`name`,c.owner,c.ws_code,c.appid,c.status ,c.audit_status ,IF(b.type=0,IF(b.st_price>0,COUNT(1),0),0) cpc,IF(b.type=1,IF(b.st_price>0,COUNT(1),0),0) cpm,IF(b.type=0,COUNT(1),0) totalcpc,IF(b.st_price>0,SUM(b.st_price),0) st_price,IF(b.ad_price>0,SUM(b.ad_price),0) ad_price FROM `wy_ad` AS `c` LEFT JOIN `wy_ad_order` AS `b` ON `c`.`code` = `b`.`ad_code` WHERE 1 = 1 AND c.id > 0 GROUP BY
	`c`.`code` ORDER BY c.created_time DESC limit $offset,$limit";
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }
	//获取广告数
	public function getCount($where)
    {
        $sql = "select count(DISTINCT `code`) as total from  ".$this->wy_ad." where $where limit 1";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
    }
	//获取流量主广告数
	public function getAdCount($where){
		$sql = "select count(1) as total from ".$this->wy_ad." where 1 = 1 ANd id>0 limit 1";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
	}
	//获取消费金额数
	public function getConsume($where){
		$sql = "SELECT IF(b.type=0,IF(b.st_price>0,COUNT(1),0),0) cpc,IF(b.type=1,IF(b.st_price>0,COUNT(1),0),0) cpm,IF(b.type=0,COUNT(1),0) totalcpc,IF(b.st_price>0,SUM(b.st_price),0) st_price FROM `".$this->db->dbprefix."ad_order` AS `b` ";
        $row = $this->db->query($sql)->result_array();
	    return $row[0];
	}
	//获取CMP价格
	public function getCpm($where){
		$cpwhere = " ad_code='".$where['code']."' AND user_code='".$where['owner']."' AND type=1 ";
		$sql = "select id,price as cmp_price  from ".$this->wy_ad_price." where $cpwhere AND id>0 order by id desc";
        $row = $this->db->query($sql)->result_array();
	    return $row[0];
	}
	//组建where查询
    public function conditions($data)
    {
		$where ='1 = 1 ANd id>0';
        if (!empty($data))
        {
		    //用户申请手机号
		   if($data['type']){
				$where.=" AND type =".$data['type'];
		   }
        }
        return $where;
    }
	
	/**
     * 添加
     */
    function add($data)
    {
        return $this->insertData($data);
    }

    /**
     * 编辑
     */
    function edit($id, $data)
    {
        return $this->updateByPk($id,$data);
    }
	
}

 
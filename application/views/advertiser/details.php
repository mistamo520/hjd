<div class="postnav">广告主 - <span class="">广告主详情</span></div>
	<div class="layuibodycont">
		
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdlsep25 topitemdlsepfirst">
				<dd><span class="">账号：</span>18600546906<a href="公司资质.html">查看资质</a></dd>
				<dd><span class="">邮箱：</span>18600546906</dd>
			</dl>
			<dl class="topitemdl topitemdlsep25">
				<dd>广告数量</dd>
				<dt>30个</dt>
			</dl>
			<dl class="topitemdl topitemdlsep25">
				<dd>充值总额(元)</dd>
				<dt>￥33040.10</dt>
			</dl>
			<dl class="topitemdl topitemdlsep25 noborder">
				<dd>余额总额(元)</dd>
				<dt>￥60040.30</dt>
			</dl>
		</div>
		<div class="clearfix" style="margin-top:20px">
			<div class="countitem fl">
				<div class="countnav"><p class="fl countleft"><i><img src="images/icon04.png"></i><span>广告推广量</span></p>
				<span class="fr countright">均价<i class="">￥0.3</i></span></div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
			<div class="countitem fr">
				<div class="countnav"><p class="fl countleft"><i><img src="images/icon02.png"></i><span>近七天消耗金额</span></p>
				</div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart2" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>广告名称</th>
				  <th>曝光量</th>
				  <th>点击量</th>
				  <th>点击率</th>
				  <th>点击均价</th>
				  <th>CMP(千人展示价)</th>
				  <th>消耗</th>
				  <th>SDK</th>
				  <th>状态</th>
				  <th>操作</th>
				</tr> 
			  </thead>
			  <tbody>
				<tr>
				  <td>米加小程序</td>
				  <td>32654</td>
				  <td>1354</td>
				  <td>35%</td>
				  <td>￥4.5</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="0" class="editput" disabled=""></span></td>
				  <td>￥0.00</td>
				  <td><a href="绑定SDK.html"><span class="tdobtn01 active">绑定</span></a></td>
				  <td><a href="page-1-运营平台2广告主_4广告审核1.html"><span class="tdstatus active">待审核</span></a></td>
				  <td><span class="tdoper02">未投放</span></td>
				</tr>
				<tr>
				  <td>米加小程序</td>
				  <td>32654</td>
				  <td>1354</td>
				  <td>35%</td>
				  <td>￥4.5</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="0" class="editput" disabled=""></span></td>
				  <td>￥0.00</td>
				  <td><span class="tdobtn01">小玩家</span></td>
				  <td><a href="page-1-运营平台2广告主_4广告审核3展示.html"><span class="tdstatus">通过审核</span></a></td>
				  <td><span class="tdoper02 active aduseroper">撤下</span></td>
				</tr>
				<tr>
				  <td>米加小程序</td>
				  <td>32654</td>
				  <td>1354</td>
				  <td>35%</td>
				  <td>￥4.5</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="0" class="editput" disabled=""></span></td>
				  <td>￥0.00</td>
				  <td><span class="tdobtn01">小玩家</span></td>
				  <td><a href="page-1-运营平台2广告主_4广告审核3展示.html"><span class="tdstatus">通过审核</span></a></td>
				  <td><span class="tdoper02">未投放</span></td>
				</tr>
			  </tbody>
			</table>
		</div>
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->

</div>
 <div class="selectgoodsbox tx" id="layer03">
	<div class="adopearbox">您确定要撤下此广告吗？</div>
</div>
<div class="selectgoodsbox tx" id="layer04">
   <div class="">
		<p class="editprice">编辑价格</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label">价格：</label>
					<div class="layui-input-block" >
					  <span>￥</span><input type="text" name="title" placeholder="请输入新的价格" class="layui-input">
					</div>
				  </div>
			 </form>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/detect-report.js"></script>
<script type="text/javascript" src="js/echarts.common.min.js"></script>

<script>
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
	$(document).on("click",".aduseroper",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer03')
			,success: function(layero){
			  //成功输出内容
			  console.log(11);
			}
		});
	});
	$(document).on("click",".editjs",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '230px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer04')
			,success: function(layero){
			  //成功输出内容
			  console.log(11);
			}
		});
	});
});

// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('report-chart'));
var myChart2 = echarts.init(document.getElementById('report-chart2'));

// 指定图表的配置项和数据
var option = {
    title : {
       // text: '某楼盘销售情况',
       // subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['展示','点击']
    },
    toolbox: {
        feature: {
           // saveAsImage: {}//将统计图保存为
        }
        ,right:100
        ,top:0
    },
	grid: {
        left: '3%',
        right: '4%',
        bottom: '9%',
        containLabel: true
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['周一','周二','周三','周四','周五','周六','周日']
        }
    ],
    yAxis: {
		'name':'(个)',
        type: 'value'
    },
    series : [
        {
            name:'展示',
            type:'line',
           // smooth:true,
            itemStyle: {normal: {areaStyle: {type: 'default'},label : {
								show:true,
								position:'top',
								formatter:'{c}'
							},
							areaStyle:{
								color:new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ 
									offset: 0,
									color: '#afeff3'
								}, {
									offset: .34,
									color: '#dcf8fa'
								},{
									offset: 1,
									color: '#fff'
								}])
							},
							color:'#2cc6ad'}},
            data:[10, 12, 21, 54, 260, 830, 710]
        },
        {
            name:'点击',
            type:'line',
           // smooth:true,
			itemStyle: {normal: {
			areaStyle: {type: 'default'},
			label : {show:true,position:'top',formatter:'{c}'},
			areaStyle:{
								color:new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ 
									offset: 0,
									color: '#ffd280'
								}, {
									offset: .34,
									color: '#ffe7ba'
								},{
									offset: 1,
									color: '#fff'
								}])
							},color:'#ffc400'
			}},
            data:[30, 182, 434, 791, 390, 30, 10]
        }
    ]
};
// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);

var option2 = {
    title : {
       // text: '某楼盘销售情况',
       // subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['金额',]
    },
    toolbox: {
        feature: {
           // saveAsImage: {}//将统计图保存为
        }
        ,right:100
        ,top:0
    },
	grid: {
        left: '2%',
        right: '3%',
        bottom: '9%',
        containLabel: true
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['周一','周二','周三','周四','周五','周六','周日']
        }
    ],
    yAxis: {
		'name':'(元)',
        type: 'value'
    },
    series : [
        {
            name:'金额',
            type:'line',
            itemStyle: {normal: {
			areaStyle: {type: 'default'},
			label : {show:true,position:'top',formatter:'{c}'},
			areaStyle:{
								color:new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ 
									offset: 0,
									color: '#afeff3'
								}, {
									offset: .34,
									color: '#dcf8fa'
								},{
									offset: 1,
									color: '#fff'
								}])
							},color:'#2cc6ad'
			}},
            stack: '总量',
            data:[120, 132, 101, 134, 90, 230, 210]

        }
    ]
}; 
// 使用刚指定的配置项和数据显示图表。
myChart2.setOption(option2); 
window.addEventListener("resize", function () {
    myChart.resize();
	myChart2.resize();
});  


</script>
<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form compform" method="post" action='/myad/index/add'  enctype="multipart/form-data">
				<p class="formtitle">新建广告位</p>
				  <div class="layui-form-item">
					<label class="layui-form-label">平台：</label>
					<div class="layui-input-block">
					  <input type="radio" name="platform" value="1" title="H5" checked=""/>
					  <input type="radio" name="platform" value="2" title="android apk" />
					  <input type="radio" name="platform" value="3" title="小程序" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">标题：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  id="slot_title"  placeholder="" class="layui-input" lay-verify="required"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">回调地址：</label>
					<div class="layui-input-block">
					  <input type="text" name="callback"  id="callback"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">是否回调：</label>
					<div class="layui-input-block">
					  <input type="radio" name="callback_status" value="0" title="不支持回调" checked=""/>
					  <input type="radio" name="callback_status" value="" title="支持回调" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">接口签名：</label>
					<div class="layui-input-block">
					  <input type="text" name="secret"  id="appsign"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">简介：</label>
					<div class="layui-input-block">
					  <input type="text" name=desc id="slot_text" placeholder="" class="layui-input" lay-verify="required|contact" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">icon：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper iconfiles">
						<input type="button" class="file_btn" value="">
						<input type="file" class="file-input" name='file' value="" lay-verify="required" >
						<!--<img src="images/dot003.png" class="">-->
					  </div>
					  <span class="addfilespro grayfont">建议上传100*100像素的图片</span>
					</div>
				  </div>
				 <!-- <div class="layui-form-item">
					<label class="layui-form-label">点击单价：</label>
					<div class="layui-input-block">
					  <input type="text" name="title" placeholder="" value="0.50" class="layui-input putprice">
					</div>
				  </div>-->
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1">保存</button>
					</div>
				  </div>
			</form>
		</div>
   
    </div>
    
    
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="layui/layui.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script>
    layui.use(['laypage', 'layer'], function(){
      var laypage = layui.laypage
      ,layer = layui.layer;
      //总页数低于页码总数
      laypage.render({
        elem: 'demo0'
        ,count: 50 //数据总数
      });
      });
  </script>
<script>  
layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form
  ,layer = layui.layer  
  ,layedit = layui.layedit  
  ,laydate = layui.laydate; 
  //自定义验证规则  
  form.verify({  
        title: function(value){ 
          if(value.length < 2){  
            return '标题至少得2个字符';  
          }  
        },
//          fname: function(value){  
//           if(value.length < 4){  
//             return '请输入至少4位的用户名';  
//           }  
//         }, 
        contact: function(value){  
          if(value.length < 4){  
            return '内容请输入至少4个字符';  
          }  
        }  
//         ,phone: [/^1[3|4|5|7|8]\d{9}$/, '手机必须11位，只能是数字！']  
//         ,email: [/^[a-z0-9._%-]+@([a-z0-9-]+\.)+[a-z]{2,4}$|^1[3|4|5|7|8]\d{9}$/, '邮箱格式不对']  
  });
  //监听提交  
  form.on('submit(demo1)', function(data){  
	  return true;
//     layer.alert(JSON.stringify(data.field), {  
//       title: '最终的提交信息'  
//     })  
//     return false;  
  });  


});  
</script>  
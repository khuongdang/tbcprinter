<?

$arrMenu = array(

	array(

		'Danh mục sản phẩm',

		'Danh mục sản phẩm_$_./?act=product_category',

		'Sản phẩm_$_./?act=product',

		'Sản phẩm mới_$_./?act=product_new',

		'Sản phẩm đặt bán chạy_$_./?act=product_special',

		),	

	array(

		'Danh mục Nội dung',

		'Hỗ trợ trực tuyến(YAOO)_$_./?act=yahoo',	

		'Quảng cáo trái_$_./?act=advleft',													

		'Liên hệ_$_./?act=contact',

	),	

	array(

		'Danh mục Tin tức',		

		'Quảng cáo trang chủ_$_./?act=banner',

		'Giới thiệu_$_./?act=intro',

		'Tin tức_$_./?act=news',

	),

	array(

		'+ Danh sách đơn hàng',

		'- Đơn hàng_$_./?act=order',

	),

	array(

		'+ Download',

		'- Danh mục download_$_./?act=baohanh_category',

		'- Tài liệu download_$_./?act=baohanh',

	),	

	array(

		'Danh mục Thành viên',		

		'Thành viên_$_./?act=member',		

	),			

	array(

		'Hệ thống',

		'Cấu hình_$_./?act=config',

		'Đổi mật khẩu_$_./?act=changepass',

		'Thoát_$_./?act=logout',

	),

);



for($i=0;$i<count($arrMenu);$i++){?>

<table border="1" bordercolor="#0069A8" style="border-collapse: collapse" width="161" cellpadding="0">

	<tr>

		<td width="161" height="20" bgcolor="#0069A8" class="title">

			&nbsp;<font style="font-weight: 700" color="#FFFFFF"><?=$arrMenu[$i][0]?></font>

		</td>

	</tr>

	<?

	for($j=1;$j<count($arrMenu[$i]);$j++){

		$arr = explode('_$_',$arrMenu[$i][$j]);

	?>

	<tr>

		<td width="161" height="25" class="normalfont" style="border-bottom-color:#CCCCCC">

			<?
			$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
			if(substr($arr[1],7)!=$act){?>

				&nbsp;&nbsp;&nbsp;<a href="<?=$arr[1]?>"><?=$arr[0]?></a>

			<? }else{?>

				&nbsp;&nbsp;&nbsp;<a href="<?=$arr[1]?>"><font color="#CC0000"><?=$arr[0]?></font></a>

			<? }?>

		</td>

	</tr>

	<? }?>

</table>

<? }?>
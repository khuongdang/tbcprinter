<?php
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
switch ($act){
	//-------------------------------------------------------------------------------------------
	case "product_category"   : $title = 'Danh mục sản phẩm';break;
	case "product_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục sản phẩm';break;
	case "product"  		  : $title = 'Sản phẩm';break;
	case "product_m" 		  : $title = 'Hiệu chỉnh / Cập nhật : Sản phẩm';break;	
	case "product_new" 		  : $title = 'Sản phẩm mới';break;
	case "product_new_m"	  : $title = 'Hiệu chỉnh / Cập nhật : Sản phẩm mới';break;	
	case "product_special"	  : $title = 'Sản phẩm khuyến mãi';break;
	case "product_special_m"  : $title = 'Hiệu chỉnh / Cập nhật : Sản phẩm khuyến mãi';break;		
	//-------------------------------------Content----------------------------------------------
	case "intro"              : $title = 'Giới thiệu';break;
	case "intro_m"            : $title = 'Hiệu chỉnh / Cập nhật : Giới thiệu';break;
	case "contact"            : $title = 'Liên hệ';break;
	case "contact_m"          : $title = 'Hiệu chỉnh / Cập nhật : Liên hệ';break;
	case "service"            : $title = 'Dịch vụ';break;
	case "service_m"          : $title = 'Hiệu chỉnh / Cập nhật : Dịch vụ';break;
	//-------------------------Tin tức & Sự kiện-------------------------------------------------
	case "news"               : $title = 'Tin tức';break;
	case "news_m"             : $title = 'Hiệu chỉnh / Cập nhật : Tin tức';break;
	//------------------------Customer-----------------------------------------------------------	
	case "customer"           : $title = 'Khách hàng';break;
	case "customer_m"         : $title = 'Hiệu chỉnh / Cập nhật : Khách hàng';break;
	//------------------------Advertise----------------------------------------------------------
	case "advleft"            : $title = 'Quảng cáo trái';break;
	case "advleft_m"          : $title = 'Hiệu chỉnh / Cập nhật : Quảng cáo trái';break;
	case "advright"           : $title = 'Quảng cáo phải';break;
	case "advright_m"         : $title = 'Hiệu chỉnh / Cập nhật : Quảng cáo phải';break;
	//---------------------------Hỗ trợ trực tuyến-----------------------------------------------
	case "yahoo"              : $title = 'Hỗ trợ trực tuyến (Yahoo)';break;
	case "yahoo_m"            : $title = 'Hiệu chỉnh / Cập nhật : Hỗ trợ trực tuyến (Yahoo)';break;
	//----------------------------Thành viên & Đơn hàng------------------------------------------	
	case "member"             : $title = 'Thành viên';break;
	case "member_m"           : $title = 'Thêm mới / Cập nhật : Thành viên';break;
	case "order"              : $title = 'Đơn hàng';break;
	case "order_detail"       : $title = 'Chi tiết : Đơn hàng';break;	
	//----------------------------danh mục hệ thống-----------------------------------------------
	case "config"             : $title = 'Cấu hình';break;
	case "config_m"           : $title = 'Cấu hình : Cập nhật';break;
	case "changepass"         : $title = 'Đổi mật khẩu';break;
	//--------------------------------------------------------------------------------------------
	case "baohanh_category" : $title = 'Download : <b> <a href="./?act=baohanh_category_m&page='.$_REQUEST['page'].'&cat='         .$_REQUEST['cat'].'"><font color="#FFFFFF">Nhập mới</font></a></b>';break;
	case "baohanh_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục giải đáp';break;
	
	case "baohanh" : $title = 'Download : <a href="./?act=baohanh_m&page='.$page.'&cat='.$_REQUEST['cat'].'"><font color="#ffffff">          Nhập mới</font></a>';break;
	case "baohanh_m" : $title = 'Hiệu chỉnh / Cập nhật : Giải đáp';break;	
	
	default                   : $title = 'Thông kê truy cập';break;
}
echo $title;
?>
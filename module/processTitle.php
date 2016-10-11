<?
$frame = isset($_REQUEST['frame']) ? $_REQUEST['frame'] : '';
switch ($frame){

	case "product" :
		$cat = 0;
		if (isset($_REQUEST['cat']) && $_REQUEST['cat']!= '') $cat = killInjection($_REQUEST['cat']);
		$catInfo = getRecord("tbl_product_category","id=".$cat);
		$title = $catInfo['name'];
		break;	
	case "products" :
		$catparent = 0;
		if (isset($_REQUEST['catparent']) && $_REQUEST['catparent']!= '') $catparent = killInjection($_REQUEST['catparent']);
		$catInfo = getRecord("tbl_product_category","id=".$catparent);
		$title = $catInfo['name'];
		break;				
	case "product_detail" : $title = $_lang=="vn" ? "THÔNG TIN CHI TIẾT" : "PRODUCT DETAIL";break;														
	
	//--------------------------------------------------------------------------------------------
	case "product_s"        : $title = $_lang=="vn" ? "SẢN PHẨM MỚI" : "PRODUCTS";break;
	case "cart"    		   : $title = $_lang=="vn" ? "GIỎ HÀNG" : "CART";	break;
	case "customer" 	   : $title = $_lang=="vn" ? "Khách hàng" : "Khách hàng";	break;
	case "contact"         : $title = $_lang=="vn" ? "LIÊN HỆ" : "CONTACT";	break;
	case "intro"           : $title = $_lang=="vn" ? "GIỚI THIỆU" : "INTRODUCTION";break;
	case "news"            : $title = $_lang=="vn" ? "TIN TỨC & SỰ KIỆN" : "NEWS & EVENT";break;
	case "news_detail"     : $title = $_lang=="vn" ? "THÔNG TIN CHI TIẾT" : "NEWS DETAIL";break;
	case "service" 		   : $title = $_lang=="vn" ? "Dịch vụ" : "Service";break;
	
	case "search"          : $title = $_lang=="vn" ? "KẾT QUẢ TÌM KIẾM" : "RETURN SEARCH";break;
	case "registry"        : $title = $_lang=="vn" ? "Đăng ký thành viên" : "REGISTRY";break;
	case "member"          : $title = $_lang=="vn" ? "Thành viên" : "LOGIN";break;
	case "login"           : $title = $_lang=="vn" ? "Ðăng nhập" : "LOGIN";break;
	case "forgotpass"      : $title = $_lang=="vn" ? "Quên mật khẩu" : "Forgot password";break;
	case "download"        : $title = $_lang=="vn" ? "HỖ TRỢ KỸ THUẬT" : "DOWNLOAD";break;
	case "download_view"   : $title = $_lang=="vn" ? "HỖ TRỢ KỸ THUẬT" : "DOWNLOAD";break;
	case "download_detail" : $title = $_lang=="vn" ? "HỖ TRỢ KỸ THUẬT" : "DOWNLOAD";break;
	
	case "changepassword"  : $title = $_lang=="vn" ? "Đổi mật khẩu" : "Change password";break;		
	
	case "home"            : $title = $_lang=="vn" ? "SẢN PHẨM MỚI" : "New product";break;
	default                : $title = $_lang=="vn" ? "SẢN PHẨM MỚI" : "New product";break;

}
echo $title;
?>

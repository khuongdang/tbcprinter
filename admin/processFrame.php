<?
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
switch ($act){

	//Product_category------------------------------------------------------------------
	
	case "product_category"    : include("product_category.php");break;
	case "product_category_m"  : include("product_category_m.php");break;
	case "product"             : include("product.php");break;
	case "product_m"           : include("product_m.php");break;
	case "product_new"         : include("product_new.php");break;
	case "product_new_m"       : include("product_new_m.php");break;
	case "product_special"     : include("product_special.php");break;
	case "product_special_m"   : include("product_special_m.php");break;	
	
	case "baohanh_category"    : include("baohanh_category.php"); break;
	case "baohanh_category_m"  : include("baohanh_category_m.php"); break;
	case "baohanh"             : include("baohanh.php"); break;
	case "baohanh_m"           : include("baohanh_m.php"); break;		
	//---------------------Support Online------------------------------------------------
	case "yahoo"       	  : include("content_yahoo.php");break;
	case "yahoo_m"    	  : include("content_yahoo_m.php");break;
	//---------------------Advertise-----------------------------------------------------
	case "advleft"     	  : include("content_advleft.php");break;
	case "advleft_m"  	  : include("content_advleft_m.php");break;
	case "advright"       : include("content_advright.php");break;
	case "advright_m"  	  : include("content_advright_m.php");break;	
	//mục home--- -----------------------------------------------------------------------	
	case "intro"       	  : include("content_intro.php");break;
	case "intro_m"    	  : include("content_intro_m.php");break;
	
	case "banner"         : include("content_banner.php");break;
	case "banner_m"    	  : include("content_banner_m.php");break;

	case "service"	 	  : include("content_single.php");break;
	case "service_m"	  : include("content_single_m.php");break;
			
	case "contact"        : include("content_contact.php");break;
	case "contact_m"      : include("content_contact_m.php");break;
	//-------------------------News------------------------------------------------------		
	case "news"		      : include("content_news.php");break;
	case "news_m"   	  : include("content_news_m.php");break;					
	//---------------------Member--------------------------------------------------------
	case "member"         : include("member.php");break;
	case "member_m"       : include("member_m.php");break;
	case "order"          : include("order.php");break;
	case "order_detail"   : include("order_detail.php");break;
	
	case "download"            : include("content_download.php");break;
	case "download_m"          : include("content_download_m.php");break;
	
	//------------------------------------------------------------------------------------
	case "config"         : include("config.php");break;
	case "config_m"       : include("config_m.php");break;
	case "changepass"     : include("changePassword.php");break;
	case "login"          : include("login.php");break;
	case "logout" :
		unset($_SESSION['log']);
		echo "<script>window.location='./?frame=home'</sc"."ript>";
		break;
	
	//--------------------------------------------------------------------------------------
	
	case "home"          : include("home.php");break;
	default              : include("home.php");break;
}
?>
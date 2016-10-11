<?php if(!session_id()); session_start();

require("config.php");

require("common_start.php");

require("lib/func.lib.php");

$_lang="vn";

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>TBC Computer</title>

<link href="css/style.css" rel="stylesheet" type="text/css">

<script language="javascript" src="lib/varAlert.<?php echo $_lang;?>.unicode.js"></script>

<script language="javascript" src="lib/javascript.lib.js"></script>

<script src="js/boxover.js" type="text/javascript" language="javascript"></script>

<script language="javascript">

function btnSearch_onclick(){

	if(test_empty(document.frmSearch.keyword.value)){

		alert(mustInput_Search);document.frmSearch.keyword.focus();return false;

	}

	document.frmSearch.submit();

	return true;

}



</script>

</head>



<body>

<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td height="101" colspan="2" background="images/banner.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="20%" rowspan="3" align="center" valign="middle"><a href="./"><img src="images/logo.jpg" width="90" height="78" border="0"></a></td>

        <td width="49%" rowspan="3" align="center" valign="middle"><?php include("module/search_list.php")?></td>

        <td width="31%">&nbsp;</td>

      </tr>

      <tr>

        <td align="center">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td width="34%" rowspan="2" align="right"><img src="images/giohang.gif" width="26" height="23" /></td>

                    <td width="66%" height="20" align="left" class="font_xam" style="padding-left:12px"><a href="./?frame=cart" class="link_menu_sp"> xem giỏ hàng </a></td>

                  </tr>

				  		<?php if(!isset($_SESSION['cart']))

							{

							unset($_SESSION['soluong']);

							$soluong=0;

							}

							else

							{

							 $soluong=$_SESSION['soluong'];

							}

							?>

                  <tr>

                    <td align="left" class="font_blue"> giỏ hàng có : <?php echo $soluong;?> sản phẩm </td>

                  </tr>

            </table>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td valign="top"  bgcolor="#333333" style="border-bottom:1px solid #CCCCCC"><img src="images/bg_left_home.jpg" width="190" height="3"></td>

    <td height="35" valign="top"  bgcolor="#333333" style="border-bottom:1px solid #CCCCCC">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="16%" height="35" align="center" onMouseOver="this.className='left_menu_bg_hover'" onMouseOut="this.className='left_menu_bg_over'" class="font_menu_while" style="border-right:1px solid #CCCCCC; border-left:1px solid #CCCCCC" ><a href="./" class="link_menu">TRANG CH&#7910;</a></td>

        <td width="15%" align="center" onMouseOver="this.className='left_menu_bg_hover'" onMouseOut="this.className='left_menu_bg_over'" class="font_menu_while" style="border-right:1px solid #CCCCCC"><a href="./?frame=intro" class="link_menu">GIỚI THIỆU</a> </td>

        <td width="15%" align="center" class="font_menu_while" onMouseOver="this.className='left_menu_bg_hover'" onMouseOut="this.className='left_menu_bg_over'" style="border-right:1px solid #CCCCCC"><a href="./?frame=product_s" class="link_menu">S&#7842;N PH&#7848;M</a> </td>

        <td width="19%" align="center" class="font_menu_while" onMouseOver="this.className='left_menu_bg_hover'" onMouseOut="this.className='left_menu_bg_over'" style="border-right:1px solid #CCCCCC"><a href="./?frame=news" class="link_menu">TIN T&#7912;C &amp; S&#7920; KI&#7878;N</a></td>

        <td width="21%" align="center" onMouseOver="this.className='left_menu_bg_hover'" onMouseOut="this.className='left_menu_bg_over'" class="font_menu_while" style="border-right:1px solid #CCCCCC"><a href="./?frame=download" class="link_menu">HỖ TRỢ KỸ THUẬT</a></td>

        <td width="14%" align="center" onMouseOver="this.className='left_menu_bg_hover'" onMouseOut="this.className='left_menu_bg_over'" class="font_menu_while"><a href="./?frame=contact" class="link_menu">LI&Ecirc;N H&#7878;</a> </td>

        </tr>

    </table></td>

  </tr>

  <tr>

    <td width="190" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td align="left" class="font_product">S&#7842;N PH&#7848;M </td>

      </tr>

      <tr>

        <td width="190" align="center">

		<?php include('module/product_category.php')?></td>

      </tr>

      <tr>

        <td align="left" bgcolor="#FFFFFF" class="font_product">&#272;&#258;NG NH&#7852;P </td>

      </tr>

      <tr>

        <td align="left" bgcolor="#FFFFFF" style="padding:10px"><?php include("box/box_login.php")?></td>

      </tr>

      <tr>

        <td align="left" class="font_product">H&#7894; TR&#7906; TR&#7920;C TUY&#7870;N </td>

      </tr>

      <tr>

        <td align="center" bgcolor="#FFFFFF" style="padding:10px"><?php include("box/box_yahoo.php")?></td>

      </tr>

      <tr>

        <td align="left" class="font_product">TH&#7888;NG K&Ecirc; </td>

      </tr>

      <tr>

        <td align="center" bgcolor="#FFFFFF" style="padding:10px">

		<?php include("box/box_total.php")?>

		</td>

      </tr>

      <tr>

        <td align="left" class="font_product">QU&#7842;NG C&Aacute;O </td>

      </tr>

      <tr>

        <td align="center" bgcolor="#FFFFFF" style="padding:10px">

		<?php include("box/box_left.php")?>		</td>

      </tr>

    </table></td>

    <td width="760" valign="top" bgcolor="#FFFFFF" style="border-left:1px solid #CCCCCC;"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td bgcolor="#E6E6E6"><?php include("module/banner.php")?></td>

      </tr>

      <tr>

        <td align="left" bgcolor="#F7F7F7" class="font_menu_blue" style="border-bottom:1px solid #CCCCCC; border-top:1px solid #CCCCCC">S&#7842;N PH&#7848;M BÁN CHẠY </td>

      </tr>

      <tr>

        <td style="padding:5px">

		<?php include("module/product_special.php")?>

		</td>

      </tr>

      <tr>

        <td align="left" bgcolor="#F7F7F7" class="font_menu_blue" style="border-bottom:1px solid #CCCCCC; border-top:1px solid #CCCCCC">

		<?php include('module/processTitle.php')?>		</td>

      </tr>

      <tr>

        <td align="left" valign="top" style="padding:10px"><?php include('module/processFrame.php')?>	</td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td colspan="2" style="background-image:url(images/bg_menu_bottom.jpg); background-repeat:no-repeat; height:75px"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="20%" rowspan="3" align="center"><a href="./" style="cursor:pointer"><div align="center" style="width:70px; height:50px"></div></a></td>

        <td width="80%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr class="font_while">

            <td width="12%" align="center" style="border-right:1px solid #FFFFFF"><a href="./" class="link_menu">Trang chủ</a> </td>

            <td width="15%" align="center" style="border-right:1px solid #FFFFFF"><a href="./?frame=intro" class="link_menu">Giới thiệu</a> </td>

            <td width="16%" align="center" style="border-right:1px solid #FFFFFF"><a href="./?frame=product_s" class="link_menu">Sản phẩm</a> </td>

            <td width="19%" align="center" style="border-right:1px solid #FFFFFF"><a href="./?frame=news" class="link_menu">Tin tức &amp; Sự kiện</a> </td>

            <td width="19%" align="center" style="border-right:1px solid #FFFFFF"><a href="./?frame=download" class="link_menu">Hỗ trợ kỹ thuật </a> </td>

            <td width="14%" align="center"><a href="./?frame=contact" class="link_menu">Liên hệ</a> </td>

            <td width="5%" align="center">&nbsp;</td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="center" class="font_while"><?php include("module/bottom.php")?></td>

      </tr>

    </table></td>

  </tr>

</table>

</body>

</html>


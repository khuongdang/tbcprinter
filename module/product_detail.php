<link href="css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>
<? $pro = getRecord("tbl_product", "id=".$_REQUEST['id']);?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><a href="<?=$pro['image_large']?>" rel="lightbox"><img src="<?=$pro["image"]?>" border="0" /></a></td>
              </tr>
              <tr>
                <td align="center" class="font_product_title"><a href="<?=$pro['image_large']?>" rel="lightbox" class="link_menu_sp">Xem h&igrave;nh l&#7899;n </a></td>
              </tr>
            </table></td>
            <td width="75%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td class="font_xam_lagre"><?=$pro['name']?></td>
              </tr>
              <tr>
                <td class="font_xam"><strong>Gi&aacute; :
                <?=number_format($pro['price'],0,',','.')?> 
               <?=$currencyUnit?></strong></td>
              </tr>
              <tr>
                <td bgcolor="#00A9DD" class="font_while">Thông tin chi tiết sản phẩm </td>
              </tr>
              <tr>
                <td class="font_xam"><?=$pro['detail']?></td>
              </tr>
              <tr>
                <td><a href="./?frame=cart&p=<?=$pro['id']?>"><div class="add_card" align="center" style="width:102px; height:22px; cursor:pointer" onMouseOver="this.className='add_card_hover'" onMouseOut="this.className='add_card'"></div></a></td>
              </tr>
              <tr>
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="12%" align="left"> <script>
	function printPage() { print(document); }
	</script>
      <input value="Print" onclick="printPage()" type="button"></td>
    <td width="88%" align="left"><?=($pro['download'] != NULL)?'<img src="images/download.jpg" /><a class="link_menu_sp" href="'.$pro['download'].'">Download</a>':'' ?></td>
  </tr>
</table>				</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>

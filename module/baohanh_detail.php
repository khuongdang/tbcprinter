<?
$row = getRecord("tbl_baohanh", "id=".$_REQUEST['id']);
?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="22" colspan="2" valign="top" class="font_blue"><?=$row["name"]?></td>
                    </tr>
					 <tr>
                      <td colspan="2" valign="top" class="font_xam"><?=$row["detail"]?></td>
                    </tr>
					 <tr>
					   <td colspan="2" align="right" valign="top" style="padding-right:20px">
					   <table width="100" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/download.jpg" /></td>
    <td style="padding-left:10px"><a href="<?=$row['image_large']?>" class="link_menu_sp">Download</a></td>
  </tr>
</table>
					   
</td>
  </tr>
</table>			

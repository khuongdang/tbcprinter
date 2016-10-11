<?
$code = $_lang == 'vn' ? 'vn_banner' : 'en_banner';
$parentWhere = "parent = (select id from tbl_content_category where code='$code')";
$row = getRecord("tbl_content",$parentWhere);
?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="font_xam"><img src="<?=$row['image']?>" width="758" height="234" /></td>
  </tr>
</table>

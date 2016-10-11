<?
$code = $_lang == 'vn' ? 'vn_intro' : 'en_intro';
$parentWhere = "parent = (select id from tbl_content_category where code='$code')";
$row = getRecord("tbl_content",$parentWhere);
?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="font_xam"><?=$row['detail_short']?></td>
  </tr>
</table>

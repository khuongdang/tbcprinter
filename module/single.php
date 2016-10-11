<?
$request = $_REQUEST['frame'];
$code = $_lang == 'vn' ? 'vn_'.$request : 'en_'.$request;
$parentWhere = "parent = (select id from tbl_content_category where code='$code')";
$record = getRecord("tbl_content",$parentWhere);
?>
<table align="center" width="98%" cellpadding="0" cellspacing="0">
	<tr>
		<td>			
			<?=$record['detail_short']?>
		</td>
	</tr>
</table>
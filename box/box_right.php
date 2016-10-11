<table width="188" border="0" cellspacing="0" cellpadding="0" align="center">
<?
$code = $_lang=='vn' ? "vn_advright" : "en_advright";
$sql = "select * from tbl_content where status=0 and parent in (select id from tbl_content_category where code='".$code."') order by sort, date_added";
$result = @mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
	if($row['image']!=''){
?>

<tr>
  <td align="center"><a href="<?=$row['code']?>" target="_blank">
  	<img border="0" src="<?=$row['image']?>" width="188"></a></td>
</tr>
<tr><td height="5px"></td></tr>
<?
	}
}
?>
</table>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
<?
$sql = "select * from tbl_baohanh_category where status=0 and parent= 2 order by sort, date_added";
$result = mysql_query($sql,$conn);
while($row = mysql_fetch_assoc($result)){
?>
	<tr>
			<td height="25" align="left" class="font_blue"><img src="images/icon1.gif" /> &nbsp;&nbsp; <a href="./?frame=download_view&id=<?=$row['id']?>" class="link_menu_sp"><?=$row['name']?></a></td>
	</tr>
<? }?>
</table>






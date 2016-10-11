<? $row = getRecord("tbl_content", "id=".$_REQUEST['id'])?>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<table align="center" border="0" width="98%" cellpadding="0" cellspacing="0">
	<tr><td height="22" style="padding-left:5px; padding-top:5px"><span style="font-family:Tahoma; font-size:14px; color:#333333"><strong><?=$row['name']?></strong></span></td></tr>
	
	<tr>
		<td>
			<?
			if($row['image'] || $row['image_large']){
				$img = $row['image']!='' ? $row['image'] : $row['image_large'];
			?>
				<img border="0" src="<?=$img?>" width="120px"  height="90px" align="left" vspace="10" hspace="10"> 
			<? }?>
			<br/><br />
			<?=$row['detail']?>
		</td>
	</tr>
	<tr><td height="10px"></td></tr>
	<tr><td align="right" style="padding-right:5px"><a href="javascript:history.go(-1);">
		<span style="font-family:Tahoma; color:#999999; font-size:12px; font-weight:600; text-decoration:none">[Quay lại]</span>
		</a></td></tr>	
</table>

<table align="center" border="0" width="98%" cellpadding="0" cellspacing="0">	
	<tr>
        <td align="left" bgcolor="#F7F7F7" class="font_menu_blue" style="border-bottom:1px solid #CCCCCC; border-top:1px solid #CCCCCC">CÁC TIN KHÁC </td>
      </tr>	
	<tr><td height="10px"></td></tr>
</table>

<table align="center" border="0" width="98%" cellpadding="0" cellspacing="0">
<?
$per_page = 5;
$p=0;
if ($_REQUEST['p']!='') $p=killInjection($_REQUEST['p']);

$code = $_lang == 'vn' ? 'vn_news' : 'en_news';
$parentWhere = "and parent = (select id from tbl_content_category where code='".$code."')";
$sql = "select * from tbl_content where status=0 AND id<>'".$row['id']."' AND parent=".$row['parent']." $parentWhere order by sort,date_added desc limit ".$per_page*$p.",".$per_page;

$result = @mysql_query($sql,$conn);
$total = countRecord("tbl_content","status=0 and parent=".$row['parent']);
while($n=mysql_fetch_assoc($result)){
?>
	<tr>
		<td width="30"><img src="images/icon1.gif" border="0" hspace="5" /></td>
		<td width="900" valign="middle">
			<a class="link_menu_sp" href="./?frame=news_detail&id=<?=$n['id']?>&p=<?=$_REQUEST['p']?>"><?=$n['name']?></a></td>		
	</tr>
	<tr><td height="5px" colspan="2"></td></tr>
<? }?>
</table>

<table align="center" cellSpacing="0" cellPadding="0" width="98%" border="0" class="font_xam">
<?
$rowPage       = $_lang=="vn" ? "Tin" : "news";
$pagePage       = $_lang=="vn" ? "Trang" : "Page";
$titleFirst     = $_lang=="vn" ? "Đầu Tiên" : "First";
$titlePrevious  = $_lang=="vn" ? "Về trước" : "Previous";
$titleNext      = $_lang=="vn" ? "Tiếp theo" : "Next";
$titleLast      = $_lang=="vn" ? "Cuối cùng" : "Last";

$pages = countPages($total,$per_page);
echo '<tr><td colspan="2" align="center"></td></tr>';
echo '<tr>';
echo '<td class="smallfont" align="right">'.$pagePage.' : ';
$param="";
if ($p>1) echo '<a class="aLink3" title="'.$titleFirst.'" href="./?frame='.$_REQUEST['frame'].'&id='.$_REQUEST['id'].''.$param.'&p=0">[&lt;&lt;]</a> ';
if ($p>0) echo '<a class="aLink3" title="'.$titlePrevious.'" href="./?frame='.$_REQUEST['frame'].'&id='.$_REQUEST['id'].''.$param.'&p='.($p-1).'">[&lt;]</a> ';
$from=($p-10>0?$p-10:0);
$to=($p+10<$pages?$p+10:$pages);
for ($i=$from;$i<$to;$i++){
	if ($i!=$p) echo '<a class="aLink3" href="./?frame='.$_REQUEST['frame'].'&id='.$_REQUEST['id'].''.$param.'&p='.$i.'">'.($i+1).' </a>';
	else echo '<b>'.($i+1).'</b> ';
}
if ($p<$i-1) echo '<a class="aLink3" title="'.$titleNext.'" href="./?frame='.$_REQUEST['frame'].'&id='.$_REQUEST['id'].''.$param.'&p='.($p+1).'">[&gt;]</a> ';
if ($p<$pages-1) echo '<a class="aLink3" title="'.$titleLast.'" href="./?frame='.$_REQUEST['frame'].'&id='.$_REQUEST['id'].''.$param.'&p='.($pages-1).'">[&gt;&gt;]</a>'; 
echo '</td></tr>';
?>
</table><br>
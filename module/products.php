<?
$row = 5;
$col = 4;

$catparent = 0;
if(isset($_REQUEST['catparent']) && $_REQUEST['catparent']!='') $catparent=killInjection($_REQUEST['catparent']);

$p=0;
if (isset($_REQUEST['p']) && $_REQUEST['p']!='') $p=$_REQUEST['p'];
$sql = "select * from tbl_product where status=0 and parent=".$catparent." order by sort,date_added desc limit ".$row*$col*$p.",".$row*$col;
$change = array('"', "''","");
$result = @mysql_query($sql,$conn);

$total = countRecord("tbl_product","status=0 AND parent=".$catparent);

if($total==0){
?>
<link href="../css/css.css" rel="stylesheet" type="text/css">
<table align="center" cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr><td height="20"></td></tr>
	<tr>
		<td align="center">
			<!--<font color="#000000"><b><? //=$_lang=="vn"?'Không có sản phẩm nào thuộc danh mục này !':'Information are being updated !'?></b></font>-->
		</td>
	</tr>
	<tr><td height="20"></td></tr>
</table>
<?
}else{
?>

<table align="center" cellSpacing="0" cellPadding="0" width="100%" border="0">
<?
for($i=0; $i<$row; $i++){
?>
	<tr>			  
			<td width="4px"></td>
<?
	for($j=0; $j<$col&&$products=mysql_fetch_assoc($result); $j++){
		$pro = getRecord("tbl_product","id=".$products['id'])?><td class="margin_bottom">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" class="font_product_title"><?=$pro['name']?></td>
          </tr>
          <tr>
            <td align="center"><a href="./?frame=product_detail&id=<?=$pro['id']?>"><img src="<?=$pro['image']?>" height="106" border="0" /></a></td>
          </tr>
          <tr align="center">
            <td class="font_product_title"><?=$pro['price']!=0?''.number_format($pro['price']).'':'Call' ?> <?=$currencyUnit?></td>
          </tr>
          <tr>
            <td height="35" align="center" valign="top" style="border-bottom:1px dashed #CCCCCC"><a href="./?frame=cart&p=<?=$pro['id']?>"><div class="add_card" align="center" style="width:102px; height:22px; cursor:pointer" onMouseOver="this.className='add_card_hover'" onMouseOut="this.className='add_card'"></div></a></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
        </table>					
            <?
}
while($j<$col){
	echo "";
	$j=$j+1;
}
?></td>
	</tr>	  
<? }?>
</table>

<table align="center" cellSpacing=0 cellPadding=0 width="98%" border=0 class="font_xam">
<?
$newsPage       = $_lang=="vn" ? "Sản phẩm" : "Products";
$pagePage       = $_lang=="vn" ? "Trang" : "Page";
$titleFirst     = $_lang=="vn" ? "Đầu Tiên" : "First";
$titlePrevious  = $_lang=="vn" ? "Về trước" : "Previous";
$titleNext      = $_lang=="vn" ? "Tiếp theo" : "Next";
$titleLast      = $_lang=="vn" ? "Cuối cùng" : "Last";

$pages = countPages($total,$row*$col);
echo '<tr><td colspan="2" align="center"></td></tr>';
echo '<tr><td class="smallfont" align="left"><b>'.$total.'</b> '.$newsPage.'</td>';
echo '<td class="smallfont" align="right">'.$pagePage.' : ';
$param="";
if ($p>1) echo '<a class="aLink3" title="'.$titleFirst.'" href="./?frame='.$_REQUEST['frame'].'&catparent='.$_REQUEST['catparent'].'&'.$catparent.'&p=0">[&lt;&lt;]</a> ';
if ($p>0) echo '<a class="aLink3" title="'.$titlePrevious.'" href="./?frame='.$_REQUEST['frame'].'&catparent='.$_REQUEST['catparent'].'&'.$catparent.'&p='.($p-1).'">[&lt;]</a> ';
$from=($p-10>0?$p-10:0);
$to=($p+10<$pages?$p+10:$pages);
for ($i=$from;$i<$to;$i++){
	if ($i!=$p) echo '<a class="aLink3" href="./?frame='.$_REQUEST['frame'].'&catparent='.$_REQUEST['catparent'].'&'.$param.'&p='.$i.'">'.($i+1).' </a>';
	else echo '<span style="font-family:Tahoma; font-size:12px; font-weight:600; color:#FF0000">'.($i+1).'</span> ';
}
if ($p<$i-1) echo '<a class="aLink3" title="'.$titleNext.'" href="./?frame='.$_REQUEST['frame'].'&catparent='.$_REQUEST['catparent'].'&'.$param.'&p='.($p+1).'">[&gt;]</a> ';
if ($p<$pages-1) echo '<a class="aLink3" title="'.$titleLast.'" href="./?frame='.$_REQUEST['frame'].'&catparent='.$_REQUEST['catparent'].'&'.$param.'&p='.($pages-1).'">[&gt;&gt;]</a>'; 
echo '</td></tr>';
?>
</table>
<? }?>

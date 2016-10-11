<?
$l_Product       = $_lang == 'vn' ? 'Tin' : 'News';
$l_Price         = $_lang == 'vn' ? 'Giá' : 'Price';

$l_Keyword       = $_lang == 'vn' ? 'Từ khóa' : 'Keyword';
$l_CheckboxLabel = $_lang == 'vn' ? 'Chỉ tìm trong phần mô tả sản phẩm' : 'Only search in product detail';
$l_BelongTo      = $_lang == 'vn' ? 'Trong danh mục' : 'Belong to';
$l_PriceFrom     = $_lang == 'vn' ? 'Giá từ' : 'Price from';
$l_PriceTo       = $_lang == 'vn' ? 'Giá đến' : 'Price to';
$l_DateFrom      = $_lang == 'vn' ? 'Từ ngày' : 'From date';
$l_DateTo        = $_lang == 'vn' ? 'Đến ngày' : 'To date';

$l_DateFormat    = $_lang == 'vn' ? 'Tháng / ngày / năm' : 'month / day / year';
?>
<?
$row = 3;
$col = 3;

if (isset($_REQUEST['act'])){
?>
<?
	$where="1=1";
	$keyword = killInjection($_REQUEST['keyword']);
	if ($keyword!=''){
		$where .= " and (detail_short like '%".$keyword."%' or detail like '%".$keyword."%'";
		if (!isset($_REQUEST['search_in_detail'])) 
			$where.=" or code like '%".$keyword."%' or name like '%".$keyword."%'"; 
		$where.=") ";
	}
	if ($_REQUEST['parent']!='') $where.=" and parent=".$_REQUEST['parent'];
	if ($_REQUEST['pfrom']!='')	$where.=" and price>=".$_REQUEST['pfrom'];
	if ($_REQUEST['pto']!='') $where.=" and price<=".$_REQUEST['pto'];
	if ($_REQUEST['dfrom']!='')	$where.=" and date_added>=".$_REQUEST['dfrom'];
	if ($_REQUEST['dto']!='') $where.=" and date_added<=".$_REQUEST['dto'];
	
	$p=0;
	if ($_REQUEST['p']!='') $p=$_REQUEST['p'];
	
	$result = @mysql_query("select count(*) from tbl_product where $where",$conn);
	$total = mysql_fetch_row($result);

	$sql="select * from tbl_product where $where limit ".$row*$col*$p.",".$row*$col;
	$result = @mysql_query($sql,$conn);
	{
		?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<table align="center" cellSpacing="0" cellPadding="0" width="100%" border="0">
<?
for($i=0; $i<$row; $i++){
?>
	<tr>
		<td width="4"></td>	  
<?
	for($j=0; $j<$col&&$products=mysql_fetch_assoc($result); $j++){
		$pro = getRecord("tbl_product","id=".$products['id'])?><td class="font_xam">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" class="font_product_title"><?=$pro['name']?></td>
          </tr>
          <tr>
            <td align="center"><a href="./?frame=product_detail&id=<?=$pro['id']?>"><img src="<?=$pro['image']?>" width="130" height="106" border="0" /></a></td>
          </tr>
          <tr align="center">
            <td class="font_product_title"><?=number_format($pro['price'],0,',','.')?> VNĐ</td>
          </tr>
          <tr>
            <td height="35" align="center" valign="top" style="border-bottom:1px dashed #CCCCCC"><a href="./?frame=cart&p=<?=$pro['id']?>"><img src="images/dat_mua.jpg" width="102" height="22" border="0" /></a></td>
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

		<?
	}
	?>
</table>
<table align="center" cellSpacing=0 cellPadding=0 width="98%" border=0 class="font_xam">
<?
$newsPage       = $_lang=="vn" ? "Sản phẩm" : "Products";
$pagePage       = $_lang=="vn" ? "Trang" : "Page";
$titleFirst     = $_lang=="vn" ? "Đầu Tiên" : "First";
$titlePrevious  = $_lang=="vn" ? "Về trước" : "Previous";
$titleNext      = $_lang=="vn" ? "Tiếp theo" : "Next";
$titleLast      = $_lang=="vn" ? "Cuối cùng" : "Last";

$total=$total[0];
$pages=countPages($total,$row*$col);
echo '<tr><td colspan="2" align="center"></td></tr>';
echo '<tr><td class="smallfont" align="left"><b>'.$total.'</b> '.$newsPage.'</td>';
echo '<td class="smallfont" align="right">'.$pagePage.' : ';
$param="act=search&keyword=$keyword";
if ($p>1) echo '<a class="aLink3" title="'.$titleFirst.'" href="./?frame='.$_REQUEST['frame'].'&cat='.$_REQUEST['cat'].'&'.$param.'&p=0">[&lt;&lt;]</a> ';
if ($p>0) echo '<a class="aLink3" title="'.$titlePrevious.'" href="./?frame='.$_REQUEST['frame'].'&cat='.$_REQUEST['cat'].'&'.$param.'&p='.($p-1).'">[&lt;]</a> ';
$from=($p-10>0?$p-10:0);
$to=($p+10<$pages?$p+10:$pages);
for ($i=$from;$i<$to;$i++){
	if ($i!=$p) echo '<a class="aLink3" href="./?frame='.$_REQUEST['frame'].'&cat='.$_REQUEST['cat'].'&'.$param.'&p='.$i.'">'.($i+1).' </a>';
	else echo '<span style="font-family:Tahoma; font-size:12px; font-weight:600; color:#FF0000">'.($i+1).'</span> ';
}
if ($p<$i-1) echo '<a class="aLink3" title="'.$titleNext.'" href="./?frame='.$_REQUEST['frame'].'&cat='.$_REQUEST['cat'].'&'.$param.'&p='.($p+1).'">[&gt;]</a> ';
if ($p<$pages-1) echo '<a class="aLink3" title="'.$titleLast.'" href="./?frame='.$_REQUEST['frame'].'&cat='.$_REQUEST['cat'].'&'.$param.'&p='.($pages-1).'">[&gt;&gt;]</a>'; 
echo '</td></tr>';
?>
</table>
<br />

<?
}else{
?>

<table border="0" cellpadding="10" cellspacing="1" width="100%">
	<tr><td>
<form name="frmSearch" action="./" method="GET">
<input type="hidden" name="act" value="search">
<input type="hidden" name="frame" value="search">
<table border="0" width="100%" cellSpacing="0" cellPadding="2">
	<tr>
		<td width="100" class="font_blue" align="right"><?=$l_Keyword?></td>
		<td width="5" class="font_blue" align="center"></td>
		<td class="font_blue">
			<input type="text" name="keyword" style="width: 90%" class="textbox">
		</td>
	</tr>
	
	<tr>
		<td class="font_blue" align="right"></td>
		<td class="font_blue" align="center"></td>
		<td class="font_blue">
			<input type="checkbox" value="1" name="search_in_detail" class="textbox"> <?=$l_CheckboxLabel?>
		</td>
	</tr>
	
	<tr>
		<td class="font_blue" align="right"></td>
		<td class="font_blue" align="center"></td>
		<td class="font_blue">
			<input type="submit" class="button" value="<?=_SEARCH?>">
		</td>
	</tr>
	
	<tr><td colspan="3" height="20"></td></tr>
	
	<tr>
		<td class="font_while" align="right"><?=$l_BelongTo?></td>
		<td class="font_while" align="center">:</td>
		<td class="font_while">
			<?
			$sourceCombo = getArrayCategory("tbl_product_category");
			echo comboCategory('parent',$sourceCombo,'smallfont',"",1);
			?>		</td>
	</tr>

	<tr>
		<td class="font_blue" align="right"><?=$l_PriceFrom?></td>
		<td class="font_blue" align="center">:</td>
		<td class="font_blue"><input type="text" name="pfrom" class="textbox"></td>
	</tr>
	
	<tr>
		<td class="font_blue" align="right"><?=$l_PriceTo?></td>
		<td class="font_blue" align="center">:</td>
		<td class="font_blue"><input type="text" name="pto" class="textbox"></td>
	</tr>
	
	<tr>
		<td class="font_blue" align="right"><?=$l_DateFrom?></td>
		<td class="font_blue" align="center">:</td>
		<td class="font_blue"><input type="text" name="dfrom" class="textbox"> (<?=$l_DateFormat?>)</td>
	</tr>
	
	<tr>
		<td class="font_blue" align="right"><?=$l_DateTo?></td>
		<td class="font_blue" align="center">:</td>
		<td class="font_blue"><input type="text" name="dto" class="textbox"> (<?=$l_DateFormat?>)</td>
	</tr>
	
</table>

</form>

	</td></tr>
</table>
<? }?>
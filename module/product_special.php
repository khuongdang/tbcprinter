<?
$row = 50;
$col = 1;

$p=0;
if (isset($_REQUEST['p']) && $_REQUEST['p']!='') $p=$_REQUEST['p'];
$sql = "select tbl_product.*,tbl_product_special.sort as sort from tbl_product_special,tbl_product where tbl_product_special.lang='".$_lang."' and tbl_product_special.product_id = tbl_product.id order by tbl_product_special.sort limit ".$row*$col*$p.",".$row*$col;
$change = array('"', "","");
$result = @mysql_query($sql,$conn);

$total = countRecord("tbl_product_special","status=0 and lang='".$_lang."'");
if($total==0){
?>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<table align="center" cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
		<td align="center">
			<font color="#993300"><b><?=$_lang=="vn"?'Sản phẩm khuyến mãi đang cập nhật !':'Products are being updated !'?></b></font>
		</td>
	</tr>
</table>
<?
}else{
?>
<marquee scrollamount="3" scrolldelay="50" direction="left" height="110"  scrolldelay="1">
<?
for($i=0; $i<$row; $i++){
?>
	
<?
	for($j=0; $j<$col&&$products=mysql_fetch_assoc($result); $j++){
		$pro = getRecord("tbl_product","id=".$products['id'])?>
			  <a href="./?frame=product_detail&id=<?=$pro['id']?>"><img src="<?=$pro['image']?>" height="106" border="0" align="middle"/></a>
            <?
}
while($j<$col){
	echo "";
	$j=$j+1;
}
?>							
<? }?>

</marquee>
<? }?>
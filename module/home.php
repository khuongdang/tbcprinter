<link href="../css/css.css" rel="stylesheet" type="text/css" />
<? 
$row = 5;
$col = 4;

$cat = 0;
if(isset($_REQUEST['cat']) && $_REQUEST['cat']!='') $cat=killInjection($_REQUEST['cat']);

$p_new=0;
if (isset($_REQUEST['p_new']) && $_REQUEST['p_new']!='') $p_new=$_REQUEST['p_new'];
$sql = "select tbl_product.*,tbl_product_new.sort as sort from tbl_product_new,tbl_product where tbl_product_new.lang='".$_lang."' and tbl_product_new.product_id = tbl_product.id order by tbl_product_new.sort limit ".$row*$col*$p_new.",".$row*$col;
$change = array('"', "","");
$result = @mysql_query($sql,$conn);
$total = countRecord("tbl_product_new","status=0 and lang='".$_lang."'");
if($total==0){
?>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('../images/dat_mua.jpg','images/dat_mua_hover.jpg')"><table align="center" cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr><td height="20"></td></tr>
	<tr>
		<td align="center">
			<font color="#000000"><strong><?=$_lang=="vn"?'Sản phẩm mới đang cập nhật !':'Products are being updated !'?></strong></font>
		</td>
	</tr>
	<tr><td height="20"></td></tr>
</table>
<?
}else{
?>

<table align="center" cellspacing="0" cellpadding="0" width="100%" border="0">
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
            <td align="center"><a href="./?frame=product_detail&id=<?=$pro['id']?>"><img src="<?=$pro['image']?>" name="Image1" height="106" border="0" id="Image1" /></a></td>
          </tr>
          <tr align="center">
            <td class="font_product_title"><?=number_format($pro['price'],0,',','.')?> <?=$currencyUnit?></td>
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

<? }?>

<style type="text/css">
	.buttonorange
		{
			font-family:Tahoma;
			font-size:12px;
			color:#000000;
		}
</style>
<?
$l_buymore	 = $_lang == 'vn' ? 'Mua tiếp' : ''; 
$_image		 = $_lang == 'vn' ? 'Hình ảnh' : 'Image';
$l_product   = $_lang == 'vn' ? 'Sản phẩm' : 'Product';
$l_quantity  = $_lang == 'vn' ? 'Số lượng' : 'Quantity';
$l_price     = $_lang == 'vn' ? 'Đơn giá' : 'Unit price';
$l_money     = $_lang == 'vn' ? 'Thành tiền' : 'Cost';
$l_total     = $_lang == 'vn' ? 'Tổng cộng' : 'Total';
$_Delete 	 = $_lang == 'vn' ? 'Xoá' : 'Delete' ;		

$l_btnDel    = $_lang == 'vn' ? 'Xóa' : 'Delete';
$l_btnDelAll = $_lang == 'vn' ? 'Xóa hết' : 'Delete all';
$l_btnUpdate = $_lang == 'vn' ? 'Cập nhật' : 'Update';
$l_btnPay    = $_lang == 'vn' ? 'Thanh toán' : 'Pay';

$l_cartEmpty = $_lang == 'vn' ? 'Bạn chưa chọn bất kỳ sản phẩm nào.' : 'Your cart is empty.';

function checkexist(){
	$cart=$_SESSION['cart'];
	foreach ($cart as $product)
		if ($product[0]==$_REQUEST['p']) return true;
	return false;
}

if (isset($_REQUEST['act']) && $_REQUEST['act']=='del'){
	if (count($_SESSION['cart'])==1){
		unset($_SESSION['cart']);
	}else{
		$cart=$_SESSION['cart'];
		unset($cart[$_REQUEST['pos']]);
		$_SESSION['cart']=$cart;
	}
}

if (isset($_POST['butUpdate'])||isset($_POST['btnCheckout'])){
	$cart=$_SESSION['cart'];
	$t=0;
	foreach ($_POST['txtQuantity'] as $quantity){
		if (is_numeric($quantity) && $quantity>0 && strlen($quantity)<5)
			$cart[$t][1]=(int)$quantity;
		if ($quantity<=0){
			unset($cart[$t]);
			$t=$t-1;
		}
		$t=$t+1;
	}
	if (count($cart)<=0) unset($cart);
	$_SESSION['cart']=$cart;
	
	if (isset($_POST['btnCheckout'])) echo "<script>window.location='./?frame=checkout'</script>";
}

if (isset($_POST['btnBuymore'])) echo "<script>window.location='./'</script>";
	
if (isset($_POST['btnDeleteAll'])) unset($_SESSION['cart']);

if (isset($_REQUEST['p'])){
	if (!isset($_SESSION['cart'])){
		$pro=$_REQUEST['p'];
		$cart=array();
		$cart[] = array($pro,1);
		$_SESSION['cart']=$cart;
	}else{
		$pro=$_REQUEST['p'];
		$cart=$_SESSION['cart'];
		if (countRecord("tbl_product","id='".$_REQUEST['p']."'")>0 && checkexist()==false){
			$cart[]=array($pro,1);
			$_SESSION['cart']=$cart;
		}
	}
}else{
	$cart=$_SESSION['cart'];
}
?>


<? if (!isset($_SESSION['cart'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
				<tr>
					<td align="center">
						<br><br><br>
						<font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
							<b><?=$l_cartEmpty?></b>
						</font>
						<br><br><br>
					</td>
				</tr>
		  </table>
<? }else{?>


<FORM action="./" method="POST" name="frmCart">
<input type="hidden" name="frame" value="cart"> 
<table border="1" width="100%" cellspacing="0" cellpadding="3" bordercolor="#CCCCCC" style="border-collapse:collapse">
	<tr>
		<th width="100" class="smallfont"><?=$_image?></th>
		<th class="smallfont"><?=$l_product?></th>
		<th class="smallfont" width="70"><?=$l_quantity?></th>
		<th class="smallfont" width="70"><?=$l_price?><br>(<font color="#CC0000"><?=$currencyUnit?></font>)</th>
		<th class="smallfont" width="70"><?=$l_money?></th>
		<th width="60" class="smallfont"><?=$_Delete?></th>
	</tr>
<?
$cnt=0;
$tongcong=0;
foreach ($cart as $product){
	$sql = "select * from tbl_product where id='".$product[0]."'";
	$result = mysql_query($sql,$conn);	
	if ($r=mysql_num_rows($result)>0){		
	//$s=$r;
	$pro = mysql_fetch_assoc($result)?>
	<tr>
		<td class="smallfont" align="center">
			<a href="./?frame=product_detail&id=<?=$pro['id']?>">
				<img src="<?=$pro['image']?>" alt="<?=$pro['name']?>" border="0" width="100">
			</a>
		</td>
		<td class="smallfont"><?=$pro['name']?></td>
		<td class="smallfont" align="center">
			<input type="text" name="txtQuantity[]" size="5" value="<?=$product[1]?>">
		</td>
		<td class="smallfont" align="center"><?=number_format($pro['price'],0)?></td>
		<td class="smallfont" align="center"><?=number_format(($pro['price']*$product[1]),0)?></td>
		<td class="smallfont" align="center">
        	<input type="submit" style="width:50" name="btnDelete" value="<?=$l_btnDel?>" onclick="window.location='./?frame=cart&act=del&pos=<?=$cnt?>';return false;">
	  </td>
	</tr>
<?
}
$tongcong=$tongcong+$pro['price']*$product[1];
$cnt=$cnt+1;
$_SESSION['soluong']=$cnt;
} 
?>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smallfont" align="right" colspan="2">
			<b><?=$l_total?> : <font color="#CC0000"><?=number_format($tongcong,0)?></font> <font color="#FF0000"><?=$currencyUnit?></font></b>		</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td>
			<input type="submit"  name="butUpdate" value="<?=$l_btnUpdate?>">
			<input type="submit"  name="btnDeleteAll" value="<?=$l_btnDelAll?>">		</td>
		<td align="right">
			<input type="submit"  name="btnBuymore" value="<?=$l_buymore?>">
			<input type="submit"  name="btnCheckout" value="<?=$l_btnPay?>">		</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td align="right">&nbsp;</td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td align="right"> <script>
	function printPage() { print(document); }
	</script>
      <input value="Print" onclick="printPage()" type="button">
</td>
    </tr>
</table>

</FORM>
<?
}
?>


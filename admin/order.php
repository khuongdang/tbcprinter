<? $errMsg =''?>
<?
switch ($_GET['action']){
	case 'del' :
		$id = $_GET['id'];
		if (countRecord('tbl_order_detail','order_id='.$id)>=0) {
			$sql = "delete from tbl_order where id='".$id."'";
			$result = mysql_query($sql,$conn);
			if ($result) $errMsg = "Đã xóa thành công.";
			else $errMsg = "Không thể xóa dữ liệu !";
		} else {
			$errMsg = "Đang có sản phẩm tồn tại trong đơn hàng nên bạn không thể xóa !";
		}
		break;
}

if (isset($_POST['ButDel'])) {
	$cnt=0;
	$cntNotDel=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			if (countRecord('tbl_order_detail','order_id='.$id)>=0) {
				@$result = mysql_query("delete from tbl_order where id='".$id."'",$conn);
				if ($result) $cnt++;
				
			}else $cntNotDel++;
		}
		$errMsg = "Đã xóa ".$cnt." đơn hàng.<br><br>";
		$errMsg .= $cntNotDel>0 ? 'Không thể xóa '.$cntNotDel.' đơn hàng, vì vẫn còn sản phẩm tồn tại trong chi tiết đơn hàng !' : $cntNotDel;
	}else{
		$errMsg = 'Hãy chọn trước khi xóa !';
	}
}
?>
<form method="POST" name="frmForm" action="./">
<input type="hidden" name="act" value="order">
<input type=hidden name="page" value="<?=$page?>">
<?
$pageindex = createPage(countRecord("tbl_order","1=1"),'./?act=order"."&page=',$MAXPAGE,$page);
?>

<table cellspacing="0" cellpadding="0" width="100%">
	<tr><td height="30" class="smallfont">Trang : <?=$pageindex?></td></tr>
</table>

<table border="1" cellpadding="2" bordercolor="#C9C9C9" width="100%">
	<tr>
		<th width="20" class="title"><input type="checkbox" name="chkall" onclick="chkallClick(this);"></th>
		<th width="20" class="title"></th>
		<th width="80" class="title">Chi tiết</th>
		<th width="20" class="title">ID</th>
		<th class="title"><a class="title" href="<?=getLinkSort(2)?>">Mã SP</a></th>
		<th class="title">Số lượng SP</th>    
		<th class="title"><a class="title" href="<?=getLinkSort(3)?>">Tên khách hàng</a></th>
		<th width="90" class="title"><a class="title" href="<?=getLinkSort(4)?>">Ngày tạo lập</a></th>
		<th width="90" class="title"><a class="title" href="<?=getLinkSort(5)?>">Lần hiệu chỉnh trước</a></th>
	</tr>
  
<?
$sortby = 'order by date_added';
if ($_REQUEST['sortby']!='') $sortby='order by '.(int)$_REQUEST['sortby'];
$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?'desc':'');

$sql="select *,DATE_FORMAT(date_added,'%d/%m/%Y %h:%i') as dateAdd,DATE_FORMAT(last_modified,'%d/%m/%Y %h:%i') as dateModify from tbl_order $sortby $direction limit ".($p*$MAXPAGE).",".$MAXPAGE;
$result=mysql_query($sql,$conn);
$i=0;
while($row=mysql_fetch_array($result)){
	$cust = getRecord("tbl_member",'id='.$row['member_id']);
	$color = $i++%2 ? '#d5d5d5' : '#e5e5e5';
?>
  
	<tr>
		<td bgcolor="<?=$color?>" class="smallfont">
			<input type="checkbox" name="chk[]" value="<?=$row['id']?>">
		</td>
		<td bgcolor="<?=$color?>" class="smallfont">
			<a onclick="return confirm('Bạn có chắc chắn muốn xóa ?');" href="./?act=order&action=del&id=<?=$row['id']?>">Xóa</a>
		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center">
			<input type="button" name="butDetail" value="Đơn hàng" class="button" onclick="javascript:window.location='./?act=order_detail&id=<?=$row['id']?>'"></td>
		<td bgcolor="<?=$color?>" align="center" class="smallfont"><?=$row['id']?></td>
		<td bgcolor="<?=$color?>" align="center" class="smallfont"><?=$row['code']?></td>
		<td bgcolor="<?=$color?>" align="center" class="smallfont">
			<?=countRecord('tbl_order_detail','order_id='.$row['id'])?>
		</td>
		<td bgcolor="<?=$color?>" class="smallfont"><?=$cust['name']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['dateAdd']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['dateModify']?></td>
	</tr>
<?
}
?>
</table>

<input type="submit" value="Xóa chọn" name="ButDel" onclick="return confirm('Bạn có chắc chắn muốn xóa ?');" class="button">
</form>
<script language="JavaScript">
function chkallClick(o) {
  	var form = document.frmForm;
	for (var i = 0; i < form.elements.length; i++) {
		if (form.elements[i].type == "checkbox" && form.elements[i].name!="chkall") {
			form.elements[i].checked = document.frmForm.chkall.checked;
		}
	}
}
</script>
<? if($errMsg!=''){echo '<p align=center class="err">'.$errMsg.'<br></p>';}?>

<table width="100%">
	<tr><td height="10"></td></tr>
	<tr><td class="smallfont"><?='Tổng số hàng : <b>'.countRecord('tbl_order').'</b>'?></td></tr>
</table>
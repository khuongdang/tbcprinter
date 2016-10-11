<? $errMsg =''?>
<?
switch ($_GET['action']){
	case 'del' :
		$id = $_GET['id'];
		$r = getRecord($tableConfig,"id=".$id);
		@$result = mysql_query('delete from tbl_member where id="'.$id.'"',$conn);
		if ($result){
			if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
			if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
			$errMsg = 'Đã xóa thành công.';
		}else $errMsg = 'Không thể xóa dữ liệu !';
		break;
}

if (isset($_POST['btnDel'])){
	$cntDel=0;
	$cntNotDel=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$r = getRecord($tableConfig,"id=".$id);
			@$result = mysql_query('delete from tbl_member where id="'.$id.'"',$conn);
			if ($result){
				if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
				if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
				$cntDel++;
			}else $cntNotDel++;
		}
		$errMsg = 'Đã xóa '.$cntDel.' phần tử.<br><br>';
		$errMsg .= $cntNotDel>0 ? 'Không thể xóa '.$cntNotDel.' phần tử.<br>' : '';
	}else{
		$errMsg = 'Hãy chọn trước khi xóa !';
	}
}

$page = $_GET['page'];
$p=0;
if ($page!='') $p=$page;
$where = '1=1';
if ($_REQUEST['cat']!='') $where='parent='.$_REQUEST['cat'];
?>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?=$page; ?>">
<input type="hidden" name="act" value="member">
<?
$pageindex = createPage(countRecord("tbl_member",$where),'./?act=member&page=',$MAXPAGE,$page);
?>

<? if ($_REQUEST['code']==1) $errMsg = 'Cập nhật thành công.';?>

<table cellspacing="0" cellpadding="0" width="100%">
	<tr><td height="30" class="smallfont">Trang : <?=$pageindex; ?></td></tr>
</table>

<table border="1" cellpadding="2" bordercolor="#C9C9C9" width="100%">
	<tr>
		<th class="title"><input type="checkbox" name="chkall" onClick="chkallClick(this);"></th>
		<th class="title"></th>
		<th class="title"></th>
		<th class="title"><a class="title" href="<?=getLinkSort(1); ?>">Id</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(2); ?>">Name</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(3); ?>">Sex</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(4); ?>">Company</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(5); ?>">Address</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(6); ?>">City</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(7); ?>">Country</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(8); ?>">Tel</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(9); ?>">Fax</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(10); ?>">Email</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(11); ?>">Website</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(12); ?>">Uid</a></th>
		<th class="title"><a class="title" href="<?=getLinkSort(12); ?>">Pass</a></th>
		<th width="50" class="title"><a class="title" href="<?=getLinkSort(14); ?>">Không hiển thị</a></th>
		<th width="90" class="title"><a class="title" href="<?=getLinkSort(15); ?>">Ngày tạo lập</a></th>
		<th width="90" class="title"><a class="title" href="<?=getLinkSort(16); ?>">Lần hiệu chỉnh trước</a></th>
	</tr>
  
<?
$sortby = 'order by date_added';
if ($_REQUEST['sortby']!='') $sortby='order by '.(int)$_REQUEST['sortby'];
$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?'desc':'');

$sql="select *,DATE_FORMAT(date_added,'%d/%m/%Y %h:%i') as dateAdd,DATE_FORMAT(last_modified,'%d/%m/%Y %h:%i') as dateModify from tbl_member where $where $sortby $direction limit ".($p*$MAXPAGE).",".$MAXPAGE;
$result=mysql_query($sql,$conn);
$i=0;
while($row=mysql_fetch_array($result)){
	$color = $i++%2 ? '#d5d5d5' : '#e5e5e5';
?>
  
	<tr>
		<td align="center" bgcolor="<?=$color; ?>" class="smallfont">
		<input type="checkbox" name="chk[]" value="<?=$row['id']; ?>"></td>
		<td bgcolor="<?=$color; ?>" class="smallfont" align="center">
			<a href="./?act=member_m&page=<?=$_REQUEST['page'];?>&id=<?=$row['id']; ?>">Sửa</a>
		</td>
		<td bgcolor="<?=$color; ?>" class="smallfont" align="center">
			<a 
				onClick="return confirm('Bạn có chắc chắn muốn xóa ?');" 
				href="./?act=member&action=del&page=<?=$_REQUEST['page']; ?>&id=<?=$row['id']; ?>"
			>Xóa</a>
		</td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['id']; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['name']; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['sex']=='0'?'Nam':'N&#7919;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['company']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['address']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['city']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['country']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['tel']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['fax']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['email']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['website']!=''?'...':'&nbsp;'; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['uid']?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont"><?=$row['pwd']?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont" align="center"><?=$row['status']; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont" align="center"><?=$row['dateAdd']; ?></td>
		<td bgcolor="<?=$color; ?>" class="smallfont" align="center"><?=$row['dateModify']; ?></td>
	</tr>
<?
}
?>
</table>
<input type="submit" value="Xóa chọn" name="btnDel" onClick="return confirm('Bạn có chắc chắn muốn xóa ?');" class="button">
<input type="button" value="Thêm mới" name="btnNew" onClick="window.location='./?act=member_m&page=<?=$_REQUEST['page']?>&cat=<?=$_REQUEST['cat']?>'" class="button">
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
	<tr><td class="smallfont"><?='Tổng số hàng : <b>'.countRecord('tbl_member').'</b>'?></td></tr>
</table>
<? // Config
$tableCategoryConfig = 'tbl_baohanh_category';
$tableConfig         = 'tbl_baohanh';
$actConfig           = 'baohanh';
$parentWhereConfig   = 'parent<>0';
?>

<? $errMsg =''?>
<?
switch ($_GET['action']){
	case 'del' :
		$id = $_GET['id'];
		$r = getRecord($tableConfig ,"id=".$id);
		@$result = mysql_query('delete from '.$tableConfig.' where id="'.$id.'"',$conn);
		if ($result){
			if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
			if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
			mysql_query("delete from tbl_product_new where product_id='".$id."'",$conn);
			mysql_query("delete from tbl_product_special where product_id='".$id."'",$conn);
			mysql_query("delete from tbl_product_sell where product_id='".$id."'",$conn);
			
			$errMsg = 'Đã xóa thành công.';
		}else $errMsg = 'Không thể xóa dữ liệu !';
		break;
}

if (isset($_POST['btnDel'])){
	$cntDel=0;
	$cntNotDel=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$r = getRecord($tableConfig ,"id=".$id);
			@$result = mysql_query('delete from '.$tableConfig.' where id="'.$id.'"',$conn);
			if ($result){
				if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
				if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
				mysql_query("delete from product_new where product_id='".$id."'",$conn);
				mysql_query("delete from product_special where product_id='".$id."'",$conn);
				mysql_query("delete from product_sell where product_id='".$id."'",$conn);
				$cntDel++;
			}else{
				$cntNotDel++;
			}
		}
		$errMsg = 'Đã xóa '.$cntDel.' phần tử.<br><br>';
		$errMsg .= $cntNotDel>0 ? 'Không thể xóa '.$cntNotDel.' phần tử.<br>' : '';
	}else{
		$errMsg = 'Hãy chọn trước khi xóa !';
	}
}

if (isset($_POST['btnNew'])) {
	$cnt=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$pro = getRecord($tableConfig, 'id='.$id);
			if ($pro){
				if (countRecord("tbl_product_new","product_id=".$pro['id']) <= 0){
					$result = mysql_query("insert into tbl_product_new (product_id,date_added,last_modified,lang) values ('".$pro['id']."',now(),now(),'".$pro['lang']."')",$conn);
					if ($result){$cnt++;}
				}
			}
		}
		$errMsg = 'Ðã Cập nhật '.$cnt.' phần tử.';
	}else{
		$errMsg = 'Hãy chọn sản phẩm !';
	}
}

if (isset($_POST['btnSpecial'])) {
	$cnt=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$pro = getRecord($tableConfig, 'id='.$id);
			if ($pro){
				if (countRecord("tbl_product_special","product_id=".$pro['id']) <= 0){
					$result = mysql_query("insert into tbl_product_special (product_id,date_added,last_modified,lang) values ('".$pro['id']."',now(),now(),'".$pro['lang']."')",$conn);
					if ($result){$cnt++;}
				}
			}
		}
		$errMsg = 'Ðã Cập nhật '.$cnt.' phần tử.';
	}else{
		$errMsg = 'Hãy chọn sản phẩm !';
	}
}
if (isset($_POST['btnSell'])) {
	$cnt=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$pro = getRecord($tableConfig, 'id='.$id);
			if ($pro){
				if (countRecord("tbl_product_","product_id=".$pro['id']) <= 0){
					$result = mysql_query("insert into tbl_product_sell (product_id,date_added,last_modified,lang) values ('".$pro['id']."',now(),now(),'".$pro['lang']."')",$conn);
					if ($result){$cnt++;}
				}
			}
		}
		$errMsg = 'Ðã Cập nhật '.$cnt.' phần tử.';
	}else{
		$errMsg = 'Hãy chọn sản phẩm !';
	}
}

$page = $_GET['page'];
$p=0;
if ($page!='') $p=$page;
$where='1=1';
if ($_REQUEST['cat']!='') $where='parent='.$_REQUEST['cat']?>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="act" value="<?=$actConfig?>">
<?
$pageindex = createPage(countRecord($tableConfig,$where),'./?act='.$actConfig.'&cat='.$_REQUEST['cat'].'&page=',$MAXPAGE,$page)?>

<? if ($_REQUEST['code']==1) $errMsg = 'Cập nhật thành công.'?>

<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td height="30" class="smallfont">Trang : <?=$pageindex?></td>
		<td align="right" class="smallfont">
			<?=comboCategory('ddCat',getArrayCategory($tableCategoryConfig),'smallfont',$_REQUEST['cat'],1)?>
			<input type="button" value="Chuyển" class="button" 
				onClick="window.location='./?act=<?=$actConfig ?>&cat='+ddCat.value">
		</td>
	</tr>
</table>

<table border="1" cellpadding="2" bordercolor="#C9C9C9" width="100%">
	<tr>
	  <th width="21" class="title"><input type="checkbox" name="chkall" onClick="chkallClick(this);"></th>
		<th colspan="2" class="title"><a class="title" href="<?=getLinkSort(0)?>">Chức năng</a></th>
		<th width="18" class="title"><a class="title" href="<?=getLinkSort(1)?>">ID</a></th>
		<th width="94" class="title"><a class="title" href="<?=getLinkSort(3)?>">Tiêu đề </a></th>
		<th width="79" class="title"><a class="title" href="<?=getLinkSort(4)?>">Thuộc danh mục</a></th>
		<th width="29" class="title"><a class="title" href="<?=getLinkSort(6)?>">Giá</a></th>
		<th width="43" class="title"><a class="title" href="<?=getLinkSort(6)?>">Mô tả ngắn</a></th>
		<th width="46" class="title"><a class="title" href="<?=getLinkSort(7)?>">Mô tả chi tiết</a></th>
		<th width="54" class="title"><a class="title" href="<?=getLinkSort(10)?>">Thứ tự sắp xếp</a></th>
		<th width="54" class="title"><a class="title" href="<?=getLinkSort(11)?>">Trạng thái mới</a></th>
		<th width="57" class="title"><a class="title" href="<?=getLinkSort(11)?>">Không hiển thị</a></th>
		<th width="49" class="title"><a class="title" href="<?=getLinkSort(12)?>">Ngày tạo lập</a></th>
		<th width="77" class="title"><a class="title" href="<?=getLinkSort(13)?>">Lần hiệu chỉnh trước</a></th>
		<th width="40" class="title"><a class="title" href="<?=getLinkSort(14)?>">Ngôn ngữ</a></th>
	</tr>
  
<?
$sortby = 'order by date_added';
if ($_REQUEST['sortby']!='') $sortby='order by '.(int)$_REQUEST['sortby'];
$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?'desc':'');

$sql="select *,DATE_FORMAT(date_added,'%d/%m/%Y %h:%i') as dateAdd,DATE_FORMAT(last_modified,'%d/%m/%Y %h:%i') as dateModify from $tableConfig where $parentWhereConfig and $where $sortby $direction limit ".($p*$MAXPAGE).",".$MAXPAGE;
$result=mysql_query($sql,$conn);
$i=0;
while($row=mysql_fetch_array($result)){
	$parent = getRecord($tableCategoryConfig,'id = '.$row['parent']);
	$color = $i++%2 ? '#d5d5d5' : '#e5e5e5'?>
  
	<tr>
		<td align="center" bgcolor="<?=$color?>" class="smallfont">
		<input type="checkbox" name="chk[]" value="<?=$row['id']?>"></td>
		<td width="29" align="center" bgcolor="<?=$color?>" class="smallfont">
			<a href="./?act=<?=$actConfig?>_m&cat=<?=$_REQUEST['cat']?>&page=<?=$_REQUEST['page']?>&id=<?=$row['id']?>">Sửa</a>		</td>
		<td width="38" align="center" bgcolor="<?=$color?>" class="smallfont">
			<a 
				onClick="return confirm('Bạn có chắc chắn muốn xóa ?');" 
				href="./?act=<?=$actConfig?>&action=del&page=<?=$_REQUEST['page']?>&id=<?=$row['id']?>"
			>Xóa</a>		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['id']?></td>
		<td bgcolor="<?=$color?>" class="smallfont"><?=$row['name']?></td>
		<td bgcolor="<?=$color?>" class="smallfont"><?=$parent['name']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['price']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['detail_short']!=''?'...':'&nbsp;'?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['detail']!=''?'...':'&nbsp;'?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['sort']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center">
			<input type="checkbox" disabled <?=$row['status1']>0?'checked':''?>>		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center">
			<input type="checkbox" disabled <?=$row['status']>0?'checked':''?>>		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['dateAdd']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['dateModify']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['lang']?></td>
	</tr>
<?
}
?>
</table>

<table width="100%">
	<tr>
		<td width="30%">
<input type="submit" value="Xóa chọn" name="btnDel" onClick="return confirm('Bạn có chắc chắn muốn xóa ?');" class="button">
		</td>
		
	  <td align="right"><!--		<input type="submit" value="Sản phẩm bán chạy" name="btnSell" class="button">	--></td>
	</tr>
</table>



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
	<tr><td class="smallfont"><?='Tổng số hàng : <b>'.countRecord($tableConfig).'</b>'?></td></tr>
</table>
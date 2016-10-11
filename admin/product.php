<? // Config
$tableCategoryConfig = 'tbl_product_category';
$tableConfig         = 'tbl_product';
$actConfig           = 'product';
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
			mysql_query("delete from product_new where product_id='".$id."'",$conn);
			mysql_query("delete from product_special where product_id='".$id."'",$conn);
			
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

/*Sản phẩm mới*/
if (isset($_POST['btnNew'])) {
	$cnt=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$pro = getRecord($tableConfig, 'id='.$id);
			if ($pro){
				if (countRecord("tbl_product_new","product_id=".$pro['id']) <= 0){
					$result = mysql_query("insert into tbl_product_new (product_id,date_added,last_modified,lang,device,machine) values ('".$pro['id']."',now(),now(),'".$pro['lang']."','".$pro['device']."','".$pro['machine']."')",$conn);
					if ($result){$cnt++;}
				}
			}
		}
		$errMsg = 'Ðã Cập nhật <span style="font-family:Tahoma; color:#000000; font-size:12px; font-weight:600">'.$cnt.'</span> phần tử.';
	}else{
		$errMsg = 'Hãy chọn sản phẩm mới!';
	}
}


/*Sản phẩm khuyến mãi*/
if (isset($_POST['btnSpecial'])) {
	$cnt=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$pro = getRecord($tableConfig, 'id='.$id);
			if ($pro){
				if (countRecord("tbl_product_special","product_id=".$pro['id']) <= 0){
					$result = mysql_query("insert into tbl_product_special (product_id,date_added,last_modified,lang,device,machine) values ('".$pro['id']."',now(),now(),'".$pro['lang']."','".$pro['device']."','".$pro['machine']."')",$conn);
					if ($result){$cnt++;}
				}
			}
		}
		$errMsg = 'Ðã Cập nhật <span style="font-family:Tahoma; color:#000000; font-size:12px; font-weight:600">'.$cnt.'</span> phần tử.';
	}else{
		$errMsg = 'Hãy chọn sản phẩm đặc trưng!';
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
			<?=comboCategory('ddCat',getArrayCategoryChild($tableCategoryConfig),'smallfont',$_REQUEST['cat'],1)?>
			<input type="button" value="Chuyển" class="button" 
				onClick="window.location='./?act=<?=$actConfig ?>&cat='+ddCat.value">
		</td>
	</tr>
</table>

<table border="1" cellpadding="2" bordercolor="#C9C9C9" width="100%">
	<tr>
	  <th width="20" class="title"><input type="checkbox" name="chkall" onClick="chkallClick(this);"></th>
		<th class="title" colspan="2" rowspan></th>		
		<th width="23" class="title"><a class="title" href="<?=getLinkSort(1)?>">ID</a></th>
		<th width="186" class="title"><a class="title" href="<?=getLinkSort(3)?>">Tên sản phẩm</a></th>		
		<th width="46" class="title"><a class="title" href="<?=getLinkSort(15)?>">Giá</a></th>
		<!--<th width="46" class="title"><a class="title" href="<?=getLinkSort(19)?>">Đơn vị</a></th>-->
		<th width="82" class="title"><a class="title" href="<?=getLinkSort(4)?>">Thuộc danh mục</a></th>				
		<th width="41" class="title"><a class="title" href="<?=getLinkSort(6)?>">Nội dung ngắn</a></th>
		<th width="41" class="title"><a class="title" href="<?=getLinkSort(7)?>">Chi tiết</a></th>
		<th width="41" class="title"><a class="title" href="<?=getLinkSort(5)?>">Ghi chú</a></th>
		<th width="36" class="title"><a class="title" href="<?=getLinkSort(8)?>">Hình nhỏ</a></th>
		<th width="45" class="title"><a class="title" href="<?=getLinkSort(9)?>">Hình lớn</a></th>
		<th width="35" class="title"><a class="title" href="<?=getLinkSort(10)?>">Thứ tự</a></th>
		<!--<th width="36" class="title"><a class="title" href="<?=getLinkSort(16)?>">Thiết bị</a></th>
		<th width="36" class="title"><a class="title" href="<?=getLinkSort(17)?>">Máy bộ</a></th>-->
		<th width="36" class="title"><a class="title" href="<?=getLinkSort(18)?>">New</a></th>
		<th width="36" class="title"><a class="title" href="<?=getLinkSort(11)?>">Hiển thị</a></th>
		<th width="80" class="title"><a class="title" href="<?=getLinkSort(12)?>">Ngày tạo lập</a></th>
		<th width="80" class="title"><a class="title" href="<?=getLinkSort(13)?>">Lần hiệu chỉnh trước</a></th>
		<th width="47" class="title"><a class="title" href="<?=getLinkSort(14)?>">Ngôn ngữ</a></th>
	</tr>
  
<?
$sortby = 'order by date_added';
if ($_REQUEST['sortby']!='') $sortby='order by '.(int)$_REQUEST['sortby'];
$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?'asc':'');

$sql="select *,DATE_FORMAT(date_added,'%d/%m/%Y %h:%i') as dateAdd,DATE_FORMAT(last_modified,'%d/%m/%Y %h:%i') as dateModify from $tableConfig where $parentWhereConfig and $where $sortby $direction limit ".($p*$MAXPAGE).",".$MAXPAGE;
$result=mysql_query($sql,$conn);
$i=0;
while($row=mysql_fetch_array($result)){
	$parent = getRecord($tableCategoryConfig,'id = '.$row['parent']);
	$color = $i++%2 ? '#d5d5d5' : '#e5e5e5'?>
  
	<tr>
		<td align="center" bgcolor="<?=$color?>" class="smallfont">
		<input type="checkbox" name="chk[]" value="<?=$row['id']?>"></td>
		<td width="25" align="center" bgcolor="<?=$color?>" class="smallfont">
			<a href="./?act=<?=$actConfig?>_m&cat=<?=$_REQUEST['cat']?>&page=<?=$_REQUEST['page']?>&id=<?=$row['id']?>">Sửa</a>		</td>
		<td width="26" align="center" bgcolor="<?=$color?>" class="smallfont">
			<a 
				onClick="return confirm('Bạn có chắc chắn muốn xóa ?');" 
				href="./?act=<?=$actConfig?>&action=del&page=<?=$_REQUEST['page']?>&id=<?=$row['id']?>"
			>Xóa</a>		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['id']?></td>			
		<td bgcolor="<?=$color?>" class="smallfont"><a href="./?act=<?=$actConfig?>_m&cat=<?=$_REQUEST['cat']?>&page=<?=$_REQUEST['page']?>&id=<?=$row['id']?>"><?=$row['name']?></a></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center">
		<font color="#FF0000"><?=number_format($row['price'],0,',','.')?></font></td>	
		<!--<td bgcolor="<?=$color; ?>" class="smallfont" align="center"><?=$row['unit']=='0'?'<font color="#FF0000">VND</font>':'<font color="#FF0000">USD</font>'; ?></td>-->	
		<td bgcolor="<?=$color?>" class="smallfont"><?=$parent['name']?></td>				
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['detail_short']!=''?'...':'&nbsp;'?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['detail']!=''?'...':'&nbsp;'?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['subject']!=''?'...':'&nbsp;'?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['image']!=''?'...':'&nbsp;'?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['image_large']!=''?'...':'&nbsp;'?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['sort']?></td>
		<!--<td bgcolor="<?=$color?>" class="smallfont" align="center">
			<input type="checkbox" disabled <?=$row['device']>0?'checked':''?>>
		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center">
			<input type="checkbox" disabled <?=$row['machine']>0?'checked':''?>>
		</td>-->
		<td bgcolor="<?=$color?>" class="smallfont" align="center">
			<input type="checkbox" disabled <?=$row['new']>0?'checked':''?>>
		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center">
			<input type="checkbox" disabled <?=$row['status']>0?'checked':''?>>
		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=date('d/m/Y',strtotime($row['date_added']))?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=date('d/m/Y',strtotime($row['last_modified']))?></td>
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
<input type="button" value="Thêm mới" name="btnNew" onClick="window.location='./?act=<?=$actConfig?>_m&page=<?=$_REQUEST['page']?>&cat=<?=$_REQUEST['cat']?>'" class="button">
		</td>
		
	  <td align="right">
			<input type="submit" value="Sản phẩm mới" name="btnNew" class="button">
			<input type="submit" value="Sản phẩm bán chạy" name="btnSpecial" class="button">       </td>
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
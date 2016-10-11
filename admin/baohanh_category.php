<? $errMsg =''?>
<?
switch ($_GET['action']){
	case 'del' :
		$id = $_GET['id'];
		$r = getRecord("tbl_baohanh_category","id=".$id);
		$resultParent = mysql_query("select id from tbl_baohanh_category where parent='".$id."'",$conn);
		if (mysql_num_rows($resultParent) <= 0){
			@$result = mysql_query("delete from tbl_baohanh_category where id='".$id."'",$conn);
			if ($result){
				if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
				if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
				$errMsg = "Đã xóa thành công.";
			}else $errMsg = "Không thể xóa dữ liệu !";
		}else{
			$errMsg = "Đang có danh mục sử dụng. Bạn không thể xóa !";	
		}
		break;
}

if (isset($_POST['btnDel'])){
	$cntDel=0;
	$cntNotDel=0;
	$cntParentExist=0;
	if($_POST['chk']!=''){
		foreach ($_POST['chk'] as $id){
			$r = getRecord("tbl_baohanh_category","id=".$id);
			$resultParent = mysql_query("select id from tbl_baohanh_category where parent='".$id."'",$conn);
			if (mysql_num_rows($resultParent) <= 0){
				@$result = mysql_query("delete from tbl_baohanh_category where id='".$id."'",$conn);
				if ($result){
					if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
					if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
					$cntDel++;
				}else $cntNotDel++;
			}else{
				$cntParentExist++;
			}
		}
		$errMsg = "Đã xóa ".$cntDel." phần tử.<br><br>";
		$errMsg .= $cntNotDel>0 ? "Không thể xóa ".$cntNotDel." phần tử.<br>" : '';
		$errMsg .= $cntParentExist>0 ? "Đang có danh mục con sử dụng ".$cntParentExist." phần tử." : '';
	}else{
		$errMsg = "Hãy chọn trước khi xóa !";
	}
}

$page = $_GET["page"];
$p=0;
if ($page!='') $p=$page;
$where="1=1";
if ($_REQUEST['cat']!='') $where="parent=".$_REQUEST['cat']?>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="act" value="baohanh_category">
<?
$pageindex = createPage(countRecord("tbl_baohanh_category",$where),"./?act=baohanh_category&cat=".$_REQUEST['cat']."&page=",$MAXPAGE,$page)?>

<? if ($_REQUEST['code']==1) $errMsg = 'Cập nhật thành công.'?>

<table cellspacing="0" cellpadding="0" width="100%">
	
	<tr>
		<td class="smallfont">Trang : <?=$pageindex?></td>
		<td height="30" align="right" class="smallfont">
			<?=comboCategory('ddCat',getArrayCategory('tbl_baohanh_category'),'smallfont',$_REQUEST['cat'],1)?>
			<input type="button" value="Chuyển" class="button" onClick="window.location='./?act=baohanh_category&cat='+ddCat.value">
		</td>
	</tr>
</table>

<table border="1" cellpadding="2" bordercolor="#C9C9C9" width="100%">
	<tr>
		<th width="20" class="title"><input type="checkbox" name="chkall" onClick="chkallClick(this);"></th>
	<th class="title" nowrap colspan="2"><a class="title" href="<?=getLinkSort(2)?>">Chức năng</a></th>	
		<th width="34" class="title"><a class="title" href="<?=getLinkSort(1)?>">ID</a></th>
		<th width="24" class="title"><a class="title" href="<?=getLinkSort(2)?>">Mã</a></th>
		<th width="163" class="title"><a class="title" href="<?=getLinkSort(3)?>">Tên danh mục</a></th>
		<th width="111" class="title"><a class="title" href="<?=getLinkSort(4)?>">Thuộc danh mục</a></th>
		
		<th width="111" class="title"><a class="title" href="<?=getLinkSort(10)?>">Thứ tự sắp xếp</a></th>
		<th width="102" class="title"><a class="title" href="<?=getLinkSort(11)?>">Không hiển thị</a></th>
		<th width="97" class="title"><a class="title" href="<?=getLinkSort(12)?>">Ngày tạo lập</a></th>
		<th width="103" class="title"><a class="title" href="<?=getLinkSort(13)?>">Lần hiệu chỉnh trước</a></th>
		<th width="46" class="title"><a class="title" href="<?=getLinkSort(14)?>">Ngôn ngữ</a></th>
	</tr>
  
<?
$sortby="order by date_added";
if ($_REQUEST['sortby']!='') $sortby="order by ".(int)$_REQUEST['sortby'];
$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?"desc":"");

$sql="select *,DATE_FORMAT(date_added,'%d/%m/%Y %h:%i') as dateAdd,DATE_FORMAT(last_modified,'%d/%m/%Y %h:%i') as dateModify from tbl_baohanh_category where parent<>0 and $where $sortby $direction limit ".($p*$MAXPAGE).",".$MAXPAGE;
$result=mysql_query($sql,$conn);
$i=0;
while($row=mysql_fetch_array($result)){
	if($row['id']!=2 and $row['id']!=124 and $row['id']!=125)
	{
	
	$parent = getRecord('tbl_baohanh_category','id = '.$row['parent']);
	$color = $i++%2 ? "#d5d5d5" : "#e5e5e5"?>

	<tr>
		<td align="center" bgcolor="<?=$color?>" class="smallfont">
		<input type="checkbox" name="chk[]" value="<?=$row['id']?>"></td>
		<td width="32" align="center" bgcolor="<?=$color?>" class="smallfont">
			<a href="./?act=baohanh_category_m&cat=<?=$_REQUEST['cat']?>&page=<?=$_REQUEST['page']?>&id=<?=$row['id']?>">Sửa</a>		</td>
		<td width="32" align="center" bgcolor="<?=$color?>" class="smallfont">
			<a 
				onClick="return confirm('Bạn có chắc chắn muốn xóa ?');" 
				href="./?act=baohanh_category&action=del&page=<?=$_REQUEST['page']?>&id=<?=$row['id']?>"
			>Xóa</a>		</td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['id']?></td>
		<td bgcolor="<?=$color?>" class="smallfont"><?=$row['code']?></td>
		<td bgcolor="<?=$color?>" class="smallfont"><?=$row['name']?></td>
		<td bgcolor="<?=$color?>" class="smallfont"><?=$parent['name']?></td>
		<!--<td bgcolor="<?=$color?>" class="smallfont"><?=$row['subject']!=''?'...':'&nbsp;'?></td>-->
		<!--<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['detail_short']!=''?'...':'&nbsp;'?></td>-->
		<!--<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['detail']!=''?'...':'&nbsp;'?></td>-->
		<!--<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['image']!=''?'...':'&nbsp;'?></td>-->
		<!--<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['image_large']!=''?'...':'&nbsp;'?></td>-->
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['sort']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['status']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['dateAdd']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['dateModify']?></td>
		<td bgcolor="<?=$color?>" class="smallfont" align="center"><?=$row['lang']?></td>
	</tr>
	
<?
}}
?>
</table>
<input type="submit" value="Xóa chọn" name="btnDel" onClick="return confirm('Bạn có chắc chắn muốn xóa ?');" class="button">
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
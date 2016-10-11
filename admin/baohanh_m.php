<script type="text/javascript" src="../jscripts/FCKeditor/fckeditor.js"></script>
    <script type="text/javascript">
      window.onload = function()
      {		
        var oFCKeditor1 = new FCKeditor('txtlong') ;
        oFCKeditor1.BasePath = "../jscripts/FCKeditor/" ;
		oFCKeditor1.Width = "720" ; 
		oFCKeditor1.Height = "400" ; 
        oFCKeditor1.ReplaceTextarea() ;
      }
</script>
<? // Config
$tableCategoryConfig = 'tbl_baohanh_category';
$tableConfig         = 'tbl_baohanh';
$actConfig           = 'baohanh';
$parentWhereConfig   = 'parent<>0';

$path = "../images/product";
$pathdb = "images/product";
?>
<script language="javascript">
function btnSave_onclick(){
	if(test_empty(document.frmForm.txtName.value)){
		alert('Hãy nhập "tên" !');
		document.frmForm.txtName.focus();
		return false;
	}
	if(test_integer(document.frmForm.txtSort.value)){
		alert('"Thứ tự sắp xếp" phải là số !');
		document.frmForm.txtSort.focus();
		return false;
	}	
	return true;
}
</script>

<? $errMsg =''?>
<?
if (isset($_POST['btnSave'])){
	$code          = isset($_POST['txtCode']) ? trim($_POST['txtCode']) : '';
	$name          = isset($_POST['txtName']) ? trim($_POST['txtName']) : '';
	$parent        = $_POST['ddCat'];
	$price         = isset($_POST['txtPrice']) ? trim($_POST['txtPrice']) : 0;
	$detail_short  = isset($_POST['txtshort']) ? trim($_POST['txtshort']) : '';
	$detail        = isset($_POST['txtlong']) ? trim($_POST['txtlong']) : '';
	$sort          = isset($_POST['txtSort']) ? trim($_POST['txtSort']) : 0;
	$status        = $_POST['chkStatus']!='' ? 1 : 0;
	$status1       = $_POST['chkStatus1']!='' ? 1 : 0;
	
	$catInfo       = getRecord($tableCategoryConfig, 'id='.$parent);
	$lang          = $catInfo['lang'];

	if ($name=="") $errMsg .= "Hãy nhập tên danh mục !<br>";
	$errMsg .= checkUpload($_FILES["txtImage"],".jpg;.gif;.bmp",12024*12024,0);
	$errMsg .= checkUpload($_FILES["txtImageLarge"],".jpg;.gif;.bmp;.zip;.rar;.pdf;.doc;.xls",22048*21024,0);
	
	if ($errMsg==''){
		if (!empty($_POST['id'])){
			$oldid = $_POST['id'];
			$sql = "update ".$tableConfig." set code='".$code."',name='".$name."', parent='".$parent."',detail_short='".$detail_short."',detail='".$detail."', sort='".$sort."', status='".$status."', status1='".$status1."',last_modified=now(), lang='".$lang."', price='".$price."' where id='".$oldid."'";
		}else{
			$sql = "insert into ".$tableConfig." (code, name, parent,detail_short, detail, sort, status, status1,  date_added, last_modified, lang, price,luotxem) values ('".$code."','".$name."','".$parent."','".$detail_short."','".$detail."','".$sort."','".$status."','".$status1."',now(),now(),'".$lang."','".$price."',1)";
		}
		if (mysql_query($sql,$conn)){
			if(empty($_POST['id'])) $oldid = mysql_insert_id();
			$r = getRecord($tableConfig,"id=".$oldid);
			
			$sqlUpdateField = "";
			
			if ($_POST['chkClearImg']==''){
				$extsmall=getFileExtention($_FILES['txtImage']['name']);
				if (makeUpload($_FILES['txtImage'],"$path/".$actConfig."_s".$oldid.$extsmall)){
					@chmod("$path/".$actConfig."_s".$oldid.$extsmall, 0777);
					$sqlUpdateField = " image='$pathdb/".$actConfig."_s".$oldid.$extsmall."' ";
				}
			}else{
				if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
				$sqlUpdateField = " image='' ";
			}
			
			if ($_POST['chkClearImgLarge']==''){
				$extlarge=getFileExtention($_FILES['txtImageLarge']['name']);
				if (makeUpload($_FILES['txtImageLarge'],"$path/".$actConfig."_l".$oldid.$extlarge)){
					@chmod("$path/".$actConfig."_l".$oldid.$extlarge, 0777);
					if($sqlUpdateField != "") $sqlUpdateField .= ",";
					$sqlUpdateField .= " image_large='$pathdb/".$actConfig."_l".$oldid.$extlarge."' ";
				}
			}else{
				if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
				if($sqlUpdateField != "") $sqlUpdateField .= ",";
				$sqlUpdateField .= " image_large='' ";
			}
			//================================================
				if ($_POST['chkClearDownload']==''){
				$extlarge=getFileExtention($_FILES['txtdownload']['name']);
				if (makeUpload($_FILES['txtdownload'],"$path/".$actConfig."_l".$oldid.$extlarge)){
					@chmod("$path/".$actConfig."_l".$oldid.$extlarge, 0777);
					if($sqlUpdateField != "") $sqlUpdateField .= ",";
					$sqlUpdateField .= " download='$pathdb/".$actConfig."_l".$oldid.$extlarge."' ";
				}
			}else{
				if(file_exists('../'.$r['download'])) @unlink('../'.$r['download']);
				if($sqlUpdateField != "") $sqlUpdateField .= ",";
				$sqlUpdateField .= " download='' ";
			}
			
			//================================================
			if($sqlUpdateField!='')	{
				$sqlUpdate = "update ".$tableConfig." set $sqlUpdateField where id='".$oldid."'";
				mysql_query($sqlUpdate,$conn);
			}
		}else{
			$errMsg = "Không thể cập nhật !";
		}
	}

	if ($errMsg == '')
		echo '<script>window.location="./?act='.$actConfig.'&cat='.$_REQUEST['cat'].'&page='.$_REQUEST['page'].'&code=1"</script>';
}else{
	if (isset($_GET['id'])){
		$oldid=$_GET['id'];
		$page = $_GET['page'];
		$sql = "select * from ".$tableConfig." where id='".$oldid."'";
		if ($result = mysql_query($sql,$conn)) {
			$row=mysql_fetch_array($result);
			$code          = $row['code'];
			$name          = $row['name'];
			$parent        = $row['parent'];
			$subject       = $row['subject'];
			$price         = $row['price'];
			$detail_short  = $row['detail_short'];
			$detail        = $row['detail'];
			$image         = $row['image'];
			$image_large   = $row['image_large'];
			$sort          = $row['sort'];
			$status1       = $row['status1'];
			$status        = $row['status'];
			$date_added    = $row['date_added'];
			$last_modified = $row['last_modified'];
			//$price         = $row['price'];
		}
	}
}

?>
<pre id="idTemporary1" name="idTemporary1" style="display:none">
<? if(isset($detail_short)){echo $detail_short;}?>
</pre>

<pre id="idTemporary2" name="idTemporary2" style="display:none">
<? if(isset($detail)){echo $detail;}?>
</pre>

<form method="post" name="frmForm" enctype="multipart/form-data" action="./">
<input type="hidden" name="act" value="<?=$actConfig?>_m">
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
<input type="hidden" name="page" value="<?=$_REQUEST['page']?>">
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#0069A8" width="100%">
	<tr>
    	<td>
    		<table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
				<tr><td height="10"></td></tr>
				<tr>
				  <td colspan="3" align="center">&nbsp;</td>
				</tr>				
				<tr>
					<td width="15%" class="smallfont" align="right">Tiêu đề </td>
					<td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
					<td width="83%" class="smallfont">
						<input value="<?=$name?>" type="text" name="txtName" class="textbox" size="34">					</td>
				</tr>
				
				<!--<tr>
					<td width="15%" class="smallfont" align="right">Gi&aacute; sản phẩm</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input value="<?=$price?>" type="text" name="txtPrice" class="textbox" size="34"> <?=$currencyUnit?>					</td>
				</tr>-->
			<!--	<tr>
					<td width="15%" class="smallfont" align="right">Hình ảnh(nhỏ)</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="file" name="txtImage" class="textbox" size="34">
						<input type="checkbox" name="chkClearImg" value="on"> 
						Xóa bỏ hình ảnh
					(Width=150 Height=100 Kích cỡ <1MB type: jpg,gif,bmp)</td>
				</tr>
				-->
				<tr>
					<td width="15%" class="smallfont" align="right">Tài liệu download </td>
					<td width="1%" class="smallfont" align="center"></td>
				  <td width="83%" class="smallfont">
						<input type="file" name="txtImageLarge" class="textbox" size="34">
					<input type="checkbox" name="chkClearImgLarge" value="on">					 
					 Xóa bỏ file ( zip, rar,pdf) </td>
				</tr>				
				<tr>
					<td width="15%" class="smallfont" align="right">Nội dung </td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<textarea name="txtlong" cols="80" rows="15" id="txtlong"><?=$detail?></textarea>					</td>
				</tr>
				
				<tr>
					<td width="15%" class="smallfont" align="right">Thu&#7897;c Danh m&#7909;c</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<?=comboCategory('ddCat',getArrayCategory($tableCategoryConfig),'smallfont',$parent,0)?>					</td>
				</tr>
				<!--<tr>
					<td width="15%" class="smallfont" align="right">Trạng thái mới</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="checkbox" name="chkStatus1" value="on" <?=$status1>0?'checked':''?>>					</td>
				</tr>-->
				<tr>
					<td width="15%" class="smallfont" align="right">Thứ tự sắp xếp</td>
					<td width="1%" class="smallfont" align="right"></td>
					<td width="83%" class="smallfont">
						<input value="<?=$sort?>" type="text" name="txtSort" class="textbox" size="34">					</td>
				</tr>
				
				<tr>
					<td width="15%" class="smallfont" align="right">Không hiển thị</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="checkbox" name="chkStatus" value="on" <?=$status>0?'checked':''?>>					</td>
				</tr>
				
				<tr>
					<td width="15%" class="smallfont"></td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="submit" name="btnSave" VALUE="Cập nhật" class="button" onclick="return btnSave_onclick()">
						<input type="reset" class=button value="Nhập lại">					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<? if($errMsg!=''){echo '<p align=center class="err">'.$errMsg.'<br></p>';}?>
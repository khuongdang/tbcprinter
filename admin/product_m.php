<script type="text/javascript" src="../jscripts/FCKeditor/fckeditor.js"></script>
    <script type="text/javascript">
      window.onload = function()
      { 
		var oFCKeditor = new FCKeditor( 'txtDetail' ) ;
        oFCKeditor.BasePath = "../jscripts/FCKeditor/" ;
		oFCKeditor.Width = "720" ; 
		oFCKeditor.Height = "400" ; 
        oFCKeditor.ReplaceTextarea() ;
      }
</script>

<? // Config
$tableCategoryConfig = 'tbl_product_category';
$tableConfig         = 'tbl_product';
$actConfig           = 'product';
$parentWhereConfig   = 'parent<>0';

$path = "../images/product";
$pathdb = "images/product";

?>
<?

if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	echo '<script language="javascript" src="../lib/scripts/editor.js"></script>';

else
	echo '<script language="javascript" src="../lib/scripts/moz/editor.js"></script>';
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
	$unit	       = $_POST['cmbUnit'];
	$code          = isset($_POST['txtCode']) ? trim($_POST['txtCode']) : '';
	$name          = isset($_POST['txtName']) ? trim($_POST['txtName']) : '';
	$price         = isset($_POST['txtPrice']) ? trim($_POST['txtPrice']) : 0;
	$parent        = $_POST['ddCat'];
	$subject       = isset($_POST['txtSubject']) ? trim($_POST['txtSubject']) : '';
	$detail_short  = isset($_POST['txtDetailShort']) ? trim($_POST['txtDetailShort']) : '';
	$detail        = isset($_POST['txtDetail']) ? trim($_POST['txtDetail']) : ''; 
	$sort          = isset($_POST['txtSort']) ? trim($_POST['txtSort']) : 0;
	$status        = $_POST['chkStatus']!='' ? 1 : 0;
	$device        = $_POST['chkDevice']!='' ? 1 : 0;
	$machine       = $_POST['chkMachine']!='' ? 1 : 0;
	$new 		   = $_POST['chkNew']!='' ? 1 : 0;	

	$catInfo       = getRecord($tableCategoryConfig, 'id='.$parent);
	$lang          = $catInfo['lang'];

	if ($name=="") $errMsg .= "Hãy nhập tên danh mục !<br>";
	$errMsg .= checkUpload($_FILES["txtImage"],".jpg;.gif;.bmp;.png",500*1024,0);
	$errMsg .= checkUpload($_FILES["txtImageLarge"],".jpg;.gif;.bmp;.png",500*1024,0);
	$errMsg .= checkUpload($_FILES["download"],".jpg;.gif;.bmp;.png,.pdf,.zip,.rar,.gz",12020*12024,0);

	if ($errMsg==''){
		if (!empty($_POST['id'])){
			$oldid = $_POST['id'];
			$sql = "update ".$tableConfig." set code='".$code."',name='".$name."', parent='".$parent."',subject='".$subject."',detail_short='".$detail_short."',detail='".$detail."', sort='".$sort."', status='".$status."',last_modified=now(), lang='".$lang."',price='".$price."', device='".$device."', machine='".$machine."', new='".$new."', unit='".$unit."' where id='".$oldid."'";

		}else{

			$sql = "insert into ".$tableConfig." (code, name, parent, subject, detail_short, detail, sort, status,  date_added, last_modified, lang,price,device,machine,new,unit) values ('".$code."','".$name."','".$parent."','".$subject."','".$detail_short."','".$detail."','".$sort."','".$status."',now(),now(),'".$lang."','".$price."','".$device."','".$machine."','".$new."','".$unit."')";

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
		//======================= Download		
		if ($_POST['ClearDownload']==''){
				$extlarge=getFileExtention($_FILES['download']['name']);
				if (makeUpload($_FILES['download'],"$path/".$actConfig."_dw".$oldid.$extlarge)){
					@chmod("$path/".$actConfig."_l".$oldid.$extlarge, 0777);
					if($sqlUpdateField != "") $sqlUpdateField .= ",";
					$sqlUpdateField .= " download='$pathdb/".$actConfig."_dw".$oldid.$extlarge."' ";
				}
			}else{
				if(file_exists('../'.$r['download'])) @unlink('../'.$r['download']);
				if($sqlUpdateField != "") $sqlUpdateField .= ",";
				$sqlUpdateField .= " download='' ";
		}//==================
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
			$detail_short  = $row['detail_short'];
			$detail        = $row['detail'];
			$image         = $row['image'];
			$image_large   = $row['image_large'];
			$sort          = $row['sort'];
			$status        = $row['status'];
			$device        = $row['device'];
			$machine       = $row['machine'];
			$new 		   = $row['new'];
			$date_added    = date('d/m/Y',strtotime($row['date_added']));
			$last_modified = date('d/m/Y',strtotime($row['last_modified']));
			$price         = $row['price'];
			$unit 		   = $row['unit'];
		}
	}
}
?>

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
				<td colspan="3" align="center">
					<table width="100%">
						<? if($image!='' || $image_large!=''){?>
						<tr>

								<td width="15%"></td>

							<td width="40%" align="center" class="smallfont">
<? if ($image!=''){ echo '<img border="0" src="../'.$image.'" width="100"><br><br>Hình nhỏ';}?>								</td>

								

								<td width="40%" align="center" class="smallfont">

<? if ($image_large!=''){ echo '<img border="0" src="../'.$image_large.'" width="100"><br><br>Hình lớn';}?>								</td>

								<td width="15%"></td>
					  </tr>

							<? }else{echo '<tr><td colspan="3" class="smallfont" align="center">Chưa có hình ảnh</td></tr>';}?>

							<tr><td colspan="4" height="10"></td></tr>

							<tr><td colspan="4" height="1" bgcolor="#999999"></td></tr>

							<tr><td colspan="4" height="10"></td></tr>
				  </table>					</td>
		  </tr> 		  		     						
				<tr>
					<td width="15%" class="smallfont" align="right">Tên sản phẩm</td>
					<td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
					<td width="83%" class="smallfont">
						<input value="<?=$name?>" type="text" name="txtName" class="textbox" size="34">					</td>
				</tr>
				<tr>
					<td width="15%" class="smallfont" align="right">Giá</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input value="<?=$price?>" type="text" name="txtPrice" class="textbox" size="34">&nbsp;<!--<?=comboUnit($unit)?>--></td>
				</tr>					
				<tr><td height="10px"></td></tr>
				<tr>
					<td width="15%" class="smallfont" align="right">Hình nhỏ</td>
					<td width="1%" class="smallfont" align="center"></td>
				  <td width="83%" class="smallfont">
						<input type="file" name="txtImage" class="textbox" size="34">
						<input type="checkbox" name="chkClearImg" value="on"> 
						Xóa bỏ hình ảnh	
						  &nbsp;<span style="font-family:Tahoma; font-size:14; font-weight:600; color:#000000">(Kích thước 96 X 84)</span>				</td>
				</tr>
				
				<tr>

					<td width="15%" class="smallfont" align="right">Hình lớn</td>

					<td width="1%" class="smallfont" align="center"></td>

				  <td width="83%" class="smallfont">

						<input type="file" name="txtImageLarge" class="textbox" size="34">

						<input type="checkbox" name="chkClearImgLarge" value="on"> 
						Xóa bỏ hình ảnh		
						  &nbsp;<span style="font-family:Tahoma; font-size:14; font-weight:600; color:#000000">(Kích thước 200 X 200)</span>				</td>
				</tr>
				<tr>
				  <td class="smallfont" align="right">Download thông tin KT </td>
				  <td class="smallfont" align="center"></td>
				  <td class="smallfont"><input type="file" name="download" class="textbox" size="34">
			      <input type="checkbox" name="ClearDownload" value="on" /> 
			      Size &gt;20MB </td>
		  </tr>
<!--				<tr><td height="10px"></td></tr>
				<tr>
					<td width="15%" class="smallfont" align="right">Nội dung ngắn</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">						 
						<textarea name="txtDetailShort" cols="80" rows="10" id="txtDetailShort"><?=$detail_short?></textarea>					 </td>
				</tr>	-->
				<tr><td height="10px"></td></tr>
				<tr>
					<td width="15%" class="smallfont" align="right">Thông tin chi tiết</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">						 
						<textarea name="txtDetail" cols="80" rows="10" id="txtDetail"><?=$detail?></textarea>		 </td>
				</tr>						
<!--				<tr><td height="10px"></td></tr>
				<tr>
					<td width="15%" class="smallfont" align="right">Ghi chú</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<textarea name="txtSubject" cols="80" rows="10" id="txtSubject"><?=$subject?></textarea>		</td>
				</tr>-->																			
				<tr>
					<td width="15%" class="smallfont" align="right">Thuộc danh mục</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<?=comboCategory('ddCat',getArrayCategoryChild('tbl_product_category'),'smallfont',$parent,0)?>					</td>
				</tr>
				<tr>
					<td width="15%" class="smallfont" align="right">Thứ tự sắp xếp</td>
					<td width="1%" class="smallfont" align="right"></td>
					<td width="83%" class="smallfont">
						<input value="<?=$sort?>" type="text" name="txtSort" class="textbox" size="15">					</td>
				</tr>
				<!--<tr>
					<td width="15%" class="smallfont" align="right">Thiết bị</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="checkbox" name="chkDevice" value="on" <? if ($device>0) echo 'checked' ?>>			</td>
				</tr>
				<tr>
					<td width="15%" class="smallfont" align="right">Máy bộ</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="checkbox" name="chkMachine" value="on" <? if ($machine>0) echo 'checked' ?>>			</td>
				</tr>
				<tr>
					<td width="15%" class="smallfont" align="right">New</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="checkbox" name="chkNew" value="on" <? if ($new>0) echo 'checked' ?>>			</td>
				</tr>-->
				<tr>
					<td width="15%" class="smallfont" align="right">Không hiển thị</td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont">
						<input type="checkbox" name="chkStatus" value="on" <? if ($status>0) echo 'checked' ?>>			</td>
				</tr>
				
				<tr>
					<td width="15%" class="smallfont"></td>
					<td width="1%" class="smallfont" align="center"></td>
					<td width="83%" class="smallfont"><input type="submit" name="btnSave" value="Cập nhật" class="button" onclick="return btnSave_onclick()" />

				    <input type="reset" class="button" value="Nhập lại">					</td>
				</tr>
		  </table>
		</td>
	</tr>
</table>
</form>

<? if($errMsg!=''){echo '<p align=center class="err">'.$errMsg.'<br></p>';}?>
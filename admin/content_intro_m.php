<script type="text/javascript" src="../jscripts/FCKeditor/fckeditor.js"></script>
    <script type="text/javascript">
      window.onload = function()
      {
        var oFCKeditor = new FCKeditor( 'txtDetailShort' ) ;
        oFCKeditor.BasePath = "../jscripts/FCKeditor/" ;
		oFCKeditor.Width = "720" ; 
		oFCKeditor.Height = "300" ; 
        oFCKeditor.ReplaceTextarea() ;						   
      }
</script>

<? // Config
$codeSelect = $multiLanguage == 0 ? "code='".$_lang."_intro'" : "code='vn_intro' or code='en_intro'";
$tableCategoryConfig = 'tbl_content_category';
$tableConfig         = 'tbl_content';
$actConfig           = 'intro';
$arraySourceCombo    = getArrayCombo($tableCategoryConfig,'id','name',$codeSelect);
?>

<?
if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	echo '<script language="javascript" src="../lib/scripts/editor.js"></script>';
else
	echo '<script language="javascript" src="../lib/scripts/moz/editor.js"></script>'?>

<script language="javascript">
function btnSave_onclick(){
	if(test_empty(document.frmForm.txtName.value)){
		alert('Hãy nhập "tên" !');
		document.frmForm.txtName.focus();
		return false;
	}
	
	return true;
}
</script>

<? $errMsg =''?>
<?
$path = "../images/content";
$pathdb = "images/content";
if (isset($_POST['btnSave'])){
	$code          = isset($_POST['txtCode']) ? trim($_POST['txtCode']) : '';
	$name          = isset($_POST['txtName']) ? trim($_POST['txtName']) : '';
	$parent        = $_POST['ddCat'];
	$subject       = isset($_POST['txtSubject']) ? trim($_POST['txtSubject']) : '';
	$detail_short  = isset($_POST['txtDetailShort']) ? trim($_POST['txtDetailShort']) : '';
	$detail        = isset($_POST['txtDetail']) ? trim($_POST['txtDetail']) : '';
	$sort          = isset($_POST['txtSort']) ? trim($_POST['txtSort']) : 0;
	$status        = $_POST['chkStatus']!='' ? 1 : 0;
	
	$catInfo       = getRecord($tableCategoryConfig, 'id='.$parent);
	$lang          = $catInfo['lang'];
	
	if ($name=="") $errMsg .= "Hãy nhập tên danh mục !<br>";
	$errMsg .= checkUpload($_FILES["txtImage"],".jpg;.gif;.bmp",500*1024,0);
	$errMsg .= checkUpload($_FILES["txtImageLarge"],".jpg;.gif;.bmp",500*1024,0);

	if ($errMsg==''){
		if (!empty($_POST['id'])){
			$oldid = $_POST['id'];
			$sql = "update ".$tableConfig." set code='".$code."',name='".$name."', parent='".$parent."',subject='".$subject."',detail_short='".$detail_short."',detail='".$detail."', sort='".$sort."', status='".$status."',last_modified=now(), lang='".$lang."' where id='".$oldid."'";
		}else{
			$sql = "insert into ".$tableConfig." (code, name, parent, subject, detail_short, detail, sort, status,  date_added, last_modified, lang) values ('".$code."','".$name."','".$parent."','".$subject."','".$detail_short."','".$detail."','".$sort."','".$status."',now(),now(),'".$lang."')";
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
			$date_added    = $row['date_added'];
			$last_modified = $row['last_modified'];
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
   	  <td width="45%"><table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
        <tr>
          <td height="10"></td>
        </tr>
       <tr>
			<td colspan="3" align="center"></td>
		</tr>
        <tr>
          <td width="15%" class="smallfont" align="right">Tên giới thiệu</td>
          <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
          <td width="83%" class="smallfont"><input value="<?=$name?>" type="text" name="txtName" class="textbox" size="50" />          </td>
        </tr>
	
		<tr><td height="10"></td></tr>
        <tr>
          <td width="15%" class="smallfont" align="right">Nội dung</td>
          <td width="1%" class="smallfont" align="center"></td>
          <td width="83%" class="smallfont"><textarea name="txtDetailShort" cols="80" rows="10" id="txtDetailShort"><?=$detail_short?>
          </textarea></td>
        </tr>  			
        <tr>
          <td height="10px"></td>
        </tr>	                        		
        <tr>
          <td width="15%" class="smallfont" align="right">Thuộc danh mục</td>
          <td width="1%" class="smallfont" align="center"></td>
          <td width="83%" class="smallfont"><?=comboCategory('ddCat',$arraySourceCombo,'smallfont',$parent,0)?>          </td>
        </tr>   
        <tr>
          <td width="15%" class="smallfont" align="right">Không hiển thị</td>
          <td width="1%" class="smallfont" align="center"></td>
          <td width="83%" class="smallfont"><input type="checkbox" name="chkStatus" value="on" <?=$status>0?'checked':''?> />          </td>
        </tr>
        <tr>
          <td width="15%" class="smallfont"></td>
          <td width="1%" class="smallfont" align="center"></td>
          <td width="83%" class="smallfont"><input type="submit" name="btnSave" value="Cập nhật" class=button onclick="return btnSave_onclick()" />
              <input name="reset" type="reset" class=button value="Nhập lại" />          </td>
        </tr>
      </table></td>
	</tr>
</table>
</form>
<? if($errMsg!=''){echo '<p align=center class="err">'.$errMsg.'<br></p>';}?>
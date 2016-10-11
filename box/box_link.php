<form name="weblink" method="post" action="" target="_blank">
	<select size="1" name="weblink" id="weblink" onchange="if (weblink.value!='') {window.open(weblink.value);weblink.options[0].selected=true}" class="style3" style="border-width: 1px; margin: 4px 0px; width: 160px;">
		<option><?=$_lang=='vn'?'.......Liên kết web.......':'--- Link website ---';?></option>																	
			<?
			$code = $_lang=='vn' ? "vn_link" : "en_link";
			$sql = "select * from tbl_content where status=0 and parent in (select id from tbl_content_category where code='".$code."') order by sort, date_added";
			$result = mysql_query($sql,$conn);
			while($row=mysql_fetch_assoc($result)){
			echo '<option value="'.$row['code'].'">'.$row['name'].'</option>';
			}
			?>
	</select>
</form>
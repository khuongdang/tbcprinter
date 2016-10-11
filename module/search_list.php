<form name="frmSearch" action="./" method="GET" style="margin-bottom:0px">
<table border="0" width="100%" cellSpacing="0" cellPadding="0">
	<tr>
		<td width="352" class="font_blue" align="right"><input type="hidden" name="act" value="search">
<input type="hidden" name="frame" value="search">
Tìm kiếm</td>
		<td width="12" class="font_blue" align="center">:</td>
		<td width="537" class="font_blue">
		<input type="text" name="keyword" style="width: 90%" class="textbox">		</td>
	    <td width="416" class="font_blue"><input type="submit" value="<?=_SEARCH?>"></td>
	</tr>	
	<tr>
		<td class="font_while" align="right">Chọn danh mục</td>
		<td class="font_while" align="center">:</td>
		<td class="font_while">
			<?
			$sourceCombo = getArrayCategory("tbl_product_category");
			echo comboCategory('parent',$sourceCombo,'smallfont',"",1);
			?>		</td>
	    <td class="font_while">&nbsp;</td>
	</tr>	
</table>
</form>
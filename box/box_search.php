<script language="javascript">
function btnSearch_onclick(){
	if(test_empty(document.formSearch.keyword.value)){
		alert(mustInput_Search);document.formSearch.keyword.focus();return false;
	}
	document.formSearch.submit();
	return true;
}
</script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />


<form method="GET" action="./" name="formSearch" style="margin:0px">
	<input type="hidden" name="act" value="search">
	<input type="hidden" name="frame" value="search">
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="right" style="padding-right:5px"><input type="text" name="keyword" id="keyword" class="textbox" style="width:70%"/></td>
		<td height="25"><input type="button" name="btnSearch" value="<?=_SEARCH?>" onclick="return btnSearch_onclick()" class="button"/></td>
	</tr>
	<tr>
	  <td align="right" style="padding-right:5px">&nbsp;</td>
	  <td height="25" class="font_xam"><a href="./?frame=search" class="link_menu_sp">Tìm kiếm nâng cao</a></td>
	  </tr>
</table>
</form>

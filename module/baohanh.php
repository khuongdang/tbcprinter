<?
$id = killInjection($_REQUEST['id']);
if ($id=='') $id = $parentRecord['parent'];
$per_page = 40;
$p=0;
if ($_REQUEST['p']!='') $p=killInjection($_REQUEST['p']);

$sql = "select * from tbl_baohanh where status=0 and parent='".$id."' order by sort,date_added desc limit ".$per_page*$p.",".$per_page;
$result = @mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">			  
              <tr>
                <td align="left" valign="top" class="font_blue">
               <a href="./?frame=download_detail&id=<?=$row["id"]?>" class="link_menu_sp"><b><?=$row["name"]?></b></a></td>
              <tr>
                <td align="left" valign="top"></td>
              <tr>
                <td height="24" align="right" valign="top" style="border-bottom:1px dotted #CCCCCC"><a class="link_menu_sp" href="./?frame=download_detail&id=<?=$row["id"]?>"> &raquo; chi tiết </a></td>
</table>
<? }?>




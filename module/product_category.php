<style type="text/css">
.menutitle{
	text-align:left;
	cursor:pointer;
	color: #333333;
	display: block;
	position: relative; /*To help in the anchoring of the ".statusicon" icon image*/
	width: 180;
	padding: 4px 0;
	padding-left: 5px;
	text-decoration: none;
	background-color: #FFCC66;
	background-image: url(../images/glossyback.gif);
	background-repeat: repeat-x;
	background-position: left bottom;	
	font-size: 12px;
	font-weight: bold;
	border-bottom:1px solid #FF6600;
	
}
.menutitle:hover{
	background-image: url(../images/glossyback2.gif);
	background-repeat: repeat;
	background-position: left bottom;
}

.submenu{
text-align:left;
width:185;
border-right:1px solid #FF6600;
border-left:1px solid #FF6600;

}
</style>

<script type="text/javascript">

/***********************************************
* Switch Menu script- by Martial B of http://getElementById.com/
* Modified by Dynamic Drive for format & NS4/IE4 compatibility
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var persistmenu="yes" //"yes" or "no". Make sure each SPAN content contains an incrementing ID starting at 1 (id="sub1", id="sub2", etc)
var persisttype="sitewide" //enter "sitewide" for menu to persist across site, "local" for this page only

if (document.getElementById){ //DynamicDrive.com change
document.write('<style type="text/css">\n')
document.write('.submenu{display: none;}\n')
document.write('</style>\n')
}

function SwitchMenu(obj){
	if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv").getElementsByTagName("span"); //DynamicDrive.com change
		if(el.style.display != "block"){ //DynamicDrive.com change
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu") //DynamicDrive.com change
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}

function get_cookie(Name) { 
var search = Name + "="
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) { 
offset += search.length
end = document.cookie.indexOf(";", offset);
if (end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}

function onloadfunction(){
if (persistmenu=="yes"){
var cookiename=(persisttype=="sitewide")? "switchmenu" : window.location.pathname
var cookievalue=get_cookie(cookiename)
if (cookievalue!="")
document.getElementById(cookievalue).style.display="block"
}
}

function savemenustate(){
var inc=1, blockid=""
while (document.getElementById("sub"+inc)){
if (document.getElementById("sub"+inc).style.display=="block"){
blockid="sub"+inc
break
}
inc++
}
var cookiename=(persisttype=="sitewide")? "switchmenu" : window.location.pathname
var cookievalue=(persisttype=="sitewide")? blockid+";path=/" : blockid
document.cookie=cookiename+"="+cookievalue
}

if (window.addEventListener)
window.addEventListener("load", onloadfunction, false)
else if (window.attachEvent)
window.attachEvent("onload", onloadfunction)
else if (document.getElementById)
window.onload=onloadfunction

if (persistmenu=="yes" && document.getElementById)
window.onunload=savemenustate

</script>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<div id="masterdiv">
<?php
include_once("lib/func.lib.php");
$cat = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : '';
$catinfo= getRecord("tbl_product_category","id=" . $cat);

$parentCode = $_lang=='vn'?'vn':'en';
$sqlParent = "select * from tbl_product_category where status=0 and parent=(select id from tbl_product_category where code='".$parentCode."') order by sort, date_added";
$resultParent = @mysql_query($sqlParent,$conn);
$i=0;
while($rowParent = mysql_fetch_assoc($resultParent)){
	$isHaveChild = isHaveChild("tbl_product_category", $rowParent['id'])?0:1;
	$i++;
?>
<?php if($rowParent['child']==1)
		{?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" class="bg_product" onMouseOver="this.className='bg_product_hover'" onMouseOut="this.className='bg_product'">
			<a href="./?frame=products&catparent=<?php echo $rowParent['id']?>" class="link_menu_sp"><?php echo $rowParent['name']?></a>
			</td>
		</tr>
		</table>
		<?php }
		else
		{?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" class="bg_product" onMouseOver="this.className='bg_product_hover'" onMouseOut="this.className='bg_product'">
		<div onclick="SwitchMenu('sub<?php echo $i?>')">
	<a href="#1" class="link_menu_sp"><?php echo $rowParent['name']?></a>
			</div>
				</td>
		</tr>
		</table>
		<?php } ?>

<?php
if(isset($_REQUEST['frame']) && $_REQUEST['frame'] =='product_detail'){
	$catinfo = getRecord("tbl_product_category","id = (select parent from tbl_technical where id=".$_REQUEST['id'].")");
}
?>
<div class="submenu" id="sub<?php echo $i?>" style="float:left">
<?php
$sqlChild = "select * from tbl_product_category where status=0 and parent='".$rowParent['id']."' order by sort, date_added";
$resultChild = @mysql_query($sqlChild,$conn);
while($rowChild = mysql_fetch_assoc($resultChild)){
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
	 <td align="left" class="bg_product_sub" onMouseOver="this.className='bg_product_sub_hover'" onMouseOut="this.className='bg_product_sub'">
	 <a href="./?frame=product&cat=<?php echo $rowChild['id']?>" class="link_menu_sp"><?php echo $rowChild['name']?></a>
	 </td>
 	</tr>
	</table>
<?php }?>
</div>

<?php }?>
</div>
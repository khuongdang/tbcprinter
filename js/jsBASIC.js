/*******************************************************
*  BASIC Template Engine is a simple template engine   *
*  Copyright @ 2007 the phpGroupVN                     *
*  website: www.phpbasic.com                           *
*  Email: admin@phpbasic.com                           *
*********************************************************/
/* BASIC JScript 
Inherit: AJAX JScript */
//function nav(str,clear) { $msgId((clear?'':$getId($conf['nav_id']).innerHTML)+(clear?'':$conf['nav_space'])+str,$conf['nav_id']);}
/*Fix URL href 
<a href="basic.html#view" rel="id" => <a href="#view" onclick="ajaxLoad('basic.html',id);"
<a href="basic.html#view" rev="id" => <a href="#view" onclick="document.getElementById(id).style.display='none';"
*/
function BASIC_Switch(prefix,command,type_or_id,value){
	switch(prefix){
		
		case 'basic':/* id = BASIC_..... */
			switch(command){
				case 'bbcode': BASIC_BBCode(type_or_id); // type_or_id = bold,italic,...
					break;
				case 'ajax': BASIC_Ajax(type_or_id,value); //type_or_id = id, value = url
					break;
				case 'hide': BASIC_Display(type_or_id,'none'); // type_or_id = id, style.display = none
					break;
				case 'show': BASIC_Display(type_or_id,'');// type_or_id = id, style.display = ''
					break;
				case 'decrease': BASIC_Height_TextArea(type_or_id,'-'); 
					break;
				case 'increase': BASIC_Height_TextArea(type_or_id,'+'); 
					break;	
				case 'bgcolor': BASIC_BgColor(type_or_id,'#eee')
					break;
				default: 
					break;
			}		
			break;
		
		default: return false;
			break;
	}
	return true;
}
function BASIC_Focus(id) {
	$getId(id).focus();
}
function BASIC_Ajax(id,url) { 
	BASIC_Display(id,'');
	switch(id){
		case 'comment':$(url,id,'BASIC_Focus("'+id+'");BASIC_Onload();BASIC_LoadCacheAuthor();');
				break;
		default: $(url,id,'BASIC_Focus("'+id+'");BASIC_Onload();');
			break;
	}
	
}

function BASIC_Display(id,display_style){ 
	$getId(id).style.display = display_style;
}
function BASIC_Height_TextArea(textarea_id,operator) {
	if(operator=='+') $getId(textarea_id).rows += 5;
	else $getId(textarea_id).rows -= 5;
}
function BASIC_HeightContent(pID){  
	$getId(pID).style.height="auto";
	if (document.all) return $getId(pID).offsetHeight+10;
	return $getId(pID).offsetHeight;
}
function BASIC_DisableButton(btnId,msg){
	param=document.getElementById(btnId);
	param.disabled=true;
	param.value=msg;
}
function BASIC_IncreaseDisucss(id,step){
	$getId(id).innerHTML = $getId(id).innerHTML*1 + step;
}
function BASIC_BgColor(id,color){
	$getId(id).style.bgcolor = color;
}
function BASIC_LoadCacheKeyWord(){
	document.frmSearch.q.value = BASIC_GetCookie('SearchKeyWord');	
}
function BASIC_LoadCacheAuthor(){
	document.formName.author.value = BASIC_GetCookie('AuthorForm');	
}
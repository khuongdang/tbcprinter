/*******************************************************
*  BASIC Template Engine is a simple template engine   *
*  Copyright @ 2007 the phpGroupVN                     *
*  website: www.phpbasic.com                           *
*  Email: admin@phpbasic.com                           *
*********************************************************/
function BASIC_GetCookie(Name){ 
	var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
		return decodeURIComponent(document.cookie.match(re)[0].split("=")[1]) //return its value
	return ""
}

function BASIC_SetCookie(name, value, days){
	if (typeof days!="undefined"){ //if set persistent cookie
		var expireDate = new Date()
		var expstring=expireDate.setDate(expireDate.getDate()+days)
		document.cookie = name+"="+encodeURIComponent(value)+"; expires="+expireDate.toGMTString()
	}
	else //else if this is a session only cookie
		document.cookie = name+"="+value
}

/* handleHREF */
function BASIC_HREF(){
	obj	= document.getElementsByTagName('a'); 
	for(i=0;i<obj.length;i++) {
		href 	= obj[i].getAttribute("href").replace(/^http:\/\/[^\/]+\//i, "http://"+window.location.hostname+"/")
		id		= obj[i].getAttribute("id");
		if(id) { 
			obj[i].onclick = function() {
				var aID = this.id.split('_');
				return (!BASIC_Switch(aID[0],aID[1],aID[2],this.href));
				//return false;
				}
			}
		}
	}
/* handleIMG */

function BASIC_IMG(){
	var obj =document.getElementsByTagName('img');
	for(i=0;i<obj.length;i++){
		var id = obj[i].getAttribute("id");
		if(id){
			obj[i].onclick = function() {  
				var aID = this.id.split('_');
				return(!BASIC_Switch(aID[0],aID[1],aID[2]));
			}
		}
	}
}
function BASIC_HOVER(tag,css_on,css_off){
	var obj = document.getElementsByTagName(tag);
	for(i=0;i<obj.length;i++){
		if(obj[i].className == css_off){
			obj[i].onmouseover = function() {
				this.className = css_on;
			}
			obj[i].onmouseout = function() {
				this.className = css_off;
			}			
		}
	}
}
function BASIC_AUTOFILL(tag,css_on,css_off){
	var obj = document.getElementsByTagName(tag);
	for(i=0;i<obj.length;i++){
		if(obj[i].className == css_off){
			if(i%2) obj[i].className = css_on;
			else obj[i].className = css_off;
		}
	}
}
/* Onload JS */
function BASIC_Onload(){
	BASIC_IMG();
	BASIC_HREF();
	BASIC_LoadCacheKeyWord();
	BASIC_HOVER('div','basic_on','basic_off');
	BASIC_AUTOFILL('p','title_on','title_off');
}
/*******************************************************
*  BASIC Template Engine is a simple template engine   *
*  Copyright @ 2007 the phpGroupVN                     *
*  website: www.phpbasic.com                           *
*  Email: admin@phpbasic.com                           *
*********************************************************/
/* AJAX JScript */
function $getId(id) { if(document.getElementById(id)) return document.getElementById(id);} /* getElementById() */
function $setId(str,id) { document.getElementById(id).innerHTML = str;} /* Show Message with 1 ID */
function $(url,id,eval_str){
	if(document.getElementById){var x=(window.ActiveXObject)?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest();}
	if(x){x.onreadystatechange=function() {
		el=document.getElementById($conf['loading_id']); 
		el.innerHTML=$conf['loading'];
		if(x.readyState==4&&x.status==200){
			el.innerHTML=''; 
			el=document.getElementById(id);
			el.innerHTML=x.responseText; 
			eval(eval_str);
			}
		}
	x.open("GET",url,true);x.send(null);
	}
}

/* Sent Data to server */
function $$(url,id, parameters) { 
http_request = false; 
if (window.XMLHttpRequest) { // Mozilla, Safari,... 
http_request = new XMLHttpRequest(); 
if (http_request.overrideMimeType) { 
http_request.overrideMimeType('text/html'); 
} 
} else if (window.ActiveXObject) { // IE 
try { 
http_request = new ActiveXObject("Msxml2.XMLHTTP"); 
} catch (e) { 
try { 
http_request = new ActiveXObject("Microsoft.XMLHTTP"); 
} catch (e) {} 
} 
} 
if (!http_request) { 
alert('Cannot create XMLHTTP instance'); 
return false; 
} 
http_request.onreadystatechange = function() 
   { 
       $setId($conf['loading'],$conf['loading_id']); 
       if (http_request.readyState == 4) { 
       if (http_request.status == 200) { 
       //alert(http_request.responseText); 
       result = http_request.responseText; 
       $setId('',$conf['loading_id']); $setId(result,id);
       } else { 
       alert('There was a problem with the request.'); 
	   return false;
       } 
       } 
   } 
http_request.open('POST', url, true); 
http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
http_request.setRequestHeader("Content-length", parameters.length); 
http_request.setRequestHeader("Connection", "close"); 
http_request.send(parameters); 
return true;
}
function BASIC_Post(type,id){ 
	switch(type){
		case 'discuss':
			poststr="BASIC_DATA="+	encodeURIComponent(document.getElementById("idArticle").value)+
							"$@BASIC_DATA_SPACE@$"+	encodeURIComponent(document.getElementById("author").value)+
							"$@BASIC_DATA_SPACE@$"+	encodeURIComponent(document.getElementById("author_id").value)+
							"$@BASIC_DATA_SPACE@$"+encodeURIComponent(document.getElementById("frmcontent").value);
			
			if($$('./?php=discuss&basic=insert&id=com',id,poststr)){
				BASIC_IncreaseDisucss('posts',1);
				//BASIC_Display('comment','none');
			}
			break;
		case 'article':
			poststr="BASIC_DATA="+	encodeURIComponent(document.getElementById("idTutorial").value)+
							"$@BASIC_DATA_SPACE@$"+	encodeURIComponent(document.getElementById("name").value)+
							"$@BASIC_DATA_SPACE@$"+	encodeURIComponent(document.getElementById("author").value)+
							"$@BASIC_DATA_SPACE@$"+	encodeURIComponent(document.getElementById("author_id").value)+
							"$@BASIC_DATA_SPACE@$"+encodeURIComponent(document.getElementById("frmcontent").value);
			
			if($$('./?php=discuss&basic=insert_article&id=com',id,poststr)){
				
			}
		
			break;
		default: break;
	}
	//hidden DIV id="comment"
	BASIC_Display('comment','none');
}
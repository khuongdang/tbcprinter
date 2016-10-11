/*******************************************************
*  BASIC Template Engine is a simple template engine   *
*  Copyright @ 2007 the phpGroupVN                     *
*  website: www.phpbasic.com                           *
*  Email: admin@phpbasic.com                           *
*********************************************************/
/* Init Valid*/
function BASIC_Empty(str){
	if(str.length) return false;
	return true;
}
function BASIC_MinLength(str,value){
	if(str.length<value) return true;
	return false;
}
function BASIC_MaxLength(str,value){
	if(str.length>value) return true;
	return false;
}

function BASIC_ValidDiscuss(doc){
	if(doc.author.value=='')  { alert('Nhập tên tác giả');doc.author.focus(); return false; } 
	if(BASIC_MinLength(doc.content.value,20))  { alert('Nhập Nội dung(ít nhất 20 ký tự)');doc.content.focus(); return false; } 
	return true;	
}

function BASIC_ValidArticle(doc){
	if(doc.name.value=='')  { alert('Nhập tên Bài viết');doc.name.focus(); return false; } 
	if(BASIC_MinLength(doc.content.value,20))  { alert('Nhập Nội dung(ít nhất 20 ký tự)');doc.content.focus(); return false; } 
	if(doc.author.value=='')  { alert('Nhập tên tác giả');doc.author.focus(); return false; } 
	return true;	
}
function BASIC_ValidRegister(doc){
	if(doc.username.value=='')  { alert('Nhập Username');doc.username.focus(); return false; } 
	if(BASIC_MinLength(doc.username.value,2) || BASIC_MaxLength(doc.username.value,12))  { 
		alert('Username phải từ 2-12 ký tự');doc.username.focus(); return false; 
	} 
	if(doc.email.value=='')  { alert('Nhập Email');doc.email.focus(); return false; } 
	
	if(doc.password.value=='')  { alert('Nhập Password');doc.password.focus(); return false; } 
	if(BASIC_MinLength(doc.password.value,6) || BASIC_MaxLength(doc.password.value,20))  { 
		alert('Username phải từ 6-20 ký tự');doc.password.focus(); return false; 
	} 
	if(doc.password.value!=doc.retype_pass.value)  { alert('Password và Retype-password phải giống nhau');doc.retype_pass.focus(); return false; } 
	return true;	
}
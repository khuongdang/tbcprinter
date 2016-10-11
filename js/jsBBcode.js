/*******************************************************
*  BASIC Template Engine is a simple template engine   *
*  Copyright @ 2007 the phpGroupVN                     *
*  website: www.phpbasic.com                           *
*  Email: admin@phpbasic.com                           *
*********************************************************/
/* BASIC JScript 
Inherit: AJAX JScript */
function BASIC_BBCode(code){
	switch(code){
		case 'bold': BASIC_InsertTag('[b]','[/b]','Bold'); break;
		case 'italic': BASIC_InsertTag('[i]','[/i]','Italic');break;
		case 'underline': BASIC_InsertTag('[u]','[/u]','Underline');break;
		case 'quote': BASIC_InsertTag('[quote]','[/quote]','Quote');break;
		case 'image': BASIC_Insert('image','Image URL (http://)');break;
		case 'link': BASIC_Insert('link','Link URL(http://)');break;
		default: break;
	}
}
function BASIC_Insert(obj,title){
	switch(obj){
		case 'image': src = prompt(title,'');
					if(src) BASIC_InsertTag('[img="'+src+'"]','','');
					break;
		case 'link':url = prompt(title,'');
					if(url) BASIC_InsertTag('[url="'+url+'"]','[/url]','Click here');
					break;
		default: break;
		}
	}
function BASIC_InsertTag(tagOpen, tagClose, sampleText) {
	var clientPC = navigator.userAgent.toLowerCase(); // Get client info
	var is_gecko = ((clientPC.indexOf('gecko')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('khtml') == -1) && (clientPC.indexOf('netscape/7.0')==-1));
	var areas = document.getElementsByTagName('textarea');
	var txtarea = areas[0];
	if (document.selection  && !is_gecko) {
		var theSelection = document.selection.createRange().text;
		if (!theSelection) {
			theSelection=sampleText;
		}
		txtarea.focus();
		if (theSelection.charAt(theSelection.length - 1) == " ") { // exclude ending space char, if any
			theSelection = theSelection.substring(0, theSelection.length - 1);
			document.selection.createRange().text = tagOpen + theSelection + tagClose + " ";
		} else {
			document.selection.createRange().text = tagOpen + theSelection + tagClose;
		}
	// Mozilla
	} else if(txtarea.selectionStart || txtarea.selectionStart == '0') {
		var replaced = false;
		var startPos = txtarea.selectionStart;
		var endPos = txtarea.selectionEnd;
		if (endPos-startPos) {
			replaced = true;
		}
		var scrollTop = txtarea.scrollTop;
		var myText = (txtarea.value).substring(startPos, endPos);
		if (!myText) {
			myText=sampleText;
		}
		var subst;
		if (myText.charAt(myText.length - 1) == " ") { // exclude ending space char, if any
			subst = tagOpen + myText.substring(0, (myText.length - 1)) + tagClose + " ";
		} else {
			subst = tagOpen + myText + tagClose;
		}
		txtarea.value = txtarea.value.substring(0, startPos) + subst +
			txtarea.value.substring(endPos, txtarea.value.length);
		txtarea.focus();
		if (replaced) {
			var cPos = startPos+(tagOpen.length+myText.length+tagClose.length);
			txtarea.selectionStart = cPos;
			txtarea.selectionEnd = cPos;
		} else {
			txtarea.selectionStart = startPos+tagOpen.length;
			txtarea.selectionEnd = startPos+tagOpen.length+myText.length;
		}
		txtarea.scrollTop = scrollTop;
	}
	if (txtarea.createTextRange) {
		txtarea.caretPos = document.selection.createRange().duplicate();
	}
}
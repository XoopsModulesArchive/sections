/*
*   Samuels [Xoops Project] 
*   based on Justin Koivisto [W.A. Fisher Interactive] Koivi editor
*
*
*	V 0.95 beta 24/Sep/2004 17:39
*
*/


var viewMode=1; // WYSIWYG
var editors = new Array();//ACTIVE EDITORS
var isie;
var url;

//init wysiwyg editor
function XK_Init(id, isiexplore, editorurl)
{
	var IframeId="iframe"+id;
	isie=isiexplore;
	url=editorurl;
	time=100;
	 
	if(isie)
	{
		if (document.readyState != 'complete')
		{
       		setTimeout(function(){XK_Init(id,isiexplore, url);},20);
       		return;
     	}
	}
		
	if (!XK_registered(id))
	{   		
		editors[editors.length] = id;	
	}
	
	//try if mozilla is ready to go
	try {
			document.getElementById(IframeId).contentWindow.document.designMode="On";
		} 
	catch (e) 
		{
			time=time+1000;
			setTimeout( XK_Init(id,isiexplore,url), time);
		}
		
	//update hidden text fields on submit
	XK_OnSubmitHandler(id);
	
	//update iframes with textfields values
	XK_InsertText(id);
		
	//destroy <p></p> on enter 
	if (isie)XK_destroyPTag(id);
};

//update iframe on init
function XK_InsertText(Id)
{
	var IframeId="iframe"+Id;
	//replace <strong>,<me> tags by <b><li> and others used by mozilla
	var my_content=XK_toWYSIWYG(document.getElementById(Id).value);
	
	//write content into iframe
	document.getElementById(IframeId).contentWindow.document.open();
	document.getElementById(IframeId).contentWindow.document.write(my_content);
	document.getElementById(IframeId).contentWindow.document.close();
};

function XK_destroyPTag(Id)
{
	var IframeId="iframe"+Id;
	
		document.getElementById(IframeId).contentWindow.document.onkeydown = function () 
			{ 
				if ((document.getElementById(IframeId).contentWindow.event.keyCode == 13) && !(document.getElementById(IframeId).contentWindow.document.queryCommandState( "insertunorderedlist" )) && !(document.getElementById(IframeId).contentWindow.document.queryCommandState( "insertorderedlist" )) && !(XK_IsInsideThisTag(Id,"BLOCKQUOTE")))						
				{
					document.getElementById(IframeId).contentWindow.event.cancelBubble = true; 
					document.getElementById(IframeId).contentWindow.event.returnValue = false;
					XK_InsertHTML("<br>",Id);
					return false;
				}
				else return;
			};
			
};

function XK_registered(Id)
{
    var found = false;
    for(i=0;i<editors.length;i++)
    {
	  if ((editors[i]).toUpperCase() == Id.toUpperCase())
      {
        found = true;
        break;
      }
    }
    return(found);
};

//update textfields on submit
function XK_OnSubmitHandler(Id)
{
    var sTemp = "";
    oForm = document.getElementById(Id).form;
    if(oForm.onsubmit != null) {
      sTemp = oForm.onsubmit.toString();
      iStart = sTemp.indexOf("{") + 2;
      sTemp = sTemp.substr(iStart,sTemp.length-iStart-2);
    }
    if (sTemp.indexOf("XK_UpdateFields();") == -1)
    {
      oForm.onsubmit = new Function("XK_UpdateFields();" + sTemp);
    }
};

function XK_UpdateFields()
{
	var text;
    for (i=0; i<editors.length; i++)
    {
	  text=document.getElementById("iframe"+editors[i]).contentWindow.document.body.innerHTML;
	  document.getElementById(editors[i]).value = XK_toXHTML(text);
    }
};

//in developement
function XK_ContextualMenu(Id)
{
	var IframeId="iframe"+Id;
	
		document.getElementById(IframeId).contentWindow.document.oncontextmenu = function () 
			{ 
				//1º To know the element
				//2º Build a context Menu
				//3º Show Menu
			};
};

function XK_removeFormat(Id,option)
{
	var IframeId='iframe'+Id;
	var text=document.getElementById(IframeId).contentWindow.document.body.innerHTML;
	if (text=='')return;
	
	switch(option)
	{
		case 'word':
		text=XK_cleanWORD(text);
		break;
		
		case 'span':
		text= text.replace(/<\/?span[^>]*>/gi,'');
		break;
		
		case 'font':
		text= text.replace(/<\/?font[^>]*>/gi,'');
		
		break;
		
		case 'div':
		text= text.replace(/<\/?div[^>]*>/gi,'');
		break;
		
		case 'style':
		text= text.replace(/<([\w]+)style=\"([^\"]*)\"([^>]*)/gi,"<$1$3");
		break;
	}
	document.getElementById(IframeId).contentWindow.document.body.innerHTML=text;
	document.getElementById('RemoveFormat'+Id).style.display="none";
};
 
function XK_cleanWORD(text) {
	if (text.indexOf('Mso') >= 0) { 
 
		// make one line 
		text = text.replace(/\r\n/g, ' '). 
			replace(/\n/g, ' '). 
			replace(/\r/g, ' '). 
			replace(/\&nbsp\;/g,' '); 
 
		// keep tags, strip attributes 
		text = text.replace(/ class=[^\s|>]*/gi,''). 
			//replace(/<p [^>]*TEXT-ALIGN: justify[^>]*>/gi,'<p align="justify">'). 
			replace(/: style=\"[^>]*\"/gi,''). 
			replace(/ align=[^\s|>]*/gi,''); 
 
		//clean up tags 
		text = text.replace(/<b [^>]*>/gi,'<b>'). 
			replace(/<i [^>]*>/gi,'<i>'). 
			replace(/<li [^>]*>/gi,'<li>'). 
			replace(/<ul [^>]*>/gi,'<ul>'); 
 
		// replace outdated tags 
		text = text.replace(/<b>/gi,'<strong>'). 
			replace(/<\/b>/gi,'</strong>'); 
 
		// mozilla doesn't like <em> tags 
		text = text.replace(/<em>/gi,'<i>'). 
			replace(/<\/em>/gi,'</i>'); 
 
		// kill unwanted tags 
		text = text.replace(/<\?xml:[^>]*>/g, '').    // Word xml 
			replace(/<\/?st1:[^>]*>/g,'').     // Word SmartTags 
			replace(/<\/?[a-z]\:[^>]*>/g,'').  // All other funny Word non-HTML stuff 
			replace(/<\/?span[^>]*>/gi,' '). 
			replace(/<\/?div[^>]*>/gi,' '). 
			replace(/<\/?pre[^>]*>/gi,' '). 
			replace(/<\/?h[1-6][^>]*>/gi,' '); 
 
		//remove empty tags 
		text = text.replace(/<strong><\/strong>/gi,''). 
		      replace(/<i><\/i>/gi,''). 
		      replace(/<P[^>]*><\/P>/gi,''); 
 
		// nuke double tags 
		oldlen = text.length + 1; 
		while(oldlen > text.length) { 
			oldlen = text.length; 
			// join us now and free the tags, we'll be free hackers, we'll be free... ;-) 
			text = text.replace(/<([a-z][a-z]*)> *<\/\1>/gi,' '). 
				replace(/<([a-z][a-z]*)> *<([a-z][^>]*)> *<\/\1>/gi,'<$2>'); 
		} 
		text = text.replace(/<([a-z][a-z]*)><\1>/gi,'<$1>'). 
			replace(/<\/([a-z][a-z]*)><\/\1>/gi,'<\/$1>'); 
 
		// nuke double spaces 
		text = text.replace(/  */gi,' ');
	return text;
	}
	return text; 
};


function XK_DoTextFormat(command, option,id)
{
	var IframeId="iframe"+id;  
	if(!isie) document.getElementById(IframeId).contentWindow.document.execCommand("usecss",false,true); 
	
	switch(command)
	  {		
		case "quote":
			XK_addCodes(command,id);
			break;
			
		case "code":
			XK_addCodes(command,id);
			break;
			
		case "insertimage":
			XK_InsertImage(id);
			break;
		
		case "fontsize":
			XK_FontFormat(command,option,id);
			break;
		
		case "fontname":
			XK_FontFormat(command,option,id);
			break;
			
		case "formatblock":
			XK_FontFormat(command,option,id);
			break;
			
 		default:
        	if(document.getElementById(IframeId).contentWindow.document.queryCommandEnabled(command))
			{
			  document.getElementById(IframeId).contentWindow.document.execCommand(command, false, option);
			  document.getElementById(IframeId).contentWindow.focus();
              return true;
        	}
			else 
			return false;
			break;
	  }
};

function XK_FontFormat(command,option,id)
{
	var IframeId="iframe"+id;
	if(document.getElementById(IframeId).contentWindow.document.queryCommandEnabled(command))
	{
		document.getElementById(IframeId).contentWindow.document.execCommand(command, false, option);
		document.getElementById(command+id).value="";
		document.getElementById(IframeId).contentWindow.focus();
	}
};

//called from colorpalette
function XK_ApplyColor(id,name,color)
{
	var option=document.getElementById('coloroption'+id).value;
	switch(option)
	{
		case "forecolor":
		XK_ForeColor(id, name, color);
		break;
		
		case "hilitecolor":
		XK_HiliteColor(id, name, color);
		break;
		
		case "cellcolor":
		XK_CellColor(id, name, color);
		break;
	}
	XK_showHideDiv(id, 'colorPalette', name);
	return;
}

function XK_Color(id,buttonid,option)
{
	document.getElementById('coloroption'+id).value=option;
	if (option!='cellcolor')
	XK_showHideDiv(id, buttonid, 'colorPalette');
	else if(XK_isInsideCell(id))
	XK_showHideDiv(id, buttonid, 'colorPalette');
}

function XK_ForeColor(Id, name, color) {
	
	
	var IframeId="iframe"+Id;
	document.getElementById(IframeId).contentWindow.document.execCommand('forecolor', false, color);
	return;
};

function XK_HiliteColor(Id, name, color) {
	
	var IframeId="iframe"+Id;
	if (!isie)
	{
		document.getElementById(IframeId).contentWindow.document.execCommand("usecss",false,false);
		document.getElementById(IframeId).contentWindow.document.execCommand('hilitecolor', false, color);
		document.getElementById(IframeId).contentWindow.document.execCommand("usecss",false,true);
	}
	else document.getElementById(IframeId).contentWindow.document.execCommand('backcolor', false, color);
	return;
};


//makes a XoopsCode div or XoopsQuote div and puts inside it the selected text
function XK_addCodes(xoops,Id) 
{
	var IframeId="iframe"+Id;
	var text = XK_GetSelectedText(Id);
	document.getElementById(IframeId).contentWindow.focus();

	
	if (text=="")text="&nbsp;";
	
	if (xoops=="quote")
	{
		var text="<div class=xoopsQuote style=\"border: 1px inset #000080; padding:6px;\">"+text+"</div>";
	}
	else if (xoops=="code")
	{
		var text="<div class=\"xoopsCode\" style=\"border:1px inset #000080; padding:6px;\">"+text+"</div>";
	}
	
	XK_InsertHTML(text,Id);		
};

function XK_InsertImage(Id,src,alt)
{
	var IframeId="iframe"+Id;
	document.getElementById(IframeId).contentWindow.focus();
	if (src==null) 
	{
		var image = prompt("Image source.",'http://');
		alt = "&nbsp;";
	}
	else var image = src;
	
	if (image!='http://' && image!=null)
	XK_InsertHTML("<img src="+image+" alt=\""+alt+"\">",Id);

	return;
};

function XK_InsertAnchor(Id)
{
	var IframeId="iframe"+Id;
	var name = prompt("Anchor.",'Id');
	
	document.getElementById(IframeId).contentWindow.focus();
	XK_InsertHTML("<img alt=\x22anchor\x22 id=\""+name+"\" title=\""+name+"\" src=\""+url+"/skins/common/anchor.gif\" />",Id);
	return;
};

function XK_Print(Id)
{
	var IframeId="iframe"+Id;
	if (isie)document.getElementById(IframeId).contentWindow.document.execCommand('Print');

	else document.getElementById(IframeId).contentWindow.print();

};

function XK_InsertSymbol(symbol,id)
{
	var IframeId="iframe"+id;
	document.getElementById('insertsymbol'+id).value="";
	document.getElementById(IframeId).contentWindow.focus();
	XK_InsertHTML(symbol,id);
};

function XK_InsertParagraph(Id)
{
	var IframeId="iframe"+Id;
	document.getElementById(IframeId).contentWindow.focus();
	XK_InsertHTML('<p></p>',Id);
};


//This function is usefull for inserting html outside of format tags
//for example, a table never will be inside <em></em> tags for xhtml compilance
function XK_InsertWithoutFormat(Id,html)
{
	var IframeId="iframe"+Id;
	//Remove format on current selection
	XK_DoTextFormat("removeformat", false,Id);
	
	//Insert a temp object
	document.getElementById(IframeId).contentWindow.document.execCommand("insertimage", false, "#_-#INSERT_OBJECT_HERE#-_#");
	
	//Replace object with html
	var text =document.getElementById(IframeId).contentWindow.document.body.innerHTML;
	var re =/<img src="#_-#INSERT_OBJECT_HERE#-_#">/gi;
	text= text.replace(re,html);
	
	//Update  text
    document.getElementById(IframeId).contentWindow.document.body.innerHTML = text;
	return;
	
};

//not tested
function XK_checkspell()
{
    
    if(isie)
    {
    	try	
    	{
			var tmpis = new ActiveXObject("ieSpell.ieSpellExtension");
			tmpis.CheckAllLinkedDocuments(document);
    	}
    	catch(exception)
    	{
        	if(exception.number==-2146827859)
  			{
            	if(confirm("ieSpell not detected.  Click Ok to go to download page."))
 					window.open("http://www.iespell.com/download.php","Download");
 			}
 			else alert("Error Loading ieSpell: Exception " + exception.number);
        }       

    }    
    else window.open("http://spellbound.sourceforge.net./install.html#header","SpellBound");
};

function XK_getOffsetLeft(elm) {
	var mOffsetLeft = elm.offsetLeft;
	var mOffsetParent = elm.offsetParent;
	
	while(mOffsetParent) {
		mOffsetLeft += mOffsetParent.offsetLeft;
		mOffsetParent = mOffsetParent.offsetParent;
	}
	return mOffsetLeft;
};

function XK_getOffsetTop(elm) {
	var mOffsetTop = elm.offsetTop;
	var mOffsetParent = elm.offsetParent;
	
	while(mOffsetParent){
		mOffsetTop += mOffsetParent.offsetTop;
		mOffsetParent = mOffsetParent.offsetParent;
	}
	return mOffsetTop;
};

//to know if a range is inside a tag for iexplore
function XK_IsInsideThisTag(Id,tagname)
{
	if (isie)
	{
	    var IframeId="iframe"+Id;
		var range= XK_CreateRange(Id);
	    var element = range.parentElement();
	    var tag = element.tagName.toLowerCase();
	    while ((tag!="body") && (tag!=tagname.toLowerCase()))
	    {
		   element = element.parentElement;
		   tag = element.tagName.toLowerCase();
	    }
	    if (tag==tagname.toLowerCase()) return (tag);
	    else return false;
	}
};

function XK_CreateRange(Id)
{
	var IframeId="iframe"+Id;
	if(isie)
		{
       	 //retrieve selected range
       	 var sel=document.getElementById(IframeId).contentWindow.document.selection;
       	 if(sel!=null)
			{
       	     var newselectionRange=sel.createRange();
       	     newselectionRange.select();
			}
    	return (newselectionRange);
		}
		
		else 
		{	
			range=document.createRange();
			return (range);
		}
};

//returns selected text on iframe
function XK_GetSelectedText(Id)
{
	var IframeId="iframe"+Id;
	var newselectionRange= XK_CreateRange(Id);
	if(isie)
	{	
		var text=newselectionRange.htmlText;
    }
	else
	{
		var e = document.getElementById(IframeId);
		var text = e.contentWindow.getSelection();
	}
	return text;
};

//Shows/Hides a Div Layer
function XK_showHideDiv(id,buttonId,divId)
{
	var divid=divId+id;
	buttonElement=document.getElementById(buttonId+id);
	document.getElementById(divid).style.left=XK_getOffsetLeft(buttonElement) + "px";
	document.getElementById(divid).style.top=(XK_getOffsetTop(buttonElement) + buttonElement.offsetHeight) + "px";
	if(document.getElementById(divid).style.display=="none")
	{
		document.getElementById(divid).style.display="";
		hidePalettesHandler = new XK_hidePalettesHandler(id);
		hidePalettesHandler.Create();
	}
	else document.getElementById(divid).style.display="none";
};

//change between code and wysiwyg modes
function XK_doToggleView(Id){
	
	var IframeId="iframe"+Id;

        if(viewMode == 1){
            //hide editor
            document.getElementById("alleditor"+Id).style.display="none";
            //show textarea with code
            document.getElementById(Id).style.display="inline";
			document.getElementById(Id).value = XK_toXHTML(document.getElementById(IframeId).contentWindow.document.body.innerHTML);	
			document.getElementById(Id).focus();
			viewMode = 2; // Code
        }else{
            
			document.getElementById(IframeId).contentWindow.document.body.innerHTML = XK_toWYSIWYG(document.getElementById(Id).value);
          	//show editor
            document.getElementById("alleditor"+Id).style.display="block";
            //hide textarea
            document.getElementById(Id).style.display="none";
            //enable design mode again for gecko
            if (!isie)document.getElementById(IframeId).contentWindow.document.designMode="On";
            viewMode = 1; // WYSIWYG
        }
};
function XK_OpenPopup(url,name,width,height) {
	var options = "width=" + width + ",height=" + height + "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no";

	new_window = window.open(url, name, options);
	window.self.name = "main";
	new_window.focus();
};

//inserts html into iframe
function XK_InsertHTML(html,Id) 
{
	var IframeId="iframe"+Id;
	var range= XK_CreateRange(Id);

	document.getElementById(IframeId).contentWindow.focus();

    if (isie) {
        try {
            range.pasteHTML(html); 
			range.select();
			range.moveEnd("character", 1);
			range.moveStart("character", 1);
			range.collapse(false);
        } catch (e) {
            // catch error when range is evil for IE        
        }
    } else {
        selection = document.getElementById(IframeId).contentWindow.window.getSelection();
        document.getElementById(IframeId).contentWindow.focus();
        if (selection) {
            range = selection.getRangeAt(0);
        } else {
            range = document.getElementById(IframeId).contentWindow.document.createRange();
        } 

        var fragment = document.getElementById(IframeId).contentWindow.document.createDocumentFragment();
        var div = document.getElementById(IframeId).contentWindow.document.createElement("div");
        div.innerHTML = html;

        while (div.firstChild) {
            fragment.appendChild(div.firstChild);
        }

        selection.removeAllRanges();
        range.deleteContents();

        var node = range.startContainer;
        var pos = range.startOffset;

        switch (node.nodeType) {
            case 3:
                if (fragment.nodeType == 3) {
                    node.insertData(pos, fragment.data);
                    range.setEnd(node, pos + fragment.length);
                    range.setStart(node, pos + fragment.length);
                } else {
                    node = node.splitText(pos);
                    node.parentNode.insertBefore(fragment, node);
                    range.setEnd(node, pos + fragment.length);
                    range.setStart(node, pos + fragment.length);
                }
                break;

            case 1:
                node = node.childNodes[pos];
                node.parentNode.insertBefore(fragment, node);
                range.setEnd(node, pos + fragment.length);
                range.setStart(node, pos + fragment.length);
                break;
        }
        selection.addRange(range);
    }
};

function XK_toWYSIWYG(text) 
{
	if (!isie)
	{
		text = text.replace(/<br \/>/gi,"<br>");
		text = text.replace(/<strong>/gi, "<b>");
		text = text.replace(/<strong /gi, "<b ");
		text = text.replace(/<\/strong>/gi, "</b>");
		text = text.replace(/<em>/gi, "<i>");
		text = text.replace(/<em /gi, "<i ");
		text = text.replace(/<\/em>/gi, "</i>");
	}
	else
	{
		text = text.replace(/<br \/>/gi,"<br>");
		text = text.replace(/<b>/gi, "<strong>");
		text = text.replace(/<b /gi, "<strong ");
		text = text.replace(/<\/b>/gi, "</strong>");
		text = text.replace(/<i>/gi, "<em>");
		text = text.replace(/<i /gi, "<em ");
		text = text.replace(/<\/i>/gi, "</em>");

	}
	text = text.replace(/<a name=\"(.*?)\"><\/a>/gi, '<img alt=\x22anchor\x22 id=\"$1\" title=\"$1\" src=\"'+url+'/skins/common/anchor.gif\" />');
		
	return text;
};

function XK_toXHTML(text) 
{
	//img, hr ,area, input correct xhtml ending tags
	var re =/<(img|area|input|hr) ([^>]*)\x22>/gi;
	text = text.replace(re,'<$1 $2\x22/>');
	text = text.replace (/<HR>/gi,"<hr />");	 
	
	//replace <BR> by <br />
	text = text.replace(/<br>/gi,"<br />");
	
	//destroy tbody tags	
	text = text.replace(/<tbody>/gi,"");
	text = text.replace(/<\/tbody>/gi,"");
	
	//for mozilla
	if (!isie)
	{
		text = text.replace(/<b>/gi, "<strong>");
		text = text.replace(/<b /gi, "<strong ");
		text = text.replace(/<\/b>/gi, "</strong>");
		text = text.replace(/<i>/gi, "<em>");
		text = text.replace(/<i /gi, "<em ");
		text = text.replace(/<\/i>/gi, "</em>");
		
		//hilite text crossbrowser compatibility
		text = text.replace(/<span style=\x22background-color:((.|\s)+?)>((.|\s)+?)<\/span>/gi,'<font style=\x22background-color:$1>$3</font>');
	}
	//html tags tolowercase for iexplore
	else
	{
		text = text.replace(/<table/gi, "<table");
		text = text.replace(/<\/table/gi, "</table");
		text = text.replace(/<th/gi, "<th");
		text = text.replace(/<\/th/gi, "</th");
		text = text.replace(/<tr/gi, "<tr");
		text = text.replace(/<\/tr/gi, "</tr");
		text = text.replace(/<td/gi, "<td");
		text = text.replace(/<\/td/gi, "</td");
		text = text.replace(/<div/gi, "<div");
		text = text.replace(/<\/div/gi, "</div");
		text = text.replace(/<li/gi, "<li");
		text = text.replace(/<\/li/gi, "</li");
		text = text.replace(/<ul/gi, "<ul");
		text = text.replace(/<\/ul/gi, "</ul");
		text = text.replace(/<p/gi, "<p");
		text = text.replace(/<\/p/gi, "</p");
		text = text.replace(/<BLOCKQUOTE/gi, "<blockquote");
		text = text.replace(/<\/BLOCKQUOTE/gi, "</blockquote");
		text = text.replace(/<img/gi, "<img");
		text = text.replace(/<em/gi, "<em");
		text = text.replace(/<\/em/gi, "</em");
		text = text.replace(/<u/gi, "<u");
		text = text.replace(/<\/u/gi, "</u");
		text = text.replace(/<strike/gi, "<strike");
		text = text.replace(/<\/strike/gi, "</strike");
		text = text.replace(/<strong/gi, "<strong");
		text = text.replace(/<\/strong/gi, "</strong");
		text = text.replace(/<span/gi, "<span");
		text = text.replace(/<\/span/gi, "</span");
		text = text.replace(/<ol/gi, "<ol");
		text = text.replace(/<\/ol/gi, "</ol");
		text = text.replace(/<font/gi, "<font");
		text = text.replace(/<\/font/gi, "</font");
	}
	
	//SUB and SUP tags to lower
	text = text.replace(/<SUB>/gi, "<sub>");
	text = text.replace(/<SUP>/gi, "<sup>");
	text = text.replace(/<\/SUB>/gi, "</sub>");
	text = text.replace(/<\/SUP>/gi, "</sup>");
	
	//delete empty tags
	text = text.replace(/<u><\/u>/gim,"");
	text = text.replace(/<em><\/em>/gim,"");
	text = text.replace(/<li><\/li>/gim,"");
	text = text.replace(/<strike><\/strike>/gim,"");
	text = text.replace(/<strong><\/strong>/gim,"");
	text = text.replace(/<strong><br \/><\/strong>/gim,"");     
	text = text.replace(/<P[^>]*><\/P>/gi,""); 
	
	//delete double quoted atributes
	text = text.replace(/ ([^=]+)=([^" >]+)/gi, " $1=\"$2\"");
	
	//anchor
	text = text.replace(/<img id=((.|\s)+?) title=((.|\s)+?)>/gi, '<a name=$1></a>');
	return text;
};

function getAnchors(id)
{
	var IframeId="iframe"+id;
	text=XK_toXHTML(document.getElementById(IframeId).contentWindow.document.body.innerHTML);
	var result=new Array(); 
	result=text.match(/<a name=\"(.*?)\"><\/a>/gi);
	return result;
}

function XK_over(Id,name,color)
{
	document.getElementById('colortextf'+Id+name).style.backgroundColor =color;
	document.getElementById('showc'+Id+name).value =color;
};
	

function JSFX_FloatDiv(id, sx, sy)
{
	var ns = (navigator.appName.indexOf("Netscape") != -1);
	var d = document;
	var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
	var px = document.layers ? "" : "px";
	window[id + "_obj"] = el;
	if(d.layers)el.style=el;
	el.cx = el.sx = sx;el.cy = el.sy = sy;
	el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};
	
	el.floatIt=function()
	{
		var pX, pY;		
		pX = (this.sx >= 0) ? 0 : ns ? innerWidth : 
		document.documentElement && document.documentElement.clientWidth ?document.documentElement.clientWidth : document.body.clientWidth;
		pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ?document.documentElement.scrollTop : document.body.scrollTop;
		if(this.sy<0) pY += ns ? innerHeight : document.documentElement && document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/2;
		this.sP(this.cx, this.cy);		
		setTimeout(this.id + "_obj.floatIt()", 40);
	};
	return el;
};

function XK_floatingToolbar(id,skin)
{
	if (document.getElementById("toolbars"+id).className!=skin+"floatingToolBar")
	{	
	
		document.getElementById("TableOps"+id).style.display="none";
		document.getElementById("CellAlign"+id).style.display="none";
		document.getElementById("RemoveFormat"+id).style.display="none";
		document.getElementById("CellBorders"+id).style.display="none";
		document.getElementById("tablepicker"+id).style.display="none";
		
		document.getElementById("toolbars"+id).className=skin+"floatingToolBar";

		JSFX_FloatDiv("toolbars"+id, 100,50).floatIt();
	}
	else
	{
		document.getElementById("toolbars"+id).className=skin+"toolBar";
	}
};

function IsInsideThisTagMoz (tagname,id)
{
	var IframeId="iframe"+id;
	var sel=document.getElementById(IframeId).contentWindow.getSelection();
  	var range = sel.getRangeAt(0);
	var container = range.startContainer;
	if (container.nodeType != 1) {
		var textNode = container;
    	container = textNode.parentNode;
	}
	thisTag = container;
	while(thisTag.tagName.toLowerCase()!=tagname.toLowerCase() &&thisTag.tagName.toLowerCase()!="body") {
			thisTag = thisTag.parentNode;
	}
	if (thisTag.tagName.toLowerCase() == tagname.toLowerCase()) {
		return (thisTag);
	} else {
		return false
	}
};

function XK_getImg(id) 
{
	var iframeId="iframe"+id;

	if (document.getElementById(iframeId).contentWindow.document.selection.type == 'Control')
    { 
		var tControl = document.getElementById(iframeId).contentWindow.document.selection.createRange();
		if (tControl(0).tagName.toLowerCase() == 'img') return(tControl(0));
    	else return(null);
    }
    else
    {
      return(null);
    }
};

function XK_getImgGecko(id)
{
	var iframeId="iframe"+id;
	var range = document.getElementById(iframeId).contentWindow.getSelection().getRangeAt(0);
	var container = range.startContainer;
	var pos = range.startOffset;
	var imageNode = null;
	
	if (container.tagName) 
	{
		var images = container.getElementsByTagName('IMG');
		if (container.childNodes[pos].tagName == 'IMG') node = container.childNodes[pos];
		return node;
	}
	else return;
};
function XK_ImageProps(id,img)
{
    if(isie)node=XK_getImg(id);
    else node =XK_getImgGecko(id);
    
    if(node==null)return; 
	
	if(img!=null)
	{
    	if(img["alt"])node.setAttribute('alt',img["alt"]);
		if(img["src"])node.setAttribute('src',img["src"]);
		if(img["width"])node.width = img["width"];else node.removeAttribute('width',0);
		if(img["height"])node.height = img["height"];else node.removeAttribute('height',0);
		if(img["vspace"])node.vspace = img["vspace"];else node.removeAttribute('vspace',0);
		if(img["hspace"])node.hspace = img["hspace"];else node.removeAttribute('hspace',0);
		if(img["align"])node.setAttribute('align',img["align"]);else node.removeAttribute('align',0);
		if(img["className"])node.className = img["className"];else node.removeAttribute('className',0);

		
		//margin style
		node.style.marginLeft			= img["marginLeft"];
		node.style.marginRight			= img["marginRight"];
		node.style.marginTop			= img["marginTop"];
		node.style.marginBottom			= img["marginBottom"];
		
		//borders style
      	node.style.borderLeftStyle 		= img["borderLeftStyle"];
      	node.style.borderRightStyle 	= img["borderRightStyle"];
      	node.style.borderTopStyle 		= img["borderTopStyle"];
      	node.style.borderBottomStyle 	= img["borderBottomStyle"]; 	
      	
      	//borders Width
      	node.style.borderLeftWidth 		= img["borderLeftWidth"];
      	node.style.borderRightWidth 	= img["borderRightWidth"];
      	node.style.borderTopWidth 		= img["borderTopWidth"];
      	node.style.borderBottomWidth 	= img["borderBottomWidth"];
			
		//borders Color
      	node.style.borderLeftColor 		= img["borderLeftColor"];
      	node.style.borderRightColor 	= img["borderRightColor"];
      	node.style.borderTopColor 		= img["borderTopColor"];
      	node.style.borderBottomColor 	= img["borderBottomColor"];

		return;
	}
	else
	{
    	var image 				= 	new Object();
    	image["alt"]			=	node.getAttribute('alt');
		image["src"]			=	node.getAttribute('src');
		image["width"]			=	node.width;	
		image["height"]			=	node.height;
		image["vspace"]			=	node.vspace;	
		image["hspace"]			=	node.hspace;
		image["className"]		=	node.className;
		
		image["align"]			=	node.getAttribute('align');
		image["marginLeft"]		=	node.style.marginLeft;
		image["marginRight"]	=	node.style.marginRight;
		image["marginTop"]		=	node.style.marginTop;
		image["marginBottom"]	=	node.style.marginBottom;
		
		//borders style
      	image["borderLeftStyle"] 	= node.style.borderLeftStyle; 
    	image["borderRightStyle"]	= node.style.borderRightStyle;
      	image["borderTopStyle"]		= node.style.borderTopStyle;
      	image["borderBottomStyle"] 	= node.style.borderBottomStyle;  	
      	
      	//borders Width
		image["borderLeftWidth"]	= node.style.borderLeftWidth; 
		image["borderRightWidth"]	= node.style.borderRightWidth;
		image["borderTopWidth"]		= node.style.borderTopWidth;
		image["borderBottomWidth"]	= node.style.borderBottomWidth;
				
		//borders Color
		if(isie)
		{
			image["borderLeftColor"]	= node.style.borderLeftColor;
			image["borderRightColor"]	= node.style.borderRightColor;
			image["borderTopColor"] 	= node.style.borderTopColor; 
			image["borderBottomColor"]	= node.style.borderBottomColor;
		}
		else
		{
			image["borderLeftColor"]	= (node.style.borderLeftColor)?XK_RgbToHex(node.style.borderLeftColor):node.style.borderLeftColor;			
			image["borderRightColor"]	= (node.style.borderRightColor)?XK_RgbToHex(node.style.borderRightColor):node.style.borderRightColor;
			image["borderTopColor"] 	= (node.style.borderTopColor)?XK_RgbToHex(node.style.borderTopColor):node.style.borderTopColor; 
			image["borderBottomColor"]	= (node.style.borderBottomColor)?XK_RgbToHex(node.style.borderBottomColor):node.style.borderBottomColor;
		}


 		return (image);
 	}
    
};


function XK_hidePalettesHandler (id)
{
	this.id=id;
};

XK_hidePalettesHandler.prototype.getId = function()
{
	return this.id;
};

XK_hidePalettesHandler.prototype.Create = function()
{
	if(isie)document.getElementById("iframe"+this.id).contentWindow.document.attachEvent('onclick',this.Hide);
	else document.getElementById("iframe"+this.id).contentWindow.document.addEventListener( 'click', this.Hide, false ) ;
};

XK_hidePalettesHandler.prototype.Hide = function()
{
	id=hidePalettesHandler.getId();
	try{document.getElementById("colorPalette"+id).style.display="none";}catch(e){}
	try{document.getElementById("tablepicker"+id).style.display="none";}catch(e){}
	try{document.getElementById("TableOps"+id).style.display="none";}catch(e){}
	try{document.getElementById("CellAlign"+id).style.display="none";}catch(e){}
	try{document.getElementById("RemoveFormat"+id).style.display="none";}catch(e){}
	try{document.getElementById("CellBorders"+id).style.display="none";}catch(e){}
};

function XK_HideToolbar(id,url)
{
	var doc=document.getElementById("toolbars"+id).style.display;
	if(doc=="none")
	{
		document.getElementById("toolbars"+id).style.display="";
		document.getElementById("hideimg"+id).src=url+"/collapse.gif";
	}
	else
	{ 
		document.getElementById("toolbars"+id).style.display="none";
		document.getElementById("hideimg"+id).src=url+"/expand.gif";
	}
};

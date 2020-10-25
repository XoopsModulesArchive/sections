/*==============================================================================

                             HTML2XHTML Converter 1.0
                             ========================
                       Copyright (c) 2004 Vyacheslav Smolin


Author:
-------
Vyacheslav Smolin (http://www.richarea.com, http://html2xhtml.richarea.com,
re@richarea.com)

About the script:
-----------------
HTML2XHTML Converter (H2X) generates a well formed XHTML string from a HTML DOM
object.

Requirements:
-------------
H2X works in  MS IE 5.0 for Windows or above,  in Netscape 7.1,  Mozilla 1.3 or
above. It should work in all Mozilla based browsers.

Usage:
------
Please see description of function get_xhtml below.

Demo:
-----
http://html2xhtml.richarea.com/, http://www.richarea.com/demo/

License:
--------
Free for non-commercial using. Please contact author for commercial licenses.


==============================================================================*/


eval(function(A,r,s,e,n,a,l){s=function(e){return((e<a)?'':s(e/a))+n[l[119]](e%a+161)};while(++r<188)l[r]=(r<131)?'/'+l[r]+'/':'"'+l[r]+'"';while(--r>=0)A=A.replace(new RegExp(s(r),'g'),l[r]);return A}('¢ á=¢Å;¢ Ô=¢Æ;¢ Ê=ê é();Ê.è(¢Ç);¢ ¼=ê é();¼.è(¢È);³ Ò(ç,ª,¹,¶,¸){¢ i;¢ ¡=¢É;¢ Ë=ç.¢³;¢ æ=Ë.à;¢ ¤;¢ È=¶?«:¯;¢ ¿=«;ß(i=0;i<æ;i++){¢ £=Ë[i];Û(£.¢²){¨ 1:{¢ ¤=±(£.¢±).Ç();if(¤==¢É)©;if(¤==¢Ê){¢ ä=±(£.¢°).Ç();if(ä==¢Ë)©}if(!¶&&¤==¢Ì){¿=¯}if(¤==¢Í){¢ É=Ê.Ï(£.¡);if(É){¢ ­=É[1];¡+=½(­)}}°{if(¤==¢Î){¡=¢Ï+¹+¢Ð}if(á.Ó(¢Ñ+¤+¢Ñ)!=-1){if((È||¡!=¢É)&&!¸)¡+=¢Ò;° È=«}¡+=¢Ó+¤;¢ »=£.¢¥;¢ Þ=».à;¢ ¬;¢ Ä=¯;¢ Ã=¯;¢ Á=¯;ß(j=0;j<Þ;j++){¢ §=»[j].¢¤.Ç();if(!»[j].¢£&&(§!=¢Ô||!£.Æ)&&(§!=¢Õ||£.®.Ú==¢É)&&§!=¢Ö)Ü;if(§==¢×||§==¢Ø||¤==¢Ù&&§==¢Ú&&£.Ù(¢Ú)==¢Û)Ü;¢ Å=«;Û(§){¨ ¢Ü:¬=£.®.Ú;©;¨ ¢Ý:¬=£.ü;©;¨ ¢Þ:¬=£.ù;©;¨ ¢ß:¨ ¢à:¨ ¢á:¨ ¢â:¨ ¢ã:¬=§;©;Ð:ô{¬=£.Ù(§,2)}ó(e){Å=¯}}if(§==¢ä){Ä=«;¬=ª}if(§==¢å){Ã=«;¬=ª}if(§==¢æ)Á=«;if(Å)¡+=¢ç+§+¢è+Í(¬)+¢é}if(¤==¢Î){if(!Ä)¡+=¢ê+ª+¢é;if(!Ã)¡+=¢ë+ª+¢é;if(!Á)¡+=¢ì}if(£.ñ||£.ð()){¡+=¢í;if(Ô.Ó(¢Ñ+¤+¢Ñ)!=-1){}¡+=Ò(£,ª,¹,«,¸||¤==¢î?«:¯);¡+=¢ï+¤+¢í}°{if(¤==¢Õ||¤==¢ð||¤==¢ñ){¡+=¢í;¢ ­;if(¤==¢ñ){­=£.¡}° ­=£.î;if(¤==¢Õ){­=±(­).¦(¢ºg,¢Ò)}¡+=­+¢ï+¤+¢í}°{¡+=¢ò}}}©}¨ 3:{if(!¸){if(£.·!=¢Ò){¡+=Î(£.·)}}° ¡+=£.·;©}¨ 8:{¡+=½(£.·);©}Ð:©}}if(!¶&&!¿){¡=¡.¦(¢»gi,¢ó);¡=¡.¦(¢¼gi,¢ó);¡=¡.¦(¢½gi,¢ó)}² ¡};³ ½(¡){¡=¡.¦(¢¾g,¢ô);if(¼.Ï(¡)){¡+=¢õ}² ¢ö+¡+¢÷};³ Î(¡){² ±(¡).¦(¢¿g,¢ø).¦(¢Àg,¢ù).¦(¢Ág,¢ú).¦(¢Âg,¢û).¦(¢Ãg,¢ü)};³ Í(¡){² ±(¡).¦(¢Àg,¢ù).¦(¢Ág,¢ú).¦(¢Âg,¢û).¦(¢Äg,¢ý)};',119,0,/./,String,95,'text`var`child`tag_name`x22`replace`attr_name`case`break`lang`true`attr_value`inner_text`style`false`else`String`return`function`body`head`need_nl`nodeValue`inside_pre`encoding`html`attr`re_hyphen`fix_comment`x2f`page_mode`script`attr_xmlns`xml`attr_xml_lang`attr_lang`valid_attr`selected`toLowerCase`do_nl`parts`re_comment`children`amp`fix_attribute`fix_text`exec`default`title`get_xhtml`indexOf`need_nl_after`org`www`x22http`xmlns`getAttribute`cssText`switch`continue`type`attr_length`for`length`need_nl_before`xhtml1`DTD`meta_name`meta`child_length`node`compile`RegExp`new`quot`nbsp`u00A0`innerHTML`pre`hasChildNodes`canHaveChildren`xhtml`catch`try`nowrap`multiple`checked`noshade`httpEquiv`equiv`http`className`class`moz`moz_resizing`moz_dirty`value`specified`nodeName`attributes`dtd`transitional`Transitional`XHTML`W3C`PUBLIC`DOCTYPE`x221`version`generator`name`tagName`nodeType`childNodes`option`comment`tbody`table`div`fromCharCode`[\\n]+`<\\¾?µ>[\\n]*`<µ \\¾>[\\n]*`<\\¾?´>[\\n]*`--`\\n{2,}`\\&`<`>`\\í`\\¥`|¢¸|p|¢·|¢¶|tr|td|th|Ñ|µ|´|À|¢µ|li|å|h1|h2|h3|h4|h5|h6|hr|ul|ol|¢´|`|º|µ|´|p|th|®|`^<!--(.*)-->$`-$``å`¢¯`´`!`º`<?Â ¢®=\\¢­.0\\¥ ¹=\\¥`\\¥?>\\n<!¢¬ º ¢« \\¥-//¢ª//ã ¢© 1.0 ¢¨//EN\\¥ \\×://Ö.w3.Õ/TR/â/ã/â-¢§.¢¦\\¥>\\n`|`\\n`<`Æ`®`¢¢`_¢¡`_ÿ`br`Ý`_þ`®`ý`û-ú`ø`÷`Æ`ö`õ`ª`Â:ª`Ø` `=\\¥`\\¥` ª=\\¥` Â:ª=\\¥` Ø=\\×://Ö.w3.Õ/1999/ò\\¥`>`ï`</`Ñ`À` />``__` `<!--`-->`\\n`&Ì;`&lt;`&gt;`&ì;`&ë;'.split('\x60')));
/* packed with http://dean.edwards.name/packer/ */
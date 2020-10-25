<?php

// $Id: formwysiwygtextarea.php,V 1.0 pre release 29/Sep/2004 3:04 Samuels Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System //
// Copyright (c) 2000 xoopscube.org //
// <http://xoopscube.org> //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify //
// it under the terms of the GNU General Public License as published by //
// the Free Software Foundation; either version 2 of the License, or //
// (at your option) any later version. //
// //
// You may not change or alter any portion of this comment or credits //
// of supporting developers from this source code or any supporting //
// source code which is considered copyrighted (c) material of the //
// original comment or credit authors. //
// //
// This program is distributed in the hope that it will be useful, //
// but WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the //
// GNU General Public License for more details. //
// //
// You should have received a copy of the GNU General Public License //
// along with this program; if not, write to the Free Software //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu) //
// URL: http://www.myweb.ne.jp/, http://xoopscube.org/, http://jp.xoopscube.org/ //
// Project: The XOOPS Project //
// ------------------------------------------------------------------------- //
define('_FONT_SIZE', 'Size');
define('_FONT_XSMALL', 'X Small');
define('_FONT_SMALL', 'Small');
define('_FONT_MEDIUM', 'Medium');
define('_FONT_LARGE', 'Large');
define('_FONT_XLARGE', 'X Large');
define('_FONT_XXLARGE', 'XX Large');
define('_FONT_FORMAT', 'Format');
define('_FONT_NONE', 'None');
define('_FONT_HEADING1', 'Heading 1');
define('_FONT_HEADING2', 'Heading 2');
define('_FONT_HEADING3', 'Heading 3');
define('_FONT_HEADING4', 'Heading 4');
define('_FONT_HEADING5', 'Heading 5');
define('_FONT_HEADING6', 'Heading 6');
define('_FONT_ADDRESS', 'Address');
define('_SPELL_CHECK', 'Spell Checker');
define('_TOGLE_MODE', 'Toggle Mode');
define('_TABLEBORDERS_TOGGLE', 'Toggle Table Borders');
define('_UNDO', 'Undo');
define('_REDO', 'Redo');
define('_FORECOLOR', 'Color');
define('_HILITECOLOR', 'Hilite');
define('_CUT', 'Cut');
define('_COPY', 'Copy');
define('_PASTE', 'Paste');
define('_BOLD', 'Bold');
define('_ITALIC', 'Italic');
define('_UNDERLINE', 'Underline');
define('_STRIKETHROUGH', 'Strikethrouhg');
define('_REMOVEFORMAT', 'Remove Format');
define('_JUSTIFYLEFT', 'Justify Left');
define('_JUSTIFYCENTER', 'Justify Center');
define('_JUSTIFYRIGHT', 'Justify Right');
define('_JUSTIFYFULL', 'Justify Full');
define('_NEWPARAGRAPH', 'New Paragraph');
define('_INSERTORDEREDLIST', 'Ordered List');
define('_INSERTUNORDEREDLIST', 'Bulleted List');
define('_SPELLCHECK', 'Spellcheck');
define('_PRINT', 'Print');
define('_INDENT', 'Indent');
define('_OUTDENT', 'Outdent');
define('_SUPERSCRIPT', 'SuperScript');
define('_SUBSCRIPT', 'SubScript');
define('_CODE', 'Code');
define('_CREATELINK', 'Create link');
define('_UNLINK', 'Remove Link');
define('_INSERTHORIZONTALRULE', 'Insert Horizontal Rule');
define('_INSERTANCHOR', 'Insert Anchor');
define('_CREATEQUICKTABLE', 'Insert Quick Table');
define('_INSERTIMAGE', 'Insert Image');
define('_INSERTIMAGEM', 'Image Manager');
define('_FLOAT', 'Floating/Static Toolbar');
define('_WY_SYMBOLS', 'Symbols');
define('_WY_CLASS', 'Class');
//Image properties dialog
define('_WY_EDITIMAGE', 'Edit Image');
define('_WY_IMAGEWIDTH', 'Image width');
define('_WY_IMAGEHEIGHT', 'Image height');
define('_WY_IMAGEPROPS', 'Image Properties');
define('_WY_MARGINS', 'Margins');
define('_WY_ALT', 'Alt');
define('_WY_SRC', 'Source');
define('_WY_IMAGEALIGN', 'Image Align');
define('_WY_HSPACE', 'V Space.');
define('_WY_VSPACE', 'H Space.');
define('_WY_BWIDTH', 'Width');
//table dialog
define('_WY_INSERTTABLE', 'Insert Table');
define('_WY_EDITTABLE', 'Edit Table');
define('_WY_ROWS', 'Number of rows');
define('_WY_COLS', 'Number of columns');
define('_WY_WIDTH', 'Width');
define('_WY_HEIGHT', 'Height');
define('_WY_UNITS', 'Units');
define('_WY_BORDER', 'Border');
define('_WY_HALIGNMENT', 'Horizontal Alignment');
define('_WY_VALIGNMENT', 'Vertical Alignment');
define('_WY_SPACING', 'Cell Spacing');
define('_WY_PADDING', 'Cell Padding');
define('_WY_LEFT', 'Left');
define('_WY_RIGHT', 'Right');
define('_WY_CENTER', 'Center');
define('_WY_TOP', 'Top');
define('_WY_TEXTTOP', 'Text Top');
define('_WY_MIDDLE', 'Middle');
define('_WY_ABSMIDDLE', 'Absolute Middle');
define('_WY_BOTTOM', 'Bottom');
define('_WY_ABSBOTTOM', 'Absolute Bottom');
define('_WY_BASELINE', 'Baseline');
define('_WY_DEFAULT', 'Default');
define('_WY_BORDERCOLOR', 'Border Color');
//table tools
define('_WY_INSERTCELL', 'Insert Cell');
define('_WY_INSERTCOL', 'Insert Col');
define('_WY_INSERTROW', 'Insert Row');
define('_WY_DELCELL', 'Del Cell');
define('_WY_DELROW', 'Del Row');
define('_WY_DELCOL', 'Del Col');
define('_WY_TABLEPROPS', 'Table Properties');
define('_WY_TABLETOOLS', 'Table Tools');
define('_WY_MORECOLSPAN', 'More Col Span');
define('_WY_LESSCOLSPAN', 'Less Col Span');
define('_WY_MOREROWSPAN', 'More Row Span');
define('_WY_LESSROWSPAN', 'Less Row Span');
//CELL TOOLS
define('_WY_FORECOLOR', 'Fore Color');
define('_WY_IMGBACK', 'Background Image');
define('_WY_CELLALIGN', 'Cell Align');
define('_WY_CELLPROPS', 'Cell Properties');
define('_WY_CELLALIGNLEFTTOP', 'Left Top');
define('_WY_CELLALIGNLEFTMIDDLE', 'Left Middle');
define('_WY_CELLALIGNLEFTBOTTOM', 'Left Bottom');
define('_WY_CELLALIGNRIGHTTOP', 'Right Top');
define('_WY_CELLALIGNRIGHTMIDDLE', 'Right Middle');
define('_WY_CELLALIGNRIGHTBOTTOM', 'Right Bottom');
define('_WY_CELLALIGNCENTERTOP', 'Center Top');
define('_WY_CELLALIGNCENTERMIDDLE', 'Center Middle');
define('_WY_CELLALIGNCENTERBOTTOM', 'Center Bottom');
define('_WY_PREVIEW', 'Preview');
define('_WY_OTHERS', 'Others');
define('_WY_CELLOVERFLOW', 'Overflow');
define('_WY_CELLWIDTH', 'Width');
define('_WY_CELLHEIGHT', 'Height');
define('_WY_CELLPADDING', 'Cell Padding');
//BORDERS
define('_WY_BORDERS', 'Borders');
define('_WY_BORDERSWIDTH', 'Borders Width');
define('_WY_BORDERLEFT', 'Border Left');
define('_WY_BORDERRIGHT', 'Border Right');
define('_WY_BORDERTOP', 'Border Top');
define('_WY_BORDERBOTTOM', 'Border Bottom');
//REMOVE FORMAT
define('_WY_REMOVE_DESC', 'Remove Format Tools');
define('_WY_REMOVE_SPANF', 'Delete <b>&lt;span&gt;</b> tags');
define('_WY_REMOVE_FONTF', 'Delete <b>&lt;font&gt;</b> tags');
define('_WY_REMOVE_WORDF', 'Delete Word Format');
define('_WY_REMOVE_ALLF', 'Del All Format');

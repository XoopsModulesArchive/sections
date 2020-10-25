<?php

// $Id: formwysiwygtextarea.php,V 1.0 pre release 29/Sep/2004 3:04 Samuels Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://xoopscube.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://xoopscube.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
/**
 * @author        Samuels
 * @copyright     copyright (c) 2000-2003 XOOPS.org
 */

/**
 * A textarea with wysiwyg buttons
 *
 * @author        Samuels
 * @copyright     copyright (c) 2000-2003 XOOPS.org
 */
$koivi_editor_instances = 0;

class XoopsFormWysiwygTextArea extends XoopsFormElement
{
    public $options;

    public $value;

    public $width;

    public $height;

    public $url;

    public $js;

    public $skin;

    public $fonts;

    public $hideNC;

    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param string $value   Initial text
     * @param string $width   iframe width
     * @param string $height  iframe height
     * @param array  $options Toolbar Options
     */
    public function __construct($caption, $name, $value, $width, $height, $options)
    {
        global $koivi_editor_instances;

        $koivi_editor_instances++;

        $this->setUrl('/modules/sections/wysiwyg');

        $this->setCaption($caption);

        $this->setName($name);

        $this->setValue($value);

        $this->setOptions($options);

        $this->setWidth($width);

        $this->setHeight($height);

        $this->setSkin('default');

        $this->setFonts('');

        $this->setJs($koivi_editor_instances);

        $this->setHideNC(true);

        unset($koivi_editor_instances);
    }

    public function getSkin()
    {
        return $this->skin;
    }

    public function setSkin($skin)
    {
        $this->skin = $skin;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($value)
    {
        $this->url = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setHideNC($op)
    {
        $this->hideNC = $op;
    }

    public function getHideNC()
    {
        return $this->hideNC;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setJs($js)
    {
        $this->js = $js;
    }

    public function getJs()
    {
        return $this->js;
    }

    public function setFonts($fonts)
    {
        $deffonts = ['Courier New' => 'Courier New, Courier, monospace', 'MS Serif' => 'MS Serif, New York, serif', 'Verdana' => 'Verdana, Geneva, Arial, Helvetica, sans-serif'];

        if (empty($fonts)) {
            $this->fonts = $deffonts;
        } else {
            $this->fonts = $fonts;
        }
    }

    public function getFonts()
    {
        return $this->fonts;
    }

    /**
     * Test options array and set
     *
     * @param mixed $options
     * @return void toolbar options
     */
    public function setOptions($options)
    {
        $toolbar = [
            'fontname',
            'fontsize',
            'formatblock',
            'insertsymbols',
            'newline',
            'undo',
            'redo',
            'separator',
            'cut',
            'copy',
            'paste',
            'separator',
            'spellcheck',
            'print',
            'separator',
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'removeformat',
            'separator',
            'justifyleft',
            'justifycenter',
            'justifyright',
            'justifyfull',
            'newparagraph',
            'separator',
            'insertorderedlist',
            'insertunorderedlist',
            'indent',
            'outdent',
            'newline',
            'forecolor',
            'hilitecolor',
            'superscript',
            'subscript',
            'separator',
            'quote',
            'code',
            'inserthorizontalrule',
            'insertanchor',
            'separator',
            'createlink',
            'unlink',
            'separator',
            'insertimage',
            'imagemanager',
            'imageproperties',
            'separator',
            'createtable',
            'tableprops',
            'cellalign',
            'cellborders',
            'togglecellborders',
            'cellcolor',
            'togglemode',
            'separator',
            'floating',
        ];

        if (empty($options)) {
            $this->options = $toolbar;
        } else {
            $this->options = $options;
        }
    }

    /**
     * Prepare HTML for output
     *
     * @return    string  HTML
     */
    public function render()
    {
        //include files

        require_once __DIR__ . '/include/functions.inc.php';

        require_once getLanguage($this->getUrl());

        global $koivi_editor_instances;

        $width = $this->getWidth();

        $height = $this->getHeight();

        $content = $this->getValue();

        $options = $this->getOptions();

        $fonts = $this->getFonts();

        $name = $this->getName();

        $url = XOOPS_URL . '' . $this->getUrl();

        $skinUrl = $url . '/skins/' . $this->getSkin();

        $skin = $this->getSkin();

        $isie = checkBrowser();

        $ToggleMode = false;

        $colorPalette = false;

        $extraDivs = '';

        if (1 == $this->getJs()) {
            $form = '<script language="JavaScript" type="text/javascript" src="' . $url . '/include/js/editor.js"></script>';

            $form .= '<script language="JavaScript" type="text/javascript" src="' . $url . '/include/js/html2xhtml.js"></script>';

            if (in_array('createtable', $options, true)) {
                $form .= '<script language="JavaScript" type="text/javascript" src="' . $url . '/include/js/table_tools.js"></script>';
            }
        } else {
            $form = '';
        }

        $form .= '
		<link href="' . $skinUrl . '/' . $skin . '.css" rel="Stylesheet" type="text/css">
		<div id="alleditor' . $name . '"  style=" width:' . $width . ';">
		<table width="' . $width . '" border="0" cellpadding="0" cellspacing="0" class="' . $skin . 'toolBarContainer" ><tr>
		<td class="' . $skin . 'showHideCell" width="1%" onclick="XK_HideToolbar(\'' . $name . '\',\'' . $skinUrl . '\')"><img alt="" unselectable="on" id="hideimg' . $name . '"  src="' . $skinUrl . '/collapse.gif"></td>
		<td width="99%" class="' . $skin . 'toolbarBackCell"><div id="toolbars' . $name . '" class="' . $skin . 'toolBar">';

        foreach ($options as $tool) {
            switch (mb_strtolower($tool)) {
                case 'bold':
                    $form .= '<img unselectable="on"  alt="' . _BOLD . '" title="' . _BOLD . '" src="' . $skinUrl . '/bold.gif" onclick="XK_DoTextFormat(\'bold\',\'\',\'' . $name . '\')">';
                    break;
                case 'cellalign':
                    $form .= '<img unselectable="on"  alt="' . _WY_CELLPROPS . '" title="' . _WY_CELLPROPS . '" src="' . $skinUrl . '/cellalign.gif">';
                    $form .= '<img unselectable="on"  alt="' . _WY_CELLALIGN . '" title="' . _WY_CELLALIGN . '" id="cellpropbutton' . $name . '" src="' . $skinUrl . '/popup.gif" onclick="XK_useTableDivs(\'' . $name . '\',\'align\')">';
                    $extraDivs .= $this->_renderCellAlign();
                    break;
                case 'cellborders':
                    $form .= '<img unselectable="on"  alt="'
                                  . _WY_CELLPROPS
                                  . '" title="'
                                  . _WY_CELLPROPS
                                  . '" src="'
                                  . $skinUrl
                                  . '/cellborders.gif" onclick="XK_TTools(\''
                                  . $name
                                  . '\',\''
                                  . $url
                                  . '/dialogs.php?id='
                                  . $name
                                  . '&amp;dialog=cellProps&amp;skin='
                                  . $skin
                                  . '&amp;url='
                                  . $this->getUrl()
                                  . '\',\'table\',590,340)">';
                    $form .= '<img unselectable="on"  alt="' . _WY_CELLALIGN . '" title="' . _WY_CELLALIGN . '" id="cbbutton' . $name . '" src="' . $skinUrl . '/popup.gif" onclick="XK_useTableDivs(\'' . $name . '\',\'borders\')">';
                    $extraDivs .= $this->_renderCellBorders();
                    break;
                case 'cellcolor':
                    $form .= '<img unselectable="on"  alt="' . _FORECOLOR . '" id="cellcolor' . $name . '" title="' . _FORECOLOR . '" src="' . $skinUrl . '/cellcolor.gif" onclick="XK_Color(\'' . $name . '\',\'cellcolor\',\'cellcolor\')">';
                    $colorPalette = true;
                    break;
                case 'code':
                    $form .= '<img unselectable="on"  alt="' . _CODE . '" title="' . _CODE . '" src="' . $skinUrl . '/code.gif" onclick="XK_DoTextFormat(\'code\',\'\',\'' . $name . '\')">';
                    break;
                case 'copy':
                    if ($isie && $this->getHideNC()) {
                        $form .= '<img unselectable="on"  alt="' . _COPY . '" title="' . _COPY . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'copy\',\'\',\'' . $name . '\')">';
                    }
                    break;
                case 'createlink':
                    $form .= '<img unselectable="on"  alt="' . _CREATELINK . '" title="' . _CREATELINK . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_OpenPopup(\'' . $url . '/dialogs.php?id=' . $name . '&amp;dialog=createLink&amp;url=' . $this->getUrl() . '\',\'table\',260,156)">';
                    break;
                case 'createtable':
                    $form .= '<img unselectable="on"  alt="'
                                  . _WY_INSERTTABLE
                                  . '" title="'
                                  . _WY_INSERTTABLE
                                  . '" src="'
                                  . $skinUrl
                                  . '/'
                                  . $tool
                                  . '.gif" onclick="XK_OpenPopup(\''
                                  . $url
                                  . '/dialogs.php?id='
                                  . $name
                                  . '&amp;dialog=table&amp;url='
                                  . $this->getUrl()
                                  . '\',\'table\',380,288)">';
                    $form .= '<img unselectable="on"  alt="' . _CREATEQUICKTABLE . '" id="tablebutton' . $name . '" title="' . _CREATEQUICKTABLE . '" src="' . $skinUrl . '/popup.gif" onclick="XK_showHideDiv(\'' . $name . '\',\'tablebutton\',\'tablepicker\')">';
                    $extraDivs .= $this->_renderQuickTable();
                    break;
                case 'cut':
                    if ($isie && $this->getHideNC()) {
                        $form .= '<img unselectable="on"  alt="' . _CUT . '" title="' . _CUT . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'cut\',\'\',\'' . $name . '\')">';
                    }
                    break;
                case 'floating':
                    $form .= '<img unselectable="on"  alt="' . _FLOAT . '" id="floating' . $name . '" title="' . _FLOAT . '" src="' . $skinUrl . '/floating.gif" onclick="XK_floatingToolbar(\'' . $name . '\',\'' . $skin . '\')">';
                    break;
                case 'fontname':
                    $form .= '<select id="fontname' . $name . '" class="' . $skin . 'selectInput" onchange="XK_DoTextFormat(\'fontname\',this.options[this.selectedIndex].value,\'' . $name . '\')"><option value="">' . _FONT . '</option>';
                    foreach ($fonts as $fontname => $font) {
                        $form .= '<option value="' . $font . '">' . $fontname . '</option>';
                    }
                    $form .= '</select>';

                    break;
                case 'fontsize':
                    $form .= '
					<select id="fontsize' . $name . '" class="' . $skin . 'selectInput" onchange="XK_DoTextFormat(\'fontsize\',this.options[this.selectedIndex].value,\'' . $name . '\')"">
						<option value="">' . _FONT_SIZE . '</option>
						<option value="-2">' . _FONT_XSMALL . '</option>
						<option value="-1">' . _FONT_SMALL . '</option>
						<option value="+0">' . _FONT_MEDIUM . '</option>
						<option value="+1">' . _FONT_LARGE . '</option>
						<option value="+2">' . _FONT_XLARGE . '</option>
						<option value="+4">' . _FONT_XXLARGE . '</option>
         			 </select>';
                    break;
                case 'forecolor':
                    $form .= '<img unselectable="on" alt="' . _FORECOLOR . '" id="forecolor' . $name . '" title="' . _FORECOLOR . '" src="' . $skinUrl . '/forecolor.gif" onclick="XK_Color(\'' . $name . '\',\'forecolor\',\'forecolor\')">';
                    $colorPalette = true;
                    break;
                case 'formatblock':
                    $form .= '	 
          			<select id="formatblock' . $name . '" class="' . $skin . 'selectInput" onchange="XK_DoTextFormat(\'formatblock\',this.options[this.selectedIndex].value,\'' . $name . '\')">
           				<option value="">' . _FONT_FORMAT . '</option>
						<option value="&lt;p&gt;">' . _FONT_NONE . '</option>
           				<option value="&lt;h1&gt;">' . _FONT_HEADING1 . '</option>
           				<option value="&lt;h2&gt;">' . _FONT_HEADING2 . '</option>
           				<option value="&lt;h3&gt;">' . _FONT_HEADING3 . '</option>
						<option value="&lt;h4&gt;">' . _FONT_HEADING4 . '</option>
						<option value="&lt;h5&gt;">' . _FONT_HEADING5 . '</option>
						<option value="&lt;h6&gt;">' . _FONT_HEADING6 . '</option>
						<option value="&lt;address&gt;">' . _FONT_ADDRESS . '</option>
					</select>';

                    break;
                case 'hilitecolor':
                    $form .= '<img unselectable="on" alt="' . _HILITECOLOR . '" id="hilitecolor' . $name . '" title="' . _HILITECOLOR . '" src="' . $skinUrl . '/hilitecolor.gif" onclick="XK_Color(\'' . $name . '\',\'hilitecolor\',\'hilitecolor\')">';
                    $colorPalette = true;
                    break;
                case 'imagemanager':
                    $form .= '<img unselectable="on"  alt="'
                             . _INSERTIMAGEM
                             . '" title="'
                             . _INSERTIMAGEM
                             . '" onmouseover="style.cursor=\'hand\'" onclick="javascript:openWithSelfMain(\''
                             . XOOPS_URL
                             . '/imagemanager.php?target='
                             . $name
                             . '\',\'imgmanager\',400,430);" src="'
                             . $skinUrl
                             . '/imagemanager.gif">';
                    break;
                case 'imageproperties':
                    $form .= '<img unselectable="on"  alt="'
                             . _WY_EDITIMAGE
                             . '" title="'
                             . _WY_EDITIMAGE
                             . '" src="'
                             . $skinUrl
                             . '/imageprops.gif" onclick="XK_OpenPopup(\''
                             . $url
                             . '/dialogs.php?id='
                             . $name
                             . '&amp;dialog=imageProps&amp;url='
                             . $this->getUrl()
                             . '&amp;skin='
                             . $skin
                             . '\',\'table\',600,450)">';
                    break;
                case 'indent':
                    $form .= '<img unselectable="on"  alt="' . _INDENT . '" title="' . _INDENT . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'indent\',\'\',\'' . $name . '\')">';
                    break;
                case 'inserthorizontalrule':
                    $form .= '<img unselectable="on"  alt="' . _INSERTHORIZONTALRULE . '" title="' . _INSERTHORIZONTALRULE . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'inserthorizontalrule\',\'\',\'' . $name . '\')">';
                    break;
                case 'insertanchor':
                    $form .= '<img unselectable="on"  alt="' . _INSERTANCHOR . '" title="' . _INSERTANCHOR . '" src="' . $skinUrl . '/insertanchor.gif" onclick="XK_InsertAnchor(\'' . $name . '\')">';
                    break;
                case 'insertimage':
                    $form .= '<img unselectable="on"  alt="' . _INSERTIMAGE . '" title="' . _INSERTIMAGE . '" src="' . $skinUrl . '/insertimage.gif" onclick="XK_DoTextFormat(\'insertimage\',\'\',\'' . $name . '\')">';
                    break;
                case 'insertorderedlist':
                    $form .= '<img unselectable="on"  alt="' . _INSERTORDEREDLIST . '" title="' . _INSERTORDEREDLIST . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'insertorderedlist\',\'\',\'' . $name . '\')">';
                    break;
                case 'insertunorderedlist':
                    $form .= '<img unselectable="on"  alt="' . _INSERTUNORDEREDLIST . '" title="' . _INSERTUNORDEREDLIST . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'insertunorderedlist\',\'\',\'' . $name . '\')">';
                    break;
                case 'insertsymbols':
                    $form .= $this->_renderInsertSymbols();
                    break;
                case 'italic':
                    $form .= '<img unselectable="on"  alt="' . _ITALIC . '" title="' . _ITALIC . '" src="' . $skinUrl . '/italic.gif" onclick="XK_DoTextFormat(\'italic\',\'\',\'' . $name . '\')">';
                    break;
                case 'justifycenter':
                    $form .= '<img unselectable="on"  alt="' . _JUSTIFYCENTER . '" title="' . _JUSTIFYCENTER . '" src="' . $skinUrl . '/justifycenter.gif" onclick="XK_DoTextFormat(\'justifycenter\',\'\',\'' . $name . '\')">';
                    break;
                case 'justifyfull':
                    $form .= '<img unselectable="on"  alt="' . _JUSTIFYFULL . '" title="' . _JUSTIFYFULL . '" src="' . $skinUrl . '/justifyfull.gif" onclick="XK_DoTextFormat(\'justifyfull\',\'\',\'' . $name . '\')">';
                    break;
                case 'justifyleft':
                    $form .= '<img unselectable="on"  alt="' . _JUSTIFYLEFT . '" title="' . _JUSTIFYLEFT . '" src="' . $skinUrl . '/justifyleft.gif" onclick="XK_DoTextFormat(\'justifyleft\',\'\',\'' . $name . '\')">';
                    break;
                case 'justifyright':
                    $form .= '<img unselectable="on"  alt="' . _JUSTIFYRIGHT . '" title="' . _JUSTIFYRIGHT . '" src="' . $skinUrl . '/justifyright.gif" onclick="XK_DoTextFormat(\'justifyright\',\'\',\'' . $name . '\')">';
                    break;
                case 'newline':
                    $form .= '<br>';
                    break;
                case 'newparagraph':
                    $form .= '<img unselectable="on"  alt="' . _NEWPARAGRAPH . '" title="' . _NEWPARAGRAPH . '" src="' . $skinUrl . '/newparagraph.gif" onclick="XK_InsertParagraph(\'' . $name . '\')">';
                    break;
                case 'outdent':
                    $form .= '<img unselectable="on"  alt="' . _OUTDENT . '" title="' . _OUTDENT . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'outdent\',\'\',\'' . $name . '\')">';
                    break;
                case 'paste':
                    if ($isie && $this->getHideNC()) {
                        $form .= '<img unselectable="on"  alt="' . _PASTE . '" title="' . _PASTE . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'paste\',null,\'' . $name . '\')">';
                    }
                    break;
                case 'print':
                    $form .= '<img unselectable="on"  alt="' . _PRINT . '" title="' . _PRINT . '" src="' . $skinUrl . '/print.gif" onclick="XK_Print(\'' . $name . '\')">';
                    break;
                case 'quote':
                    $form .= '<img unselectable="on"  alt="' . _QUOTE . '" title="' . _QUOTE . '" src="' . $skinUrl . '/quote.gif" onclick="XK_DoTextFormat(\'quote\',\'\',\'' . $name . '\')">';
                    break;
                case 'redo':
                    $form .= '<img unselectable="on"  alt="' . _REDO . '" title="' . _REDO . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'redo\',\'\',\'' . $name . '\')">';
                    break;
                case 'separator':
                    $form .= '<img unselectable="on"  alt="|" src="' . $skinUrl . '/separator.gif">';
                    break;
                case 'spellcheck':
                    $form .= '<img unselectable="on"  alt="' . _SPELLCHECK . '" title="' . _SPELLCHECK . '" src="' . $skinUrl . '/spellcheck.gif" onclick="XK_checkspell()">';
                    break;
                case 'strikethrough':
                    $form .= '<img unselectable="on"  alt="' . _STRIKETHROUGH . '" title="' . _STRIKETHROUGH . '" src="' . $skinUrl . '/strikethrough.gif" onclick="XK_DoTextFormat(\'strikethrough\',\'\',\'' . $name . '\')">';
                    break;
                case 'subscript':
                    $form .= '<img unselectable="on"  alt="' . _SUBSCRIPT . '" title="' . _SUBSCRIPT . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'subscript\',\'\',\'' . $name . '\')">';
                    break;
                case 'superscript':
                    $form .= '<img unselectable="on"  alt="' . _SUPERSCRIPT . '" title="' . _SUPERSCRIPT . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'superscript\',\'\',\'' . $name . '\')">';
                    break;
                case 'removeformat':
                    $form .= '<img unselectable="on"  alt="' . _REMOVEFORMAT . '" title="' . _REMOVEFORMAT . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'removeformat\',\'\',\'' . $name . '\')">';
                    $form .= '<img unselectable="on"  alt="' . _WY_REMOVE_DESC . '" title="' . _WY_REMOVE_DESC . '" id="rformatbutton' . $name . '" src="' . $skinUrl . '/popup.gif" onclick="XK_showHideDiv(\'' . $name . '\',\'rformatbutton\',\'RemoveFormat\')">';
                    $extraDivs .= $this->_renderCleanFormats();
                    break;
                case 'tableprops':
                    $form .= '<img unselectable="on"  alt="'
                                  . _WY_TABLEPROPS
                                  . '" title="'
                                  . _WY_TABLEPROPS
                                  . '" src="'
                                  . $skinUrl
                                  . '/tableprops.gif" onclick="XK_TTools(\''
                                  . $name
                                  . '\',\''
                                  . $url
                                  . '/dialogs.php?id='
                                  . $name
                                  . '&amp;dialog=tableProps&amp;skin='
                                  . $skin
                                  . '&amp;url='
                                  . $this->getUrl()
                                  . '\',\'table\',490,280)">';
                    $form .= '<img unselectable="on"  alt="' . _WY_TABLETOOLS . '" title="' . _WY_TABLETOOLS . '" id="tpropbutton' . $name . '" src="' . $skinUrl . '/popup.gif" onclick="XK_useTableOps(\'TableOps\',\'' . $name . '\')">';
                    $extraDivs .= $this->_renderTableProps();
                    break;
                case 'togglecellborders':
                    $form .= '<img unselectable="on"  alt="' . _TABLEBORDERS_TOGGLE . '" title="' . _TABLEBORDERS_TOGGLE . '" src="' . $skinUrl . '/toggletableborders.gif" onclick="XK_toggleBorders(\'' . $name . '\',\'document.body\')">';
                    break;
                case 'togglemode':
                    $ToggleMode = true;
                    break;
                case 'underline':
                    $form .= '<img unselectable="on"  alt="' . _UNDERLINE . '" title="' . _UNDERLINE . '" src="' . $skinUrl . '/underline.gif" onclick="XK_DoTextFormat(\'underline\',\'\',\'' . $name . '\')">';
                    break;
                case 'undo':
                    $form .= '<img unselectable="on"  alt="' . _UNDO . '" title="' . _UNDO . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'undo\',\'\',\'' . $name . '\')">';
                    break;
                case 'unlink':
                    $form .= '<img unselectable="on"  alt="' . _UNLINK . '" title="' . _UNLINK . '" src="' . $skinUrl . '/' . $tool . '.gif" onclick="XK_DoTextFormat(\'unlink\',\'\',\'' . $name . '\')">';
                    break;
                default:
                    break;
            }

            unset($koivi_editor_instances);
        }

        $form .= '</div></td></tr></table>';

        $form .= '<iframe class="' . $skin . 'wIframe" id="iframe' . $name . '" style=" width: 100%; height:' . $height . ';"></iframe>';

        $form .= '<div style="position:absolute; display: none;" id="colorpicker' . $name . '"></div>';

        //Render additional DIV'S

        if ($colorPalette) {
            require_once XOOPS_ROOT_PATH . '' . $this->getUrl() . '/class/colorpalette.class.php';

            $palette = new WysiwygColorPalette('XK_ApplyColor', $name, 'colorPalette', $url, $skin);

            $extraDivs .= $palette->_renderColorPalette();
        }

        $form .= $extraDivs;

        $form .= $this->_renderWysiwygSmileys();

        $form .= '</div>';

        $form .= '<textarea  id="' . $name . '" name="' . $name . '" rows="1" cols="1" style="display:none; width:' . $width . '; height:' . $height . '">' . $content . '</textarea>';

        $form .= '<input type="hidden" value="off" id="borderstoggle' . $name . '">';

        if ($ToggleMode) {
            $form .= '<div align="right" style="width:'
                     . $width
                     . ';"><img alt="" src="'
                     . $url
                     . '/skins/common/blank.gif" onload="XK_Init(\''
                     . $name
                     . '\',\''
                     . $isie
                     . '\',\''
                     . $url
                     . '\')"><img alt="'
                     . _TOGLE_MODE
                     . '" title="'
                     . _TOGLE_MODE
                     . '" src="'
                     . $skinUrl
                     . '/togglemode.gif" onclick="XK_doToggleView(\''
                     . $name
                     . '\')"></div>';
        }

        return $form;
    }

    public function _renderWysiwygSmileys()
    {
        $myts = MyTextSanitizer::getInstance();

        $name = $this->getName();

        $url = XOOPS_URL . '' . $this->getUrl();

        $ret = '<br>';

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $result = $db->query('SELECT * FROM ' . $db->prefix('smiles') . ' WHERE display=1');

        while (false !== ($smiles = $db->fetchArray($result))) {
            $ret .= '<img unselectable="on" onclick="XK_InsertImage(\'' . $name . '\',\'' . XOOPS_UPLOAD_URL . '/' . htmlspecialchars($smiles['smile_url'], ENT_QUOTES) . '\',\'\');" onmouseover="style.cursor=\'hand\'" src="' . XOOPS_UPLOAD_URL . '/' . htmlspecialchars(
                $smiles['smile_url'],
                ENT_QUOTES
            ) . '" alt="">';
        }

        $ret .= '&nbsp;[<a href="#moresmiley" onclick="javascript:openWithSelfMain(\'' . $url . '/dialogs.php?id=' . $name . '&amp;dialog=smilies&amp;url=' . $this->getUrl() . '\',\'smilies\',300,475);">' . _MORE . '</a>]';

        return $ret;
    }

    public function _renderTableProps()
    {
        $name = $this->getName();

        $url = XOOPS_URL . '' . $this->getUrl();

        $skinUrl = $url . '/skins/' . $this->getSkin();

        $skin = $this->getSkin();

        $ret = '
		<div id="TableOps' . $name . '" class="' . $skin . 'tablePropsD" style="display:none;">
    			<img unselectable="on" title="' . _WY_INSERTROW . '" alt="' . _WY_INSERTROW . '" src="' . $skinUrl . '/insertrow.gif" width="20" height="20"  onclick="XK_useTableOps(\'insertRow\',\'' . $name . '\');">
				<img unselectable="on" title="' . _WY_INSERTCOL . '" alt="' . _WY_INSERTCOL . '" src="' . $skinUrl . '/insertcol.gif" width="20" height="20" onclick="XK_useTableOps(\'insertCol\',\'' . $name . '\');">
				<img unselectable="on" title="' . _WY_INSERTCELL . '" alt="' . _WY_INSERTCELL . '" src="' . $skinUrl . '/insertcell.gif" width="20" height="20" onclick="XK_useTableOps(\'insertCell\',\'' . $name . '\');">
				<img unselectable="on" title="' . _WY_DELROW . '" alt="' . _WY_DELROW . '" src="' . $skinUrl . '/delrow.gif" width="20" height="20" onclick="XK_useTableOps(\'deleteRow\',\'' . $name . '\');">
				<img unselectable="on" title="' . _WY_DELCOL . '" alt="' . _WY_DELCOL . '" src="' . $skinUrl . '/delcol.gif" width="20" height="20" onclick="XK_useTableOps(\'deleteCol\',\'' . $name . '\');">
				<img unselectable="on"  title="' . _WY_DELCELL . '" alt="' . _WY_DELCELL . '" src="' . $skinUrl . '/delcell.gif" width="20" height="20"  onclick="XK_useTableOps(\'deleteCell\',\'' . $name . '\');">
				<img unselectable="on"  title="' . _WY_MOREROWSPAN . '" alt="' . _WY_MOREROWSPAN . '" src="' . $skinUrl . '/morerowspan.gif" width="20" height="20"  onclick="XK_useTableOps(\'increaseRowSpan\',\'' . $name . '\');">
				<img unselectable="on"  title="' . _WY_LESSROWSPAN . '" alt="' . _WY_LESSROWSPAN . '" src="' . $skinUrl . '/lessspan.gif" width="20" height="20" onclick="XK_useTableOps(\'decreaseRowSpan\',\'' . $name . '\');">
				<img unselectable="on"  title="' . _WY_MORECOLSPAN . '" alt="' . _WY_MORECOLSPAN . '" src="' . $skinUrl . '/morespan.gif" width="20" height="20"  onclick="XK_useTableOps(\'increaseSpan\',\'' . $name . '\');">
				<img unselectable="on"  title="' . _WY_LESSCOLSPAN . '" alt="' . _WY_LESSCOLSPAN . '" src="' . $skinUrl . '/lessspan.gif" width="20" height="20" onclick="XK_useTableOps(\'decreaseSpan\',\'' . $name . '\');">
		</div>
		
		';

        return $ret;
    }

    public function _renderCellAlign()
    {
        $name = $this->getName();

        $url = XOOPS_URL . '' . $this->getUrl();

        $skinUrl = $url . '/skins/' . $this->getSkin();

        $skin = $this->getSkin();

        $ret = '<div class="'
               . $skin
               . 'cellAlignD" id="CellAlign'
               . $name
               . '" style="display: none;">
			  <table unselectable="on"  border="0" cellspacing="8" cellpadding="0">
  				<tr unselectable="on" >
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNLEFTTOP
               . '" title="'
               . _WY_CELLALIGNLEFTTOP
               . '" src="'
               . $skinUrl
               . '/lefttop.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'left\',\'top\')"></td>
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNCENTERTOP
               . '" title="'
               . _WY_CELLALIGNCENTERTOP
               . '" src="'
               . $skinUrl
               . '/centertop.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'center\',\'top\')"></td>
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNRIGHTTOP
               . '" title="'
               . _WY_CELLALIGNRIGHTTOP
               . '" src="'
               . $skinUrl
               . '/righttop.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'right\',\'top\')"></td>
			    </tr>
			    <tr unselectable="on" >
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNLEFTMIDDLE
               . '" title="'
               . _WY_CELLALIGNLEFTMIDDLE
               . '" src="'
               . $skinUrl
               . '/leftmiddle.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'left\',\'middle\')"></td>
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNCENTERMIDDLE
               . '" title="'
               . _WY_CELLALIGNCENTERMIDDLE
               . '" src="'
               . $skinUrl
               . '/centermiddle.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'center\',\'middle\')"></td>
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNRIGHTMIDDLE
               . '" title="'
               . _WY_CELLALIGNRIGHTMIDDLE
               . '" src="'
               . $skinUrl
               . '/rightcenter.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'right\',\'middle\')"></td>
			  </tr>
			  <tr>
    				<td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNLEFTBOTTOM
               . '" title="'
               . _WY_CELLALIGNLEFTBOTTOM
               . '" src="'
               . $skinUrl
               . '/leftbottom.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'left\',\'bottom\')"></td>
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNCENTERBOTTOM
               . '" title="'
               . _WY_CELLALIGNCENTERBOTTOM
               . '" src="'
               . $skinUrl
               . '/centerbottom.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'center\',\'bottom\')"></td>
				    <td unselectable="on"  onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
               . _WY_CELLALIGNRIGHTBOTTOM
               . '" title="'
               . _WY_CELLALIGNRIGHTBOTTOM
               . '" src="'
               . $skinUrl
               . '/rightbottom.gif" width="15" height="13" onclick="XK_cellAlign(\''
               . $name
               . '\',\'right\',\'bottom\')"></td>
			  </tr>
		   </table>
		  </div>';

        return $ret;
    }

    public function _renderCleanFormats()
    {
        $name = $this->getName();

        $url = XOOPS_URL . '' . $this->getUrl();

        $skinUrl = $url . '/skins/' . $this->getSkin();

        $skin = $this->getSkin();

        $ret = '<div class="' . $skin . 'ClearFormatsD" id="RemoveFormat' . $name . '" style="display: none;">				
				<table width="100%" cellspacing="0" cellpadding="0" unselectable="on">
  					<tr unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';" onclick="XK_removeFormat(\'' . $name . '\',\'span\');">
						<td unselectable="on"><img alt="" src="' . $skinUrl . '/removef_span.gif"></td>
			    		<td><div class="' . $skin . 'DivOption">' . _WY_REMOVE_SPANF . '</div></td>
					</tr>
			    	<tr unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';" onclick="XK_removeFormat(\'' . $name . '\',\'font\');">
						<td unselectable="on" ><img alt="" src="' . $skinUrl . '/removef_font.gif"></td>
						<td unselectable="on" ><div class="' . $skin . 'DivOption">' . _WY_REMOVE_FONTF . '</div></td>
					</tr>
					<tr unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';" onclick="XK_removeFormat(\'' . $name . '\',\'word\');;">
						<td unselectable="on"><img alt="" src="' . $skinUrl . '/removef_word.gif"></td>
    					<td unselectable="on"><div class="' . $skin . 'DivOption">' . _WY_REMOVE_WORDF . '</div></td>
  					</tr>
				</table>
			</div>';

        return $ret;
    }

    public function _renderCellBorders()
    {
        $name = $this->getName();

        $url = XOOPS_URL . '' . $this->getUrl();

        $skinUrl = $url . '/skins/' . $this->getSkin();

        $skin = $this->getSkin();

        $ret = '<div class="'
                   . $skin
                   . 'cellBordersD" style="display:none;" id="CellBorders'
                   . $name
                   . '">
					<table border="0" cellspacing="8" cellpadding="0" unselectable="on">
						<tr unselectable="on">
							<td unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
                   . _WY_CELLALIGNLEFTTOP
                   . '" title="'
                   . _WY_CELLALIGNLEFTTOP
                   . '" src="'
                   . $skinUrl
                   . '/borderall.gif" width="13" height="13" onclick="XK_quickBorders(\''
                   . $name
                   . '\',\'all\',\'Black\')"></td>
							<td unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
                   . _WY_CELLALIGNCENTERTOP
                   . '" title="'
                   . _WY_CELLALIGNCENTERTOP
                   . '" src="'
                   . $skinUrl
                   . '/borderleft.gif" width="13" height="13" onclick="XK_quickBorders(\''
                   . $name
                   . '\',\'left\',\'Black\')"></td>
							<td unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
                   . _WY_CELLALIGNRIGHTTOP
                   . '" title="'
                   . _WY_CELLALIGNRIGHTTOP
                   . '" src="'
                   . $skinUrl
                   . '/borderright.gif" width="13" height="13" onclick="XK_quickBorders(\''
                   . $name
                   . '\',\'right\',\'Black\')"></td>
						</tr>
						<tr unselectable="on">
							<td unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
                   . _WY_CELLALIGNLEFTMIDDLE
                   . '" title="'
                   . _WY_CELLALIGNLEFTMIDDLE
                   . '" src="'
                   . $skinUrl
                   . '/bordernone.gif" width="13" height="13" onclick="XK_quickBorders(\''
                   . $name
                   . '\',\'none\',\'Black\')"></td>
							<td unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
                   . _WY_CELLALIGNCENTERMIDDLE
                   . '" title="'
                   . _WY_CELLALIGNCENTERMIDDLE
                   . '" src="'
                   . $skinUrl
                   . '/bordertop.gif" width="13" height="13" onclick="XK_quickBorders(\''
                   . $name
                   . '\',\'top\',\'Black\')"></td>
							<td unselectable="on" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"><img alt="'
                   . _WY_CELLALIGNRIGHTMIDDLE
                   . '" title="'
                   . _WY_CELLALIGNRIGHTMIDDLE
                   . '" src="'
                   . $skinUrl
                   . '/borderbottom.gif" width="13" height="13" onclick="XK_quickBorders(\''
                   . $name
                   . '\',\'bottom\',\'Black\')"></td>
						</tr>
					</table>
				</div>';

        return $ret;
    }

    public function _renderQuickTable()
    {
        $name = $this->getName();

        $url = XOOPS_URL . '' . $this->getUrl();

        $skin = $this->getSkin();

        $ret = '<div class="' . $skin . 'quickTableD" style=" display:none; " id="tablepicker' . $name . '">';

        $ret .= '<table unselectable="on">';

        for ($i = 1; $i < 8; $i++) {
            $ret .= '<tr unselectable="on">';

            for ($j = 1; $j < 8; $j++) {
                $ret .= '<td unselectable="on" class=\''
                        . $skin
                        . 'tdPicker\' id="'
                        . $name
                        . '-'
                        . $i
                        . '-'
                        . $j
                        . '" bgcolor="#FFFFFF" onmouseover="XK_tableOver(\''
                        . $name
                        . '\',\''
                        . $i
                        . '\',\''
                        . $j
                        . '\')" onmouseout="XK_tableOut(\''
                        . $name
                        . '\',\''
                        . $i
                        . '\',\''
                        . $j
                        . '\')" onclick="XK_tableClick(\''
                        . $name
                        . '\',\''
                        . $i
                        . '\',\''
                        . $j
                        . '\')"><img alt="" width="5" height="5" src="'
                        . $url
                        . '/skins/common/blank.gif"></td>';
            }

            $ret .= '</tr>';
        }

        $ret .= '</table></div>';

        return $ret;
    }

    public function _renderInsertSymbols()
    {
        $name = $this->getName();

        $skin = $this->getSkin();

        $url = XOOPS_URL . '' . $this->getUrl();

        $symbols = [
            '{',
            '|',
            '}',
            '~',
            '&euro;',
            '&lsquo;',
            '&rsquo;',
            '&rsquo;',
            '&ldquo;',
            '&rdquo;',
            '&ndash;',
            '&mdash;',
            '&iexcl;',
            '&cent;',
            '&pound;',
            '&curren;',
            '&yen;',
            '&brvbar;',
            '&sect;',
            '&uml;',
            '&copy;',
            '&ordf;',
            '&laquo;',
            '&not;',
            '&reg;',
            '&macr;',
            '&deg;',
            '&plusmn;',
            '&sup2;',
            '&sup3;',
            '&acute;',
            '&micro;',
            '&para;',
            '&middot;',
            '&cedil;',
            '&sup1;',
            '&ordm;',
            '&raquo;',
            '&frac14;',
            '&frac12;',
            '&frac34;',
            '&iquest;',
            '&Agrave;',
            '&Aacute;',
            '&Acirc;',
            '&Atilde;',
            '&Auml;',
            '&Aring;',
            '&AElig;',
            '&Ccedil;',
            '&Egrave;',
            '&Eacute;',
            '&Ecirc;',
            '&Euml;',
            '&Igrave;',
            '&Iacute;',
            '&Icirc;',
            '&Iuml;',
            '&ETH;',
            '&Ntilde;',
            '&Ograve;',
            '&Oacute;',
            '&Ocirc;',
            '&Otilde;',
            '&Ouml;',
            '&times;',
            '&Oslash;',
            '&Ugrave;',
            '&Uacute;',
            '&Ucirc;',
            '&Uuml;',
            '&Yacute;',
            '&THORN;',
            '&szlig;',
            '&agrave;',
            '&aacute;',
            '&acirc;',
            '&atilde;',
            '&auml;',
            '&aring;',
            '&aelig;',
            '&ccedil;',
            '&egrave;',
            '&eacute;',
            '&ecirc;',
            '&euml;',
            '&igrave;',
            '&iacute;',
            '&icirc;',
            '&iuml;',
            '&eth;',
            '&ntilde;',
            '&ograve;',
            '&oacute;',
            '&ocirc;',
            '&otilde;',
            '&ouml;',
            '&divide;',
            '&oslash;',
            '&ugrave;',
            '&uacute;',
            '&ucirc;',
            '&uuml;',
            '&uuml;',
            '&yacute;',
            '&thorn;',
            '&yuml;',
        ];

        $length = count($symbols);

        $i = 0;

        $ret = ' <select id="insertsymbol' . $name . '" class="' . $skin . 'selectInput" name="select' . $name . '" onchange=\'XK_InsertSymbol(this.options[this.selectedIndex].value, "' . $name . '")\'>';

        $ret .= '<option value="" selected="selected">' . _WY_SYMBOLS . '</option>';

        while ($i < $length) {
            $ret .= '<option value="' . $symbols[$i] . '">' . $symbols[$i] . '</option>';

            $i++;
        }

        $ret .= '</select>';

        return $ret;
    }
}

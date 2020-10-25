<?php

// $Id: dialogs.php,V 1.0 pre release 29/Sep/2004 0:24 Samuels Exp $
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
$dialog = $_GET['dialog'] ?? 'none';
$tableprop = $_GET['tableprop'] ?? 0;
$skin = $_GET['skin'] ?? 'default';
$url = $_GET['url'] ?? '/modules/sections/wysiwyg';
$id = $_GET['id'] ?? '';

require_once __DIR__ . '/include/functions.inc.php';
require_once getMainFile($url);
require_once getLanguage($url);

switch ($dialog) {
    case 'smilies':
        xoops_header(false);
        echo '
		<script type="text/javascript" src="' . XOOPS_URL . '' . $url . '/include/js/dialogs.js"></script>
		</head><body>
		<table width="100%" class="outer">
		<tr>
		<th colspan="3">' . _MSC_SMILIES . '</th>
		</tr>
		<tr class="head">
		<td>' . _MSC_CODE . '</td>
		<td>' . _MSC_EMOTION . '</td>
		<td>' . _IMAGE . '</td>
		</tr>';
        if ($getsmiles = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('smiles'))) {
            $rcolor = 'even';

            while (false !== ($smile = $xoopsDB->fetchArray($getsmiles))) {
                echo "<tr class='$rcolor'><td>"
                     . $smile['code']
                     . '</td><td>'
                     . $smile['emotion']
                     . "</td><td><img onmouseover='style.cursor=\"hand\"' onclick=\"sendSmilie('"
                     . $id
                     . "','"
                     . XOOPS_UPLOAD_URL
                     . '/'
                     . $smile['smile_url']
                     . "')\" src='"
                     . XOOPS_UPLOAD_URL
                     . '/'
                     . $smile['smile_url']
                     . "' alt=''></td></tr>";

                $rcolor = ('even' == $rcolor) ? 'odd' : 'even';
            }
        } else {
            echo 'Could not retrieve data from the database.';
        }
        echo '</table>' . _MSC_CLICKASMILIE;
        echo '</body></html>';
        break;
    case 'table':
        xoops_header(false);
        echo '
		<script type="text/javascript" src="' . XOOPS_URL . '' . $url . '/include/js/dialogs.js"></script>
		</head><body>';

        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $sform = new XoopsThemeForm(_WY_INSERTTABLE, 'table', xoops_getenv('PHP_SELF'));
        $sform->addElement(new XoopsFormText(_WY_ROWS, 'rows', 4, 4, '2'), true);
        $sform->addElement(new XoopsFormText(_WY_COLS, 'columns', 4, 4, '2'), true);
        $sform->addElement(new XoopsFormText(_WY_WIDTH, 'width_value', 4, 4, '100'), true);
        $sform->addElement(new XoopsFormText(_WY_HEIGHT, 'height_value', 4, 4, '100'), true);
        $sform->addElement(new XoopsFormText(_WY_BORDER, 'border', 4, 4, '1'), true);
        $sform->addElement(new XoopsFormText(_WY_SPACING, 'cell_spacing', 4, 4, '1'), true);
        $sform->addElement(new XoopsFormText(_WY_PADDING, 'cell_padding', 4, 4, '1'), true);
        $button_tray = new XoopsFormElementTray('', '');
        $button_submit = new XoopsFormButton('', '', _SUBMIT, 'button');
        $button_submit->setExtra('onclick="sendTable(\'' . $id . '\')"');
        $button_cancel = new XoopsFormButton('', '', _CANCEL, 'button');
        $button_cancel->setExtra('onclick="window.close()"');
        $button_tray->addElement($button_submit);
        $button_tray->addElement($button_cancel);
        $sform->addElement($button_tray);
        $sform->display();

        echo '</body></html>';

        break;
    case 'cellProps':
        require_once XOOPS_ROOT_PATH . '' . $url . '/class/colorpalette.class.php';
        require_once XOOPS_ROOT_PATH . '' . $url . '/class/borderfieldset.class.php';

        echo '	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>Cell Props</title>
			<link href="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/' . $skin . '.css" rel="stylesheet" type="text/css">
			<script type="text/javascript" src="' . XOOPS_URL . '' . $url . '/include/js/dialogs.js"></script>
			</head>';
        echo '<body class="' . $skin . 'cellPropsBody" onload="initCellProps(\'' . $id . '\')">';
        $uni = '<option value="px">px</option>
            	<option value="em">em</option>
            	<option value="ex">ex</option>
            	<option value="cm" >cm</option>
            	<option value="mm">mm</option>
            	<option value="pc">pc</option>
            	<option value="in">in</option>
            	<option value="pt">pt</option>';

        $units = $uni . '<option value="%">%</option>';

        $palette = new WysiwygColorPalette('XK_CC', '', 'colordiv', XOOPS_URL . '/' . $url, $skin);
        $palette->display();

        echo '<form name="form1" method="post" action="">
					<table>
						<tr>
							<td colspan="2">';
        $borders = new WysiwygBorderFieldset($url, $skin, 'cellPreview()');
        $borders->display();
        echo '				</td>
    				<td>

				<fieldset class="' . $skin . 'cellOFieldset">
    <legend>' . _WY_CELLPADDING . '</legend>
    <table border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td>' . _WY_BORDERLEFT . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="paddingLeft" onchange="cellPreview()">
      <select class="' . $skin . 'Input3" id="paddingLeftUnits" onchange="cellPreview()">
            										' . $uni . '
      </select></td>
      </tr>
      <tr>
        <td>' . _WY_BORDERRIGHT . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="paddingRight" onchange="cellPreview()">
      <select class="' . $skin . 'Input3" id="paddingRightUnits" onchange="cellPreview()">
            										' . $uni . '
      </select></td>
      </tr>
      <tr>
        <td>' . _WY_BORDERTOP . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="paddingTop" onchange="cellPreview()">
      <select class="' . $skin . 'Input3" id="paddingTopUnits" onchange="cellPreview()">
            										' . $uni . '
      </select></td>
      </tr>
      <tr>
        <td>' . _WY_BORDERBOTTOM . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="paddingBottom" onchange="cellPreview()">
      <select class="' . $skin . 'Input3" id="paddingBottomUnits" onchange="cellPreview()">
            										' . $uni . '
      </select></td>
      </tr>
    </table>
    </fieldset>
		</td>
  	</tr>
</table>
<table>
  <tr>
    <td><fieldset class="' . $skin . 'cellOFieldset">
    <legend>' . _WY_OTHERS . '</legend>
    <table border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td>' . _WY_FORECOLOR . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="bgColor" onchange="cellPreview()" maxlength="7">
        <img style="height:16px;width:10px;" alt="' . _FORECOLOR . '" id="bg" title="' . _FORECOLOR . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif" onclick="XK_Color(\'bg\')"></td>
      </tr>
      <tr>
        <td>' . _WY_IMGBACK . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="backgroundImage" onchange="cellPreview()">
		<img style="height:16px;width:10px;" alt="' . _INSERTIMAGEM . '" id="bg" title="' . _INSERTIMAGEM . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif"onclick="openWithSelfMain(\'' . XOOPS_URL . '/imagemanager.php?target=' . $id . '\',\'imgmanager\',400,430)">
		</td>
      </tr>
      <tr>
        <td>' . _WY_WIDTH . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="cellWidth" onchange="cellPreview()">
      <select class="' . $skin . 'Input3" id="widthUnits" onchange="cellPreview()">
            										' . $units . '
      </select>
	  </td>
      </tr>
      <tr>
        <td>' . _WY_HEIGHT . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="cellHeight" onchange="cellPreview()">
            <select class="' . $skin . 'Input3" id="heightUnits" onchange="cellPreview()">
            	' . $units . '
            </select>
		 </td>
      </tr>
	  <tr>
	  <td>' . _WY_CLASS . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="class" onchange="cellPreview()">
	  </td>
	  </tr>
    </table>
    </fieldset></td>
    <td>
	
					<fieldset class="' . $skin . 'cellPreviewFieldset">
    			<legend>' . _WY_PREVIEW . '</legend>
					<div align="center" class="' . $skin . 'cellPreviewDiv">
						<table border="0" id="previewCell">
          					<tr>
           						<td id="PreviewCell2">test</td>
          					</tr>
        				</table>
					</div>  
    			</fieldset>
	
	</td>
  </tr>
</table>
<input type="button" value="Ok" onclick="sendCell(\'' . $id . '\')">
<input type="reset" value="Reset" onclick="cellPreview()">
</form>
</body>
</html>
';

        break;
    case 'tableProps':
        require_once XOOPS_ROOT_PATH . '' . $url . '/class/colorpalette.class.php';

        echo '	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>Cell Props</title>
			<link href="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/' . $skin . '.css" rel="stylesheet" type="text/css">
			<script type="text/javascript" src="' . XOOPS_URL . '' . $url . '/include/js/dialogs.js"></script>
			</head>';
        echo '<body class="' . $skin . 'cellPropsBody" onload="initTableProps(\'' . $id . '\')">';

        $palette = new WysiwygColorPalette('XK_TableC', '', 'colordiv', XOOPS_URL . '/' . $url, $skin);
        $palette->display();

        echo '<form name="form1" method="post" action="">
<table>
  <tr>
    <td><fieldset class="' . $skin . 'tableOFieldset">
    <legend>' . _WY_OTHERS . '</legend>
    <table border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td>' . _WY_FORECOLOR . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="bgColor" onchange="tablePreview()" maxlength="7">
        <img style="height:16px;width:10px;" alt="' . _FORECOLOR . '" id="bg" title="' . _FORECOLOR . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif" onclick="XK_Color(\'bg\')"></td>
      </tr>
	  <tr>
        <td>' . _WY_BORDERCOLOR . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="bordertColor" onchange="tablePreview()" maxlength="7">
        <img style="height:16px;width:10px;" alt="' . _WY_BORDERCOLOR . '" id="bordert" title="' . _WY_BORDERCOLOR . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif" onclick="XK_Color(\'bordert\')"></td>
      </tr>
      <tr>
        <td>' . _WY_IMGBACK . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="backgroundImage" onchange="tablePreview()">
		<img style="height:16px;width:10px;" alt="' . _INSERTIMAGEM . '" id="bi" title="' . _INSERTIMAGEM . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif"onclick="openWithSelfMain(\'' . XOOPS_URL . '/imagemanager.php?target=' . $id . '\',\'imgmanager\',400,430)">
		</td>
      </tr>
      <tr>
        <td>' . _WY_WIDTH . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="width" onchange="tablePreview()">
      </select>
	  </td>
      </tr>
      <tr>
        <td>' . _WY_HEIGHT . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="height" onchange="tablePreview()">
		 </td>
      </tr>
	  <tr>
        <td>' . _WY_BORDER . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="border" onchange="tablePreview()">
		 </td>
      </tr>
	  <tr>
        <td>' . _WY_PADDING . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="padding" onchange="tablePreview()">
		 </td>
      </tr>
	  <tr>
        <td>' . _WY_SPACING . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="spacing" onchange="tablePreview()">
		 </td>
      </tr>
	  <tr>
	  <td>' . _WY_CLASS . '</td>
        <td><input type="text" class="' . $skin . 'Input" id="class" onchange="tablePreview()">
	  </td>
	  </tr>
    </table>
    </fieldset></td>
    <td>
	
					<fieldset class="' . $skin . 'tablePreviewFieldset">
    			<legend>' . _WY_PREVIEW . '</legend>
					<div align="center" class="' . $skin . 'tablePreviewDiv">
						<table border="0" id="previewTable">
          					<tr>
           						<td>test</td>
								<td>test</td>
          					</tr>
							<tr>
           						<td>test</td>
								<td>test</td>
          					</tr>
        				</table>
					</div>  
    			</fieldset>
	
	</td>
  </tr>
</table>
<input type="button" value="Ok" onclick="sendTableProps(\'' . $id . '\')">
<input type="reset" value="Reset" onclick="cellPreview()">
</form>
</body>
</html>
';
        break;
    case 'imageProps':
        require_once XOOPS_ROOT_PATH . '' . $url . '/class/colorpalette.class.php';
        require_once XOOPS_ROOT_PATH . '' . $url . '/class/borderfieldset.class.php';
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>' . _WY_IMAGEPROPS . '</title>
			<link href="' . XOOPS_URL . '' . $url . '/skins/' . $skin . '/' . $skin . '.css" rel="stylesheet" type="text/css">
			<script type="text/javascript" src="' . XOOPS_URL . '' . $url . '/include/js/dialogs.js"></script>
			</head>';
        echo '<body class="' . $skin . 'imagePropsBody" onload="initImageProps(\'' . $id . '\')">';
        $units = '<option value="px">px</option>
            	<option value="em">em</option>
            	<option value="ex">ex</option>
            	<option value="cm" >cm</option>
            	<option value="mm">mm</option>
            	<option value="pc">pc</option>
            	<option value="in">in</option>
            	<option value="pt">pt</option>';
        $palette = new WysiwygColorPalette('XK_ImgPrev', '', 'colordiv', XOOPS_URL . '/' . $url, $skin);
        $palette->display();

        echo '		<form name="form1" method="post" action="">
				<table>
						<tr>
							<td colspan="2" valign="top">';
        $borders = new WysiwygBorderFieldset($url, $skin, 'imagePreview()');
        $borders->display();
        echo '</td>
    						<td valign="top">
								<fieldset class="' . $skin . 'imageMarginsFieldset">
    								<legend>' . _WY_MARGINS . '</legend>
    									<table border="0" cellpadding="3" cellspacing="0">
											<tr>
        										<td>
													
												</td>
        										<td>
													' . _WY_BWIDTH . '
												</td>
												<td>
													' . _WY_UNITS . '
												</td>
      										</tr>
      										<tr>
        										<td>
													' . _WY_LEFT . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="marginLeft" onchange="imagePreview()">
												</td>
												<td><select class="' . $skin . 'Input3" id="marginLeftUnits" onchange="imagePreview()">
            										' . $units . '
                									</select>
												</td>
      										</tr>
     										 <tr>
        										<td> 
													' . _WY_RIGHT . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="marginRight" onchange="imagePreview()">
												</td>
												<td><select class="' . $skin . 'Input3" id="marginRightUnits" onchange="imagePreview()">
            										' . $units . '
                									</select>
												</td>
     										 </tr>
      										 <tr>
        										<td>
													' . _WY_TOP . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="marginTop" onchange="imagePreview()">
												</td>
												<td><select class="' . $skin . 'Input3" id="marginTopUnits" onchange="imagePreview()">
            										' . $units . '
                									</select>
												</td>
      										</tr>
      										<tr>
        										<td>
													' . _WY_BOTTOM . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="marginBottom" onchange="imagePreview()">
												</td>
												<td><select class="' . $skin . 'Input3" id="marginBottomUnits" onchange="imagePreview()">
            										' . $units . '
                									</select>
												</td>
      										</tr>
    								</table>
								</fieldset>
							</td>
  						</tr>
					</table>
					<fieldset class="' . $skin . 'imageSrcFieldset">
					<legend>' . _WY_IMAGEPROPS . '</legend>
						<table border="0" cellspacing="2" cellpadding="0">
      						<tr>
        						<td>
									' . _WY_ALT . '
								</td>
        						<td>
									<input type="text" class="' . $skin . 'Input4" id="alt" onchange="imagePreview()">
								</td>
      						</tr>
      						<tr>
        						<td>
									' . _WY_SRC . '
								</td>
        						<td>
									<input type="text" class="' . $skin . 'Input4" id="src" onchange="imagePreview()">
								</td>
      						</tr>
						</table>
					</fieldset>
					<table>
  						<tr>
    						<td valign="top">
								<fieldset class="' . $skin . 'imageOFieldset">
    								<legend>' . _WY_OTHERS . '</legend>
    									<table border="0" cellspacing="0" cellpadding="3">
      										<tr>
        										<td>
													' . _WY_IMAGEALIGN . '
												</td>
        										<td>
													<select class="' . $skin . 'Input2" id="align" onchange="imagePreview()" >
          												<option value="">-</option>
														<option value="baseline">Linea de Base</option>
          												<option value="top">' . _WY_TOP . '</option>
          												<option value="middle">' . _WY_MIDDLE . '</option>
          												<option value="bottom">' . _WY_BOTTOM . '</option>
														<option value="texttop">' . _WY_TEXTTOP . '</option>
          												<option value="absmiddle">' . _WY_ABSMIDDLE . '</option>
          												<option value="absbottom">' . _WY_ABSBOTTOM . '</option>
          												<option value="left">' . _WY_LEFT . '</option>
          												<option value="right">' . _WY_RIGHT . '</option>
          											</select>
        										</td>
      										</tr>
      										<tr>
        										<td>
													' . _WY_WIDTH . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="width" onchange="imagePreview()">px
	
												</td>
      										</tr>
      										<tr>
        										<td>
													' . _WY_HEIGHT . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="height" onchange="imagePreview()">px
													
												</td>
      										</tr>
											<tr>
        										<td>
													' . _WY_HSPACE . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="hspace" onchange="imagePreview()">
												</td>
      										</tr>
											<tr>
        										<td>
													' . _WY_VSPACE . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="vspace" onchange="imagePreview()">
												</td>
      										</tr>
											<tr>
        										<td>
													' . _WY_CLASS . '
												</td>
        										<td>
													<input type="text" class="' . $skin . 'Input" id="className" onchange="imagePreview()">
												</td>
      										</tr>
    									</table>
    								</fieldset>
								</td>
    							<td valign="top">
									<fieldset class="' . $skin . 'imagePreviewFieldset">
    									<legend>' . _WY_PREVIEW . '</legend>
    										<div style="padding-left:12px;">
												<table border="0" id="previewCell">
          											<tr>
           												<td id="PreviewCell2">
															<div class="' . $skin . 'imagePreview">
																<img id="previewimage" alt="" src="' . XOOPS_URL . '/' . $url . '/skins/common/xoops.gif" width="61" height="61">En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no hace mucho tiempo que viv&iacute;a un hidalgo de noble cuna, que pose&iacute;a un antiguo escudo, una lanza en astillero, un roc&iacute;n flaco y un galgo corredor. Era de condici&oacute;n modesta; y as&iacute;, las tres partes de su hacienda...
															</div>
														</td>
          											</tr>
        										</table>
											</div>  
    									</fieldset>
									</td>
  								</tr>
							</table>									
						<input type="button" value="Ok" onclick="sendImage(\'' . $id . '\')">
					</form>
				</body>
			</html>
';

        break;
    case 'createLink':
        xoops_header(false);
        echo '
		<script type="text/javascript" src="' . XOOPS_URL . '' . $url . '/include/js/dialogs.js"></script></head>
		<body onLoad="XK_MakeAnchorSelect(\'' . $id . '\')">';

        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $sform = new XoopsThemeForm(_WY_EDITIMAGE, 'linkform', xoops_getenv('PHP_SELF'));
        $sform->addElement(new XoopsFormText('Url', 'url', 20, 100, ''), true);
        $select = new XoopsFormSelect('Anchor', 'anchor', '', 1, false);
        $select->setExtra('onchange="XK_disableUrlTextField(this.options[this.selectedIndex].value)"');
        $sform->addElement($select);
        $sform->addElement(new XoopsFormSelect('Open', 'open', '', 1, false), true);
        $button_tray = new XoopsFormElementTray('', '');
        $button_submit = new XoopsFormButton('', '', _SUBMIT, 'button');
        $button_submit->setExtra('onclick="sendImage(\'' . $id . '\')"');
        $button_cancel = new XoopsFormButton('', '', _CANCEL, 'button');
        $button_cancel->setExtra('onclick="window.close()"');
        $button_tray->addElement($button_submit);
        $button_tray->addElement($button_cancel);
        $sform->addElement($button_tray);
        $sform->display();

        break;
    default:
        echo '<body onload="window.close()">';
        echo 'ERROR';
        echo '</body>';
        break;
}

<?php

// $Id: borderfieldset.class.php,V 1.0 pre release 29/Sep/2004 3:04 Samuels Exp $
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

class WysiwygBorderFieldset
{
    public $url;

    public $skin;

    public $onchange;

    public function __construct($url, $skin, $onchange)
    {
        $this->setUrl($url);

        $this->setSkin($skin);

        $this->setonchange($onchange);
    }

    public function getonchange()
    {
        return $this->onchange;
    }

    public function setonchange($onchange)
    {
        $this->onchange = $onchange;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getSkin()
    {
        return $this->skin;
    }

    public function setSkin($skin)
    {
        $this->skin = $skin;
    }

    public function _renderBorders()
    {
        $url = $this->getUrl();

        $onchange = $this->getonchange();

        $skin = $this->getSkin();

        $option = '<option value="">-</option>
				<option value="none">none</option>
            	<option value="dotted">dotted</option>
            	<option value="dashed">dashed</option>
            	<option value="solid" selected="selected">solid</option>
            	<option value="double">double</option>
            	<option value="groove">groove</option>
            	<option value="ridge">ridge</option>
            	<option value="outset">outset</option>';

        $units = '<option value="px">px</option>
            	<option value="em">em</option>
            	<option value="ex">ex</option>
            	<option value="cm" >cm</option>
            	<option value="mm">mm</option>
            	<option value="pc">pc</option>
            	<option value="in">in</option>
            	<option value="pt">pt</option>';

        $borders = '<fieldset class="' . $skin . 'BorderFieldset">
    						<legend>' . _WY_BORDERS . '</legend>
    						<table border="0" cellspacing="0" cellpadding="2">
      							<tr>
        							<td>&nbsp;</td>
        							<td>' . _WY_BORDERS . '</td>
        							<td>' . _FORECOLOR . '</td>
									<td></td>
        							<td>' . _WY_BWIDTH . '</td>
									<td>' . _WY_UNITS . '</td>
      							</tr>
      							<tr>
        							<td>' . _WY_BORDERLEFT . '</td>
        							<td><select class="' . $skin . 'Input2" id="borderLeftStyle" onchange="' . $onchange . '">
            							' . $option . '
                						</select>
									</td>
									<td>
										<input type="text" class="' . $skin . 'Input" id="borderLeftColor" maxlength="7" onchange="' . $onchange . '">
									</td>
									<td>
										<img style="height:16px;width:10px;" alt="' . _FORECOLOR . '" id="borderLeft" title="' . _FORECOLOR . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif" onclick="XK_Color(\'borderLeft\')">
									</td>
        							<td>
										<input type="text" class="' . $skin . 'Input" id="borderLeftWidth" maxlength="4" onchange="' . $onchange . '">
      								</td>
									<td><select class="' . $skin . 'Input3" id="borderLeftUnits" onchange="' . $onchange . '">
            							' . $units . '
                						</select>
									</td>
              					</tr>
      							<tr>
        							<td>' . _WY_BORDERRIGHT . '</td>
        							<td>
										<select class="' . $skin . 'Input2" id="borderRightStyle" onchange="' . $onchange . '">
            							' . $option . '
        								</select>
									</td>
									<td>
										<input type="text" class="' . $skin . 'Input" id="borderRightColor" maxlength="7" onchange="' . $onchange . '">
        							</td>
									<td>
										<img style="height:16px;width:10px;" alt="' . _FORECOLOR . '" id="borderRight" title="' . _FORECOLOR . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif" onclick="XK_Color(\'borderRight\')">
									</td>
        							<td>
										<input type="text" class="' . $skin . 'Input" id="borderRightWidth"  maxlength="4" onchange="' . $onchange . '">
      								</td>
									<td><select class="' . $skin . 'Input3" id="borderRightUnits" onchange="' . $onchange . '">
            							' . $units . '
                						</select>
									</td>
      							</tr>
      							<tr>
        							<td>' . _WY_BORDERTOP . '</td>
        							<td>
										<select class="' . $skin . 'Input2" id="borderTopStyle" onchange="' . $onchange . '">
           								' . $option . '
         								</select>
									</td>
									<td>
										<input type="text" class="' . $skin . 'Input" id="borderTopColor" maxlength="7" onchange="' . $onchange . '">
        							</td>
									<td>	
										<img style="height:16px;width:10px;" alt="' . _FORECOLOR . '" id="borderTop" title="' . _FORECOLOR . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif" onclick="XK_Color(\'borderTop\')"></td>
        							</td>
									<td>
										<input type="text" class="' . $skin . 'Input" id="borderTopWidth" maxlength="4" onchange="' . $onchange . '">
					 				</td>
									<td><select class="' . $skin . 'Input3" id="borderTopUnits" onchange="' . $onchange . '">
            							' . $units . '
                						</select>
									</td>
      							</tr>
     							<tr>
        							<td>' . _WY_BORDERBOTTOM . '</td>
        							<td><select class="' . $skin . 'Input2" id="borderBottomStyle" onchange="' . $onchange . '">
            							' . $option . '
         								</select>
									</td>
									<td>
										<input type="text" class="' . $skin . 'Input" id="borderBottomColor" maxlength="7" onchange="' . $onchange . '">
        							</td>	
									<td>	
										<img style="height:16px;width:10px;" alt="' . _FORECOLOR . '" id="borderBottom" title="' . _FORECOLOR . '" src="' . XOOPS_URL . '/' . $url . '/skins/' . $skin . '/popup.gif" onclick="XK_Color(\'borderBottom\')">
									</td>
        							<td>
										<input type="text" class="' . $skin . 'Input" id="borderBottomWidth" onchange="' . $onchange . '">
      								</td>
									<td><select class="' . $skin . 'Input3" id="borderBottomUnits" onchange="' . $onchange . '">
            							' . $units . '
                						</select>
									</td>
      							</tr>
    					</table>
    				</fieldset>';

        return $borders;
    }

    public function display()
    {
        echo $this->_renderBorders();
    }
}

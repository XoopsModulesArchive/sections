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

class WysiwygColorPalette
{
    public $onclick;

    public $id;

    public $name;

    public $url;

    public $skin;

    public function __construct($onclick, $id, $name, $url, $skin)
    {
        $this->setonclick($onclick);

        $this->setUrl($url);

        $this->setId($id);

        $this->setSkin($skin);

        $this->setName($name);
    }

    public function getonclick()
    {
        return $this->onclick;
    }

    public function setonclick($onclick)
    {
        $this->onclick = $onclick;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
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

    public function _renderColorPalette()
    {
        $v = ['00', '33', '66', '99', 'CC', 'FF'];

        $cord1 = 0;

        $cord2 = 0;

        $cord3 = 11;

        $cord4 = 11;

        $id = $this->getId();

        $name = $this->getName();

        $function = $this->getonclick();

        $skin = $this->getSkin();

        $imgurl = $this->getUrl() . '/skins/' . $skin;

        $text = '<div id="' . $name . '' . $id . '" class="' . $skin . 'ColorPickerD" style="display:none;">';

        $text .= '<div class="' . $skin . 'colorpicker" id="colors' . $id . '' . $name . '">';

        $text .= '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td><input style="width: 48px; height: 20px; font-size: 9px;font:Verdana, Arial, Helvetica, sans-serif;border:1px solid black;" type="text" id="colortextf' . $id . '' . $name . '" size="8" maxlength="8"></td>';

        $text .= '<td><input class="' . $skin . 'colorpickerHEX" type="text" id="showc' . $id . '' . $name . '" maxlength="8"></td>';

        $text .= '<td align="right"><img alt="" src="' . $imgurl . '/none.gif" onclick="' . $function . '(\'' . $id . '\',\'' . $name . '\',\'\')"></td></tr></table>';

        $text .= '</div>';

        $text .= '<img alt="" src="' . $imgurl . '/palette.gif" style="border:0px;" usemap="#wysiwygmap' . $id . '' . $name . '">';

        $text .= '<map name="wysiwygmap' . $id . '' . $name . '" id="wysiwygmap' . $id . '' . $name . '">';

        for ($i = 0; $i < 6; $i++) {
            for ($j = 0; $j < 6; $j++) {
                for ($k = 0; $k < 6; $k++) {
                    $text .= '<area alt="" shape="rect" coords="'
                              . $cord1
                              . ','
                              . $cord2
                              . ','
                              . $cord3
                              . ','
                              . $cord4
                              . '" onclick="'
                              . $function
                              . '(\''
                              . $id
                              . '\',\''
                              . $name
                              . '\',\'#'
                              . $v[$i]
                              . ''
                              . $v[$j]
                              . ''
                              . $v[$k]
                              . '\')" onmouseover="XK_over(\''
                              . $id
                              . '\',\''
                              . $name
                              . '\',\'#'
                              . $v[$i]
                              . ''
                              . $v[$j]
                              . ''
                              . $v[$k]
                              . '\')">';

                    $cord2 += 10;

                    $cord4 += 10;
                }

                if ($cord2 > 60) {
                    $cord1 += 10;

                    $cord2 = 0;

                    $cord4 = 11;

                    $cord3 += 10;
                }
            }
        }

        $text .= '</map>';

        $text .= '</div>';

        $text .= '<input type="hidden" id="coloroption' . $id . '">';

        return $text;
    }

    public function display()
    {
        echo $this->_renderColorPalette();
    }
}

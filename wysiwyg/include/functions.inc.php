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

function getMainfile($url)
{
    $mpath = '';

    for ($i = 0, $iMax = mb_strlen($url); $i < $iMax; $i++) {
        if ('/' == $url[$i]) {
            $mpath .= '../';
        }
    }

    return $mpath . 'mainfile.php';
}

function getLanguage($url)
{
    global $xoopsConfig;

    if (file_exists(XOOPS_ROOT_PATH . '' . $url . '/language/' . $xoopsConfig['language'] . '/lang.php')) {
        return '' . XOOPS_ROOT_PATH . '' . $url . '/language/' . $xoopsConfig['language'] . '/lang.php';
    }

    return '' . XOOPS_ROOT_PATH . '' . $url . '/language/english/lang.php';
}

function checkBrowser()
{
    global $HTTP_SERVER_VARS;

    $browser = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];

    // check if msie

    if (eregi('MSIE[^;]*', $browser, $msie)) {
        // get version

        if (eregi('[0-9]+\.[0-9]+', $msie[0], $version)) {
            // check version

            if ((float)$version[0] >= 5.5) {
                // finally check if it's not opera impersonating ie

                if (!eregi('opera', $browser)) {
                    return true;
                }
            }
        }
    }

    return false;
}

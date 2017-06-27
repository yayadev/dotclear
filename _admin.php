<?php
# -- BEGIN LICENSE BLOCK ---------------------------------------
#
# This file is part of Dotclear 2.
#
# Copyright (c) 2017 Yannick Chistel - Pole WEB Académie de Caen
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK -----------------------------------------
if (!defined('DC_CONTEXT_ADMIN')) { return; }

$_menu['Blog']->addItem(

	__('Slider flickity'),
	'plugin.php?p=flickity','index.php?pf=flickity/icon.png',
	preg_match('/plugin.php\?p=flickity(&.*)?$/',$_SERVER['REQUEST_URI']),
	$core->auth->check('admin',$core->blog->id));

$core->addBehavior('adminDashboardFavs',array('flickityBehaviors','dashboardFavs'));
 
class flickityBehaviors
{
    public static function dashboardFavs($core,$favs)
    {
        $favs['flickity'] = new ArrayObject(array(
            'flickity',
            __('Slider flickity'),
            'plugin.php?p=flickity',
            'index.php?pf=flickity/icon.png',
            'index.php?pf=flickity/icon-large.png',
            'index.php?pf=flickity/icon-big.png',
            'usage,contentadmin',
            null,
            null));
    }
}
?>
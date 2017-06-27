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
if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
	/* Name */			"flickity",
	/* Description*/		"Configure a slider a with flickity script",
	/* Author */			"Yaya",
	/* Version */			'0.42',
	array(
		'permissions' =>	'admin',
		'type'		=>		'plugin'
	)
);
?>
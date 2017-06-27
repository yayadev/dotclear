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
//if (!defined('DC_CONTEXT_ADMIN')) { return; }

require dirname(__FILE__).'/lib/class.slider.Flickity.php';

if (!$core->auth->check('admin',$core->blog->id)) { return; }

# Settings
$core->blog->settings->addNamespace('flickity');
$s =& $core->blog->settings->flickity;

$p_url = 'plugin.php?p='.basename(dirname(__FILE__));

# Activation du plugin et Saving configurations
$slider_conf = $core->blog->settings->flickity->slider_conf;
$slider_conf = @unserialize($slider_conf);
if (!is_array($slider_conf)) {
	$slider_conf = array();
}

if (!empty($_POST))
{
	try
	{
		$s->put('flickity_enabled',!empty($_POST['flickity_enabled']));
		$slider_conf['post_selected'] = (!empty($_POST['post_selected'])) ? '1' : '0' ;
		$slider_conf['post_number'] = (!empty($_POST['post_number'])) ? $_POST['post_number'] : '3' ;
//		$slider_conf['btn_follow'] = (!empty($_POST['btn_follow'])) ? '1' : '0' ;
		$slider_conf['param_autoplay'] = (!empty($_POST['param_autoplay'])) ? $_POST['param_autoplay'] : '5' ;
		$slider_conf['param_infinite_scroll'] = (!empty($_POST['param_infinite_scroll'])) ? $_POST['param_infinite_scroll'] : '0' ;
		$slider_conf['param_page_dots'] = (!empty($_POST['param_page_dots'])) ? $_POST['param_page_dots'] : '0' ;
		$slider_conf['param_prev_next'] = (!empty($_POST['param_prev_next'])) ? $_POST['param_prev_next'] : '0' ;
		
		#Suppression du cache après modification du formulaire
		# Prévoir des tests pour ne pas faire de bêtises!!!!!
		//files::deltree(DC_TPL_CACHE.'/cbtpl');
		
		$core->blog->settings->flickity->put('slider_conf',serialize($slider_conf));
		$core->blog->triggerBlog();

		dcPage::addSuccessNotice(__('Flickity configuration has been successfully updated.'));
		http::redirect($p_url);
	}
	catch (Exception $e)
	{
		$core->error->add($e->getMessage());
	}
}

?>
<html>
<head>
<title><?php echo __('Slider flickity'); ?></title>
</head>
<body>
<?php

# Baseline

$page_title = __('Slider flickity');

echo dcPage::breadcrumb(
		array(
			html::escapeHTML($core->blog->name) => '',
			'<span class="page-title">'.$page_title.'</span>' => ''
		));	
echo
'<div>'.
	'<form action="'.$p_url.'" method="post">';
echo
	'<div class="fieldset"><h3>'.__('Activation').'</h3>'.
		'<p><label class="classic" for="flickity_enabled">'.
		form::checkbox('flickity_enabled','1',$s->flickity_enabled).
		__('Enable Slider Flickity on this blog').'</label></p>'.
	'</div>';
echo
	'<div class="fieldset"><h3>'.__('Configuration').'</h3>'.
		'<p><label class="classic" for="post_selected">'.
		form::checkbox('post_selected','1',$slider_conf['post_selected']).
		__('Only post selected on this blog.').'</label></p>'.
		'<p><label class="classic" for="post_number">'.__('Number of post for the slider : ').'</label>'.
	 	form::field('post_number',4,20,$slider_conf['post_number']).'</p>'.
//	 	'<p><label class="classic" for="btn_follow">'.
//		form::checkbox('btn_follow','1',$slider_conf['btn_follow']).
//		__('Button follow active on this blog').'</label></p>'.
	'</div>';
echo
	'<div class="fieldset"><h3>'.__('Reading parameters').'</h3>'.
		'<p><label class="classic" for="param_autoplay">'.__('Time allowed for reading slide : ').'</label>'.
	 	form::field('param_autoplay',4,20,$slider_conf['param_autoplay']).'</p>'.
	 	'<p><label class="classic" for="param_infinite_scroll">'.
		form::checkbox('param_infinite_scroll','1',$slider_conf['param_infinite_scroll']).
		__('Infinite scrolling').'</label></p>'.
		'<p><label class="classic" for="param_page_dots">'.
		form::checkbox('param_page_dots','1',$slider_conf['param_page_dots']).
		__('Dots for slide').'</label></p>'.
		'<p><label class="classic" for="param_prev_next">'.
		form::checkbox('param_prev_next','1',$slider_conf['param_prev_next']).
		__('Previous et next buttons').'</label></p>'.
	'</div>';
	
echo
	'<p class="clear"><input type="submit" name="save" value="'.__('Save configuration').'" />'.$core->formNonce().'</p>'.
'</form>'.
'</div>';
?>
</body>
</html>
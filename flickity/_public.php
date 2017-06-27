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

# Si le plugin n'est pas activé on sort, rien ne sera fait.

$s =& $core->blog->settings->flickity;
if (!$s->flickity_enabled) { return; }
		
# On déclare le template "slider.html" du plugin. 
$core->tpl->setPath($core->tpl->getPath(), dirname(__FILE__).'/default-templates');
$core->tpl->addBlock('Slider',array('SliderTpl','Slider'));
//$core->tpl->addBlock('SliderIf',array('SliderTpl','SliderIf'));
$core->addBehavior('publicHeadContent',array('sliderFlickity','publicHeadContent'));
$core->addBehavior('templateBeforeBlock',array('sliderFlickity','templateBeforeBlock'));

class SliderTpl
{
	
	public function Slider($attr,$content)
	{	
		$res = "<?php\n";
		$res .= '$_ctx->post_params = $params;'."\n";
		$res .= '$_ctx->posts = $core->blog->getPosts($params); unset($params);'."\n";
		$res .= "?>\n";
		$res .= '<?php while ($_ctx->posts->fetch()) : ?>'.$content.'<?php endwhile; '.
		'$_ctx->posts = null; $_ctx->post_params = null; $selected = null ?>';
		
		return $res;
	}
}

class sliderFlickity
{
	public static function publicSliderContent($core)
	{
		$core->tpl->setPath($core->tpl->getPath(), dirname(__FILE__).'/default-templates');
	}
	
	public static function publicHeadContent($core)
	{
		# Settings
		//global $core;
		$s =& $core->blog->settings->flickity;
		
		if (!$s->flickity_enabled) { return; }
		
		$slider_conf = $s->slider_conf;
		$slider_conf = @unserialize($slider_conf);
		$autoplay = $slider_conf['param_autoplay']*1000;
		$wraparround = (boolean) (!empty($slider_conf['param_infinite_scroll'])) ? 1 : 0 ;
		$pagedots = (boolean) (!empty($slider_conf['param_page_dots'])) ? 1 : 0 ;
		$prevnext = (boolean) (!empty($slider_conf['param_prev_next'])) ? 1 : 0 ;
		
		echo 
		dcUtils::cssLoad($core->blog->getPF('flickity/css/style.css')).
		dcUtils::cssLoad($core->blog->getPF('flickity/css/flickity.css')).
    	dcUtils::jsVar('dotclear_flickity_play',$autoplay).
    	dcUtils::jsVar('dotclear_wrap_arround',$wraparround).
		dcUtils::jsVar('dotclear_page_dots',$pagedots).
		dcUtils::jsVar('dotclear_prev_next',$prevnext).
		dcUtils::jsLoad($core->blog->getPF('flickity/js/slider.js'),$core->getVersion('flickity')).
		dcUtils::jsLoad($core->blog->getPF('flickity/js/flickity.pkgd.min.js'));
	}
	
	public static function templateBeforeBlock($core,$b,$attr)
	{
		$s =& $core->blog->settings->flickity;
		
		if (!$s->flickity_enabled) { return; }
		
		if ($b == 'Slider')
		{
			return
			"<?php\n".
			"global \$core;\n".  
			"\$slider_conf = \$core->blog->settings->slider_conf;\n".
			"\$slider_conf = @unserialize(\$slider_conf);\n".
			"\$lastn = (!empty(\$slider_conf['post_number'])) ? (integer) \$slider_conf['post_number'] : \$attr['lastn'] ;\n".
			"\$selected = (!empty(\$slider_conf['post_selected'])) ? (integer) \$slider_conf['post_selected'] : \$attr['selected'] ;\n".
			"if (!isset(\$params)) { \$params = array(); }\n".
			"if (!isset(\$params['limit'])) { \$params['limit'] = array(0,\$lastn); }\n".
			"if (!isset(\$params['post_selected'])) { \$params['post_selected'] = \$selected ; }\n".
			"?>\n";
		}
	}

}
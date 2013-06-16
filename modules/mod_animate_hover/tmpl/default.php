<?php
/**
* Module mod_animate_hover For Joomla 1.6.x
* Version		: 3.1
* Created by	: Daniel Pardons
* Email			: daniel.pardons@joompad.be
* Created on	: 28 March 2011
* Last Modified : 18 May 2011
* URL			: www.joompad.be
* Copyright (C) 2011 Daniel Pardons
* License GPLv2.0 - http://www.gnu.org/licenses/gpl-2.0.html
* Based on Animate a hover with jQuery Timothy van Sas tutorial (http://www.incg.nl/blog/2008/hover-block-jquery/
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.

* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$module_id		= $params->get( 'module_id' );
$gallery_position = $params->get( 'gallery_position' );
$gallery_left_margin = (int)$params->get( 'gallery_left_margin' );
$gallery_top_margin = (int)$params->get( 'gallery_top_margin' );
$gallery_bottom_margin = (int)$params->get( 'gallery_bottom_margin' );
$gallery_width	= (int)$params->get( 'gallery_width' );
$gallery_rows = (int)$params->get( 'gallery_rows' );
$images_in_row = (int)$params->get( 'images_in_row' );
$gallery_row_effect = $params->get( 'gallery_row_effect' );
$effect_duration =  $params->get( 'effect_duration' );
$gallery_bgcolor= $params->get( 'gallery_bgcolor' );
$gallery_images_use = $params->get( 'gallery_images_use' );
$image_width	= (int)$params->get( 'image_width' );
$image_height	= (int)$params->get( 'image_height' );
$image_margin	= (int)$params->get( 'image_margin' );
$overlay_top_offset = (int)$params->get( 'overlay_top_offset' );

$image_color_target = $params->get( 'image_color_target' );
$teaser_bgcolor = $params->get( 'teaser_bgcolor' );
$title_color	= $params->get( 'title_color' );
$title_center	= $params->get( 'title_center','0' );
$title_css		= $params->get( 'title_css' );
$title_seperator = $params->get( 'title_seperator', '1');
$teaser_padding = $params->get( 'teaser_padding' );
$teaser_color	= $params->get( 'teaser_color' );
$teaser_center	= $params->get( 'teaser_center','0' );
$teaser_css		= $params->get( 'teaser_css' );
$a_css			= $params->get( 'a_css' );

$title_seperator = ($title_seperator) ? '<br />' : '';
$center			= ' display: block; text-align: center;';
if ($title_center) {
	$title_css = $title_css.$center;
}
if ($teaser_center) {
	$teaser_css = $teaser_css.$center;
}

$external_url	= $params->get( 'external_url' );
$folder			= $params->get( 'folder' );
if (empty($external_url)) {
	$folder 	= JURI::base().$folder;
} else {
	$folder	= $external_url;
}

//$gallery_width =  ($images_in_row * $image_width) + (($images_in_row + 1) * $image_margin);
$image_item_width = $image_width + $image_margin;
$teaser_height = $image_height - 2*$teaser_padding;
$teaser_width = $image_width - 2*$teaser_padding;

$image_ref = array();
$image_img = array();
$image_bg_color = array();
$image_title_color = array();
$image_teaser_color = array();
$image_alt = array();
$image_url = array();
$image_title = array();
$image_teaser = array();
$target_url = array();

$max_images = 20;

for ($i = 1; $i <= $max_images; $i++) {
	if ($params->get( 'image_img'.$i )) {
		$image_ref[]	= $i;
		$image_img[$i] 	= $folder.trim($params->get( 'image_img'.$i ));
		$image_alt[$i] 	= $params->get( 'image_alt'.$i );
		switch ($image_color_target) {
			case 3: 
				$image_bg_color[$i] = $teaser_bgcolor;				
				$image_title_color[$i] = ($params->get( 'image_teaser_bgcolor'.$i )) ? $params->get( 'image_teaser_bgcolor'.$i ) : $title_color;
				$image_teaser_color[$i] = ($params->get( 'image_teaser_bgcolor'.$i )) ? $params->get( 'image_teaser_bgcolor'.$i ) : $teaser_color;
				break;
			case 2: 
				$image_bg_color[$i] = $teaser_bgcolor;				
				$image_title_color[$i] = $title_color;
				$image_teaser_color[$i] = ($params->get( 'image_teaser_bgcolor'.$i )) ? $params->get( 'image_teaser_bgcolor'.$i ) : $teaser_color;
				break;
			case 1: 
				$image_bg_color[$i] = $teaser_bgcolor;				
				$image_title_color[$i] = ($params->get( 'image_teaser_bgcolor'.$i )) ? $params->get( 'image_teaser_bgcolor'.$i ) : $title_color;
				$image_teaser_color[$i] = $teaser_color;
				break;
			case 0:
			default:
				$image_bg_color[$i] = ($params->get( 'image_teaser_bgcolor'.$i )) ? $params->get( 'image_teaser_bgcolor'.$i ) : $teaser_bgcolor;				
				$image_title_color[$i] = $title_color;
				$image_teaser_color[$i] = $teaser_color;
		}

		$image_title[$i] 	= $params->get( 'image_title'.$i );
		$image_teaser[$i] 	= ($params->get( 'teaser_nl2br' )) ? nl2br($params->get( 'image_teaser'.$i )) : $params->get( 'image_teaser'.$i );
		$image_url[$i] 	= str_replace('&', '&amp;', $params->get( 'image_url'.$i ));
		$target_url[$i] 	= $params->get( 'target_url'.$i );
	}
}
$image_cnt = count ($image_ref);
if ($gallery_images_use ) {
	shuffle ($image_ref);
}

$document = JFactory::getDocument();
if ($params->get('load_JQuery')==1)  {
	$document->addScript(JURI::base() . 'modules/mod_animate_hover/js/jquery-1.4.2.min.js');
}

$ahcs =	'';
if ($gallery_position==1) {
	$ahcs .= '
	#ahgallery'.$module_id.' {
		margin-left: auto;
		margin-right: auto;
		margin-top: '.$gallery_top_margin.'px !important;
		margin-bottom: '.$gallery_bottom_margin.'px !important;
		width: '.$gallery_width.'px;
	}';
} else {
	$ahcs .= '
	#ahgallery'.$module_id.' {
		margin-left: '.$gallery_left_margin.'px;
		margin-top: '.$gallery_top_margin.'px !important;
		margin-bottom: '.$gallery_bottom_margin.'px !important;
		width: '.$gallery_width.'px;
	}';
}
$ahcs .= '
	#ahgallery'.$module_id.' ul.hover_block0, #ahgallery'.$module_id.' ul.hover_block1, #ahgallery'.$module_id.' ul.hover_block2 {
		display: block;
		overflow: hidden;
		height: 1%;
		padding-top: '.$image_margin.'px;
		padding-left: '.$image_margin.'px;
		background: '.$gallery_bgcolor.';
		margin-left: '.$gallery_left_margin.'px;
		margin-top: 0 !important;
		margin-bottom: 0 !important;
	}';
$ahcs .= '
	#ahgallery'.$module_id.' ul.bottom_block {
		padding-bottom: '.$image_margin.'px ;
	}';
$ahcs .= '
	#ahgallery'.$module_id.' ul.hover_block0 li.ahitem, #ahgallery'.$module_id.' ul.hover_block1 li.ahitem, #ahgallery'.$module_id.' ul.hover_block2 li.ahitem {
		margin-left: 0;
		padding-left: 0;
		list-style:none;
		list-style-position: inside;
		float:left;
		background: '.$gallery_bgcolor.';
		width: '.$image_item_width.'px;
		position: relative;
	}';
$ahcs .= '
	#ahgallery'.$module_id.' ul.hover_block0 li a.teaser, #ahgallery'.$module_id.' ul.hover_block1 li a.teaser , #ahgallery'.$module_id.' ul.hover_block2 li a.teaser{
		display: block;
		position: relative;
		overflow: hidden;
		height: '.$teaser_height.'px;
		width: '.$teaser_width.'px;
		padding: '.$teaser_padding.'px;
	}';

$ahcs .= '
	#ahgallery'.$module_id.' ul.hover_block0 li div.teaser, #ahgallery'.$module_id.' ul.hover_block1 li div.teaser , #ahgallery'.$module_id.' ul.hover_block2 li div.teaser {
		display: block;
		position: relative;
		overflow: hidden;
		height: '.$teaser_height.'px;
		width: '.$teaser_width.'px;
		padding: '.$teaser_padding.'px;
	}';

$ahcs .= '
	#ahgallery'.$module_id.' ul.hover_block0 li img.overlay, #ahgallery'.$module_id.' ul.hover_block1 li img.overlay, #ahgallery'.$module_id.' ul.hover_block2 li img.overlay {
		margin: 0;
		position: absolute;
		top: '.$overlay_top_offset.'px;
		left: 0;
		border: 0;
	}
	';

$document->addStyleDeclaration($ahcs);

switch ($gallery_row_effect) {
	case 1: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block1 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({left:'<?php echo $image_width; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function(){
				$(this).find('img.overlay').animate({left:'0px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
		});
		</script>
		<?php break;

	case 2: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block2 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({top:'<?php echo $image_height; ?>px', left:'<?php echo $image_width; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function() {
				$(this).find('img.overlay').animate({top:'<?php echo $overlay_top_offset; ?>px', left:'0px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
		});
		</script>
		<?php break;

	case 3: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block0 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({top:'<?php echo $image_height; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function(){
				$(this).find('img.overlay').animate({top:'<?php echo $overlay_top_offset; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block1 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({left:'<?php echo $image_width; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function(){
				$(this).find('img.overlay').animate({left:'0px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
		});
		</script>
		<?php break;

	case 4: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block0 li.ahitem').hover(function(){
				$(this).find('img.overlay').stop().animate({opacity: '0'}, <?php echo $effect_duration; ?>);
			}, 
			function(){
				$(this).find('img.overlay').stop().animate({opacity: '1'}, <?php echo $effect_duration; ?>);
			});
		});
		</script>
		<?php break;

	case 5: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block0 li.ahitem').hover(function(){
				$(this).find('img.overlay')
					.stop()
					.animate({opacity: '0'}, <?php echo $effect_duration; ?>)
					.hide();
			}, 
			function(){
				$(this).find('img.overlay')
					.stop()
					.show()
					.animate({opacity: '1'}, <?php echo $effect_duration; ?>);
			});
		});
		</script>
		<?php break;

	case 6: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block1 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({left:'-<?php echo $image_width; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function(){
				$(this).find('img.overlay').animate({left:'0px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
		});
		</script>
		<?php break;

	case 7: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block2 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({top:'<?php echo $image_height; ?>px', left:'-<?php echo $image_width; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function() {
				$(this).find('img.overlay').animate({top:'<?php echo $overlay_top_offset; ?>px', left:'0px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
		});
		</script>
		<?php break;

	case 8: ?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
		{
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block0 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({top:'<?php echo $image_height; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function(){
				$(this).find('img.overlay').animate({top:'<?php echo $overlay_top_offset; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
			$('#ahgallery<?php echo $module_id; ?> ul.hover_block1 li.ahitem').hover(function(){
				$(this).find('img.overlay').animate({left:'-<?php echo $image_width; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			}, function(){
				$(this).find('img.overlay').animate({left:'0px'},{queue:false,duration:<?php echo $effect_duration; ?>});
			});
		});
		</script>
		<?php break;

	case 0:
	default:
		?>
		<script type="text/javascript">
        jQuery.noConflict();
		jQuery(document).ready(function($)
			{
				$('#ahgallery<?php echo $module_id; ?> ul.hover_block0 li.ahitem').hover(function(){
					$(this).find('img.overlay').animate({top:'<?php echo $image_height; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
				}, function(){
					$(this).find('img.overlay').animate({top:'<?php echo $overlay_top_offset; ?>px'},{queue:false,duration:<?php echo $effect_duration; ?>});
				});
		});
		</script>
<?php } ?>

<div id="ahgallery<?php echo $module_id; ?>">
<?php 
$imagenr = 0;
$kr = 0 ;
for ($r = 1; $r <= $gallery_rows; $r++) {;
	switch ($gallery_row_effect) {
	case 1: 
	case 6: 
		$row_class = '1';		
		break;	
	case 2: 
	case 7: 
		$row_class = '2';		
		break;	
	case 3: 
	case 8:
		$row_class = $kr;
		break;	
	case 4: 
	case 5: 
	case 0: 		
		$row_class = '0';
	}

	if ($r != $gallery_rows) { ;?>
		<ul class="hover_block<?php echo $row_class; ?>">
	<?php } else { ;?>
		<ul class="hover_block<?php echo $row_class; ?> bottom_block">
	<?php } ;?>
		<?php for ($ir= 1; $ir <= $images_in_row; $ir++) {
			$cur_img = $image_ref[$imagenr] ;?>
			<?php if ($imagenr < $image_cnt) { ?>
			  <!--galleryEntry <?php echo $imagenr+1; ?> -->
				<li class="ahitem">
					<?php if ($image_url[$cur_img]) { ?>
						<a class="teaser" style="background-color:<?php echo $image_bg_color[$cur_img]; ?> !important;  <?php echo $a_css; ?>" href="<?php echo $image_url[$cur_img]; ?>" target="<?php echo $target_url[$cur_img]; ?>">
						  <img class="overlay" src="<?php echo $image_img[$cur_img]; ?>" alt="<?php echo $image_alt[$cur_img]; ?>" />
							<span style="color:<?php echo $image_title_color[$cur_img]; ?>; <?php echo $title_css; ?>"><?php echo $image_title[$cur_img]; ?></span>
							<?php echo $title_seperator; ?>
							<span style="color:<?php echo $image_teaser_color[$cur_img]; ?>; <?php echo $teaser_css; ?>"><?php echo $image_teaser[$cur_img]; ?></span>
						</a>
					<?php } else { ?>
						<div class="teaser" style="background-color:<?php echo $image_bg_color[$cur_img]; ?> !important;">
						<img class="overlay" src="<?php echo $image_img[$cur_img]; ?>" alt="<?php echo $image_alt[$cur_img]; ?>" />
							<span style="color:<?php echo $image_title_color[$cur_img]; ?>; <?php echo $title_css; ?>"><?php echo $image_title[$cur_img]; ?></span>
							<?php echo $title_seperator; ?>
							<span style="color:<?php echo $image_teaser_color[$cur_img]; ?>; <?php echo $teaser_css; ?>"><?php echo $image_teaser[$cur_img]; ?></span>
						</div>
					<?php } ?>
				</li>
			<?php }
			$imagenr++;
		} ?>
	</ul>
	<?php $kr = 1-$kr ; 
}; ?>

</div> 
<div class="clr"></div>


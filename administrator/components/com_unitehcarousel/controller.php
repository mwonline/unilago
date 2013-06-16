<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;


class UniteHCarouselController extends JController
{
	protected $default_view = GlobalsUniteHCar::VIEW_SLIDERS;
	protected $default_layout = GlobalsUniteHCar::LAYOUT_SLIDER_GENERAL;
	
	/**
	 * show some image
	 */
	public function showimage(){
		UniteFunctionJoomlaHCar::showImageFromRequest();
		exit();
	}
	
	
	/**
	 *
	 * display some view
	 */
	public function display($cachable = false, $urlparams = false){
				
		$urlAssets = GlobalsUniteHCar::$urlAssets;
		
		//add style
		$document = JFactory::getDocument();
		$document->addStyleSheet($urlAssets."style.css");
		
		//add jquery
		//$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js");
		
		//add jquery ui
		//$document->addScript("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js");
		$document->addStyleSheet($urlAssets."jui/jquery-ui-1.8.19.custom.css");

		//add custom scripts
		$document->addScript($urlAssets."jquery.min.js");
		$document->addScript($urlAssets."jquery-ui.min.js");
		$document->addScript($urlAssets."admin.js");
		$document->addScript($urlAssets."hcarousel.js");
		
		//$document->addScript($urlAssets."jsfunc.js");
		
		//add ajax url:
		$currentView = JRequest::getCmd('view', $this->default_view);
		$ajaxUrl = UniteFunctionJoomlaHCar::getViewUrl($currentView, "ajax");
		$document->addScriptDeclaration("var g_urlAjax='$ajaxUrl';");
		
		/*
			$currentView = JRequest::getCmd('view', $this->default_view);
			$currentLayout = JRequest::getCmd('layout', $this->default_layout);		
			HelperUniteHCar::addSubmenu($currentView,$currentLayout);
		*/
		
		parent::display();

		return $this;
	}
	
}
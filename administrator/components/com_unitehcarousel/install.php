<?php 
// No direct access.
defined('_JEXEC') or die;

class com_unitehcarouselInstallerScript
{
	
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	public function __constructor(JAdapterInstance $adapter){
		
	}
 
	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($route, JAdapterInstance $adapter){
		
	}
 
	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($route, JAdapterInstance $adapter){
		
	}
 	
	/**
	 * 
	 * install the modules from "modules" folder
	 */
	public function installModules(JAdapterInstance &$adapter,$type="install"){
		
		$manifest = $adapter->get("manifest");
		
		$installer = new JInstaller();
		$p_installer = $adapter->getParent();
		
		// Install modules
		if (is_object($manifest->modules->module)){	
			foreach($manifest->modules->module as $module){
				$attributes = $module->attributes();
				$modulePath = $p_installer->getPath("source") . DS . $attributes['folder'] . DS . $attributes['module'];
				
				if($type == "install")
					$installer->install($modulePath);
				else 
					$installer->update($modulePath);
			}
		}
		
	}
	
	
	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install(JAdapterInstance $adapter){
		
		$this->installModules($adapter,"install");
	}
 
	
	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update(JAdapterInstance $adapter){
		
		$this->installModules($adapter,"update");
	}

	
	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	public function uninstall(JAdapterInstance $adapter){
		
	}
}

?>
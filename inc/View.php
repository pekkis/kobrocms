<?php
/**
 * Da view klass be using dem magic methods to set and get dem variables.
 * 
 * @author Devadutt Chattopadhyay
 * @author Rajanigandha Balasubramanium
 * @author Lalitchandra Pakalomattam
 * 
 */
class View
{
	
	/**
	 * @var array View be used with magic methods but data actually here
	 */
	private $_vars = array();
	
	public $kobros;
	
	public function __construct()
	{
		$this->kobros = KobroCms::getInstance();
	}
	
	
	
	public function __set($key, $value)
	{
		$this->_vars[$key] = $value;
	}
	
	
	public function __get($key)
	{
		return (isset($this->_vars[$key])) ? $this->_vars[$key] : null; 
	}
	
	
	/**
	 * Da view script be rendered in dem view's scope.
	 * 
	 * @param $tpl Da view script
	 * @return string Da view renderings be returning htmls.
	 */
	public function render($tpl)
	{
		ob_start();
		include $tpl;
		$ret = ob_get_clean();
		
		return $ret;
	}
	
	
	/**
	 * Da views module helper be merging get params wid dem supplied params and calling dem modules.
	 *
	 * @param $params
	 * @return unknown_type
	 */
	public function module($params)
	{
		$params = array_merge($_REQUEST, $params);
		return $this->kobros->executeModule($params);
	}
	
	
	
}
?>
<?php
/**
 * This be the abstract module class.
 * 
 * @author Devadutt Chattopadhyay
 * @author Rajanigandha Balasubramanium
 * @author Lalitchandra Pakalomattam
 *   
 */
abstract class Module
{
	
	/**
	 * Kobros reference
	 * 
	 * @var KobroCms
	 */
	public $kobros;
	
	public function __construct()
	{
		// Modules always be having da kobros object as references.
		$this->kobros = KobroCms::getInstance();	
	}
	
	
	
	
	/**
	 * This be executing da module with dem suplied parameters.
	 * 
	 * @param $params
	 * @return unknown_type
	 */
	public function execute($params = array())
	{
		// No page, use current by default.
		if(!isset($params['page'])) {
			$params['page'] = $this->kobros->page->id;
		}
		
		// When no action be defined, we use default.
		if(!isset($params['action'])) {
			$params['action'] = 'default';
		}		

		// delegate execution to execute module
		$action = '_' . $params['action'];
		return $this->$action($params);
				
		
	}	
	
	
	
	
	
	
}

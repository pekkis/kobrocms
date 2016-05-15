<?php
/**
 * Search module be searching dem HTML modules contents from all de pages!
 * 
 * @author Lalitchandra Pakalomattam
 *
 */
class Module_Search extends Module
{

	protected function _quicksearch($params)
	{
		
		
		$page = $params['page'];
				
		$view = new View();
		$view->page = $page;
				
		return $view->render(ROOT . '/templates/data/search/quicksearch.phtml');
				
	}	
	
	
	protected function _search($params)
	{
		
		
		$view = new View();
		$view->page = $this->kobros->page;

		// If we has seartch string we poop it to template!
		$view->s = (isset($params['s'])) ? $params['s'] : '';
		
		return $view->render(ROOT . '/templates/data/search/search.phtml');
		
	}
	
	
	
	
}

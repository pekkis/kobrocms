<?php
/**
 * Custom Kobros Employment Module (btw why dem need to employ when them already having us three!)
 * 
 * @author Lalitchandra Pakalomattam
 *
 */
class Module_Employ extends Module
{

	protected function _default($params)
	{
		$view = new View();
		$view->page = $this->kobros->page;
		$view->error = false;
		return $view->render(ROOT . '/templates/data/employ/default.phtml');
	}	
	
	
	
	protected function _send($params)
	{
		if(!isset($_FILES) || !$_FILES['cv']) {
			$error = true;
		} else {
			$cv = $_FILES['cv'];
			
			if($cv['type'] != 'application/pdf') {
				// Sent cv Not a PDF file, abort!
				$error = true;
			}
			
		}
		
		if($error) {
			// We has error, render default wid error!
			$view = new View();
			$view->error = true;
			$view->page = $this->kobros->page;
			return $view->render(ROOT . '/templates/data/employ/default.phtml');
		} else {

			// It must be uploaded file to move'n groove. We be moving the uploaded file outside root for security of course stupid! 
			move_uploaded_file($cv['tmp_name'], $this->kobros->config['safe_data'] . '/uploaded/' . $cv['name']);
						
			// Redirect to thanks so user can-not refresh dem sendings!
			header("Location: /?page={$this->kobros->page->id}&action=thanks");			
		}
		
		
	}
	
	
	protected function _thanks($params)
	{
		$view = new View();
		return $view->render(ROOT . '/templates/data/employ/thanks.phtml');
	}
	
	
	
}

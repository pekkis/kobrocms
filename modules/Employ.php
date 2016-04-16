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

		if(!isset($_FILES) || !$_FILES['cv']) 
                {
			$error = true;
		}
                
                
                else 
                {
                    $cv = $_FILES['cv'];
                    // Tsekataan että file oikeasti on sitä mitä halutaan.
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    if(finfo_file($finfo, $cv['tmp_name']) != 'application/pdf')
                    {
                        $error = true;
                    }
                    finfo_close($finfo);
		}
                
		if($error) {
			// We has error, render default wid error!
			$view = new View();
			$view->error = true;
			$view->page = $this->kobros->page;
			return $view->render(ROOT . '/templates/data/employ/default.phtml');
		} else {

			// It must be uploaded file to move'n groove. We be moving the uploaded file outside root for security of course stupid! 
                        $filename = "userSubmittedPDF".date('d-m-Y')."_".date('H-i-s')."_".rand(1,1000).".pdf";
			move_uploaded_file($cv['tmp_name'], ROOT.'/Data/uploaded/' . $filename);
						
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

<?php
/**
 * CHANGELOKI:
 * - config.ini'n siirto web-scopen ulkopuolelle asetettu toimivalla tavalla parametreihin jotka sitä lukevat. 
 * - $tpl filtteri paranneltu, ei pysty enään injektaamaan ....// tms.
 * - $tpl errorviesti ei anna PHP tietoja enään. Palauttaa ylimmän (index.php'n) Exceptionin (eli "virhesivun").
 * 
 * This be the main KobroCRM klass.
 * 
 * @author Devadutt Chattopadhyay
 * @author Rajanigandha Balasubramanium
 * @author Lalitchandra Pakalomattam
 *   
 */
class KobroCms
{
	/**
	 * Config ini be parsed to array here.
	 * 
	 * @var array
	 */
	public $config;
	
	/**
	 * This be PDO reference
	 * 
	 * @var PDO 
	 */
	public $db;
	
	/**
	 * Page
	 * 
	 * @var stdClass
	 */
	public $page;
	
	/**
	 * View
	 * 
	 * @var View
	 */
	public $view;
		
	
	/**
	 * User
	 * 
	 * @var User
	 */
	public $user;
	
	private function __construct()
	{
		// We parse customers config.
		$this->config = $config = parse_ini_file(ROOT . "/../config.ini");
				
		// We connect to database
		$this->db = new PDO("mysql:host={$this->config['db_host']};dbname={$this->config['db_schema']}", $this->config['db_user'], $this->config['db_password']);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	
	
	/**
	 * Return instance of CMS
	 * 
	 * @return KobroCms
	 */
	public static function getInstance()
	{
		static $instance;
		if(!$instance) {
			$instance = new KobroCms();
		}
		
		return $instance;
	}
		
	
	/**
	 * Returns page
	 * 
	 * @param $pageId Page id
	 * @return stdClass
	 */
	public function getPage($pageId)
	{
		// We be casting dem page id to integer so the parameter always valid.
		$pageId = (int) $pageId;
		
		$sql = "SELECT * FROM page WHERE id = {$pageId}";
		return $this->db->query($sql)->fetch(PDO::FETCH_OBJ);
	}
	
	
	/**
	 * Executing a module command
	 * 
	 * @param $params array
	 * @return string Module return html always
	 */
	public function executeModule($params)
	{
		// Autoload module from modules directory intelligently.
		$module = 'Module_' . $params['module'];
		require_once ROOT . '/modules/' . $params['module'] . '.php';
		$module = new $module();
		
		// Delegating executable
		return $module->execute($params);
		
	}
	
	
	
	/**
	 * Main runner kobros
	 * 
	 * @return string Html response to give user
	 */
	public function run()
	{
		// Init user
		$this->user = User::getInstance();

		// Init view
		$this->view = new View();
		
		// Fetch page. If no page use start page.
		$pageId = (isset($_GET['page'])) ? $_GET['page'] : $this->config['page_default']; 
		$this->page = $page = $this->getPage($pageId);
		
		// If invalid page we throw exception
		if(!$this->page) {
			throw new Exception('Page not found');
		}
		
		// Render inner-template
		$this->view->innertpl = $this->view->render(ROOT . '/templates/inner/' . $page->innertpl . '.phtml');
		
		// If user request template we use it
		$tpl = (isset($_REQUEST['tpl'])) ? $_REQUEST['tpl'] : $page->tpl; 
		
		// HTML TITLE is always page titel.
		$this->view->title = $this->page->title;
		
		// If admin role we include the admin scripts.
		if($this->user->obj->role == 'admin') {
			$this->view->includeAdminScripts = true;
		} else {
			// No go.
			$this->view->includeAdminScripts = false;
		}
		
		// User can not go outside webroot so we fix the tpl param not to has goto up directory
                //FIXED >:) EI-TAHRO-REGEXIÄ - purkkaviritykset4ever \o/
		$tpl = str_ireplace('.', '', $tpl);
                $tpl = str_ireplace('/', '', $tpl);
                $tpl = str_ireplace('\\', '', $tpl);
                //HIHIH ^,^ lisähämmennystä rikkojille... ei taida suorituskykyä kuiteskaan lannistaa.
                //Regexillä ei vissiin aasialaiset tiedostonimet toimisi... :[
                //Ellei siellä jtn "unicode #..sta #..een" funktiota. :x
                $tpl = str_ireplace(';', '', $tpl);
                $tpl = str_ireplace(',', '', $tpl);
                $tpl = str_ireplace('&', '', $tpl);
                $tpl = str_ireplace('#', '', $tpl);
                $tpl = str_ireplace('@', '', $tpl);
                $tpl = str_ireplace('!', '', $tpl);
                $tpl = str_ireplace('"', '', $tpl);
		
		//We render outer template, inject inner teplate to it
                if(is_readable(ROOT . '/templates/outer/' . $tpl . '.phtml')) {
                   		return $this->view->render(ROOT . '/templates/outer/' . $tpl . '.phtml'); 
                                }
                //else, jos ei returnannut jo pois. :#
                throw new Exception("Template not found.");
				
		// All (is good.) your forms are belong to Dr.Kobro.
		
	}

	
	
	
	
	
	
	
	
	
	
	
}
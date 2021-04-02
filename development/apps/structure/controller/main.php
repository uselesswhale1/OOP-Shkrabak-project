<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;
class Main
{
	use \Library\Shared;

	private $model;

	public function exec():?array {

	include 'model/config/patterns.php'; //подключили файл с паттернами 
		$result = null;
		$url = $this->getVar('REQUEST_URI', 'e');
		$path = explode('/', $url);

		if (isset($path[2]) && !strpos($path[1], '.')) { // Disallow directory changing
			$file = ROOT . 'model/config/methods/' . $path[1] . '.php';
			if (file_exists($file)) {
				include $file;
				if (isset($methods[$path[2]])) {
					$details = $methods[$path[2]];
					$request = [];
					foreach ($details['params'] as $param) {
						$var = $this->getVar($param['name'], $param['source']);
					
						if ($var){
							if(isset($param['pattern'])) { //Проверка на сущ паттерна
								if(preg_match( $patterns[$param['pattern']]['regex'], $var) ) {
									if( isset($patterns[$param['pattern']]['callback']))
										$var = preg_replace_callback($patterns[$param['pattern']]['regex'], $patterns[$param['pattern']]['callback'], $var);
									$request[$param['name']] = $var;
								}
								else 
									throw new \Exception('REQUEST_INCORRECT'); //не соответсв паттерну, выбрс. исключ. "неверный запрос" 

							}
							else
								$request[$param['name']] = $var;
						}
						else if(!$param['required']){ //Проверка на обязательн параметр
							if(isset($param['default'])) // проверк на существ дефолтн значения у параметра
								$request[$param['name']] = $param['default']; //присвоение значения параметру если он необяз и для него сущ деф знач
							else
								throw new \Exception('INTERNAL_ERROR'); //
						}
						else {
							throw new \Exception('REQUEST_INCOMPLETE'); // Если парам обязательный, то запрос неполный
						


						}




						



					}
					if (method_exists($this->model, $path[1] . $path[2])) {
						$method = [$this->model, $path[1] . $path[2]];
						$result = $method($request);
					}

				}

			}
		}

		return $result;
	}

	public function __construct() {
		// CORS configuration
		$origin = $this -> getVar('HTTP_ORIGIN', 'e');
		$front = $this -> getVar('FRONT', 'e');
		
		foreach ( [$front] as $allowed )
			if ( $origin == "https://$allowed") {
				header( "Access-Control-Allow-Origin: $origin" );
				header( 'Access-Control-Allow-Credentials: true' );
			}
		$this->model = new \Model\Main;
	}
}
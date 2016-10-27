<?php
/**
 * ErrorHandler
 *
 * @category    Erdiko
 * @package     Core
 * @copyright   Copyright (c) 2016, Arroyo Labs, http://www.arroyolabs.com
 * @author      Leo Daidone, leo@arroyolabs.com
 */

namespace erdiko\core;

use ToroHook;

class ErrorHandler {

	/**
	 *
	 */
	public static function init()
	{
		ini_set('html_errors',0);
		error_reporting((E_ALL | E_STRICT));
		if (version_compare(phpversion(), '5.2.3', '<')) {
			set_error_handler(array("\\erdiko\\core\\ErrorHandler","errorHandler"));
			register_shutdown_function(array("\\erdiko\\core\\ErrorHandler",'fatalErrorShutdownHandler'));
		} else {
			set_error_handler("\\erdiko\\core\\ErrorHandler::errorHandler");
			register_shutdown_function("\\erdiko\\core\\ErrorHandler::fatalErrorShutdownHandler");
		}
	}

	/**
	 * @param $errno
	 * @param $errstr
	 * @param $errfile
	 * @param $errline
	 *
	 * @return bool|null
	 */
	public static function errorHandler($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno) || empty($errstr)) {
			return null;
		}
		$msg = array("type"=>"", "code"=>$errno, "description"=>$errstr, "path_info"=>"$errfile (line:$errline)");
		switch ($errno) {
			case E_USER_ERROR:
				$msg['type'] = "USER ERROR";
				$msg['description'] = "  Fatal error in line $errline of $errfile file";
				$msg['description'] .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")";
				break;

			case E_USER_WARNING:
				$msg['type'] = "USER WARNING";
				break;

			case E_USER_NOTICE:
				$msg['type'] = "USER NOTICE";
				break;

			case E_ERROR:
				$msg['type'] = "ERROR";
				break;

			default:
				$msg['type'] = "Tipo de error desconocido: [$errno] $errstr";
				break;
		}

		$vars['code'] = $errno;
		$vars['error'] = $errstr;
		$vars['message'] = $msg;
		$vars['path_info'] = $errfile." on line ".$errline;
		ToroHook::fire("php_error",$vars);

		return false;
	}

	/**
	 *
	 */
	public static function fatalErrorShutdownHandler()
	{
		$last_error = error_get_last();
		\erdiko\core\ErrorHandler::errorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
	}

	/**
	 * This method will fire a Toro hook in case of receive a valid code.
	 *
	 * @param null $code
	 *
	 * @return bool
	 */
	public static function fire($code=null)
	{
		$vars = array();
		$text = "";
		if ($code !== NULL) {

			switch ( $code ) {
				case 100:
					$text = 'Continue';
					break;
				case 101:
					$text = 'Switching Protocols';
					break;
				case 200:
					$text = 'OK';
					break;
				case 201:
					$text = 'Created';
					break;
				case 202:
					$text = 'Accepted';
					break;
				case 203:
					$text = 'Non-Authoritative Information';
					break;
				case 204:
					$text = 'No Content';
					break;
				case 205:
					$text = 'Reset Content';
					break;
				case 206:
					$text = 'Partial Content';
					break;
				case 300:
					$text = 'Multiple Choices';
					break;
				case 301:
					$text = 'Moved Permanently';
					break;
				case 302:
					$text = 'Moved Temporarily';
					break;
				case 303:
					$text = 'See Other';
					break;
				case 304:
					$text = 'Not Modified';
					break;
				case 305:
					$text = 'Use Proxy';
					break;
				case 400:
					$text = 'Bad Request';
					break;
				case 401:
					$text = 'Unauthorized';
					break;
				case 402:
					$text = 'Payment Required';
					break;
				case 403:
					$text = 'Forbidden';
					break;
				case 404:
					$text = 'Not Found';
					break;
				case 405:
					$text = 'Method Not Allowed';
					break;
				case 406:
					$text = 'Not Acceptable';
					break;
				case 407:
					$text = 'Proxy Authentication Required';
					break;
				case 408:
					$text = 'Request Time-out';
					break;
				case 409:
					$text = 'Conflict';
					break;
				case 410:
					$text = 'Gone';
					break;
				case 411:
					$text = 'Length Required';
					break;
				case 412:
					$text = 'Precondition Failed';
					break;
				case 413:
					$text = 'Request Entity Too Large';
					break;
				case 414:
					$text = 'Request-URI Too Large';
					break;
				case 415:
					$text = 'Unsupported Media Type';
					break;
				case 500:
					$text = 'Internal Server Error';
					break;
				case 501:
					$text = 'Not Implemented';
					break;
				case 502:
					$text = 'Bad Gateway';
					break;
				case 503:
					$text = 'Service Unavailable';
					break;
				case 504:
					$text = 'Gateway Time-out';
					break;
				case 505:
					$text = 'HTTP Version not supported';
					break;
			}
			$vars['message'] = $text;
			$vars['error'] = $text;
			$vars['code'] = $code;
			ToroHook::fire('server_error',$vars);
		}
		return true;
	}
}
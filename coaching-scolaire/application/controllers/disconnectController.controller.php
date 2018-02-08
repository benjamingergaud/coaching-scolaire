<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 06/02/2018
 * Time: 13:18
 */

class disconnectController
{

	function httpGetMethod($get)
	{
		try{
			$userSession = new UserSession();
			$userSession->destroy();
			header("Location: index.php");
		}catch (DomainException $exception){

			return[
				"error"=>$exception->getMessage()
			];
		}
	}


	function httpPostMethod(array $post)
	{
		return[];
	}
}
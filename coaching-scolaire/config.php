<?php
spl_autoload_register(function ($className) {

	if (substr($className, -5) == "Model") {
		require_once "application/models/$className.class.php";

	} else if (substr($className, -10) == 'Controller') {
		require_once "application/controllers/$className.controller.php";  //$className est exclusif au spl autoload, il n'est pas extérieur, d'où la création de $controllerName

	} else {
		require_once "application/classes/$className.class.php";
	}
});
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 05/02/2018
 * Time: 10:51
 */
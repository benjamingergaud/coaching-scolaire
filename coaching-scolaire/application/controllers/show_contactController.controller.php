<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 05/02/2018
 * Time: 12:57
 */

class show_contactController
{

	function httpGetMethod($get)
	{
		$formModel = new Contact_FormModel();
		$form = $formModel->getFormById(intval($get["id"]));
		return[
			"error"=>"",
			"form"=>$form,
			"id"=>intval($get["id"])
		];
	}


	function httpPostMethod(array $post)
	{
		try{
			if (empty($post["name"])||empty($post["age"])||empty($post["contact"])||empty($post["mail"])||
				empty($post["number"])||empty($post["school"])||empty($post["niveau_etude"])||
				empty($post["options"])||empty($post["results"])||empty($post["motivation"])||
				empty($post["attentes"]))
				throw new DomainException("Tous les champs doivent être remplis");
			extract($post);
			$id = $Premier_contact;
			$formModel = new Contact_FormModel();
			$formModel->updateForm($name, $age, $contact, $mail, $number, $school, $niveau_etude, $options, $results, $motivation, $attentes ,$id);
			return[
				"error"=>""
			];
		}catch (DomainException $exception) {

			return[
				"error"=>$exception->getMessage()
			];
		}
	}
}
<?php

class premier_contactController
{

    function httpGetMethod($get)
    {
        return[
        	"error"=>""
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

    		$formModel = new Contact_FormModel();
    		$formModel->addForm( $name,$age,$contact,$mail,$number,$school,$niveau_etude,$options,$results,$motivation,$attentes);
    		return[
    			"error"=>""
		    ];
	    }catch(DomainException $exception){

		    return[
		    	"error"=>$exception->getMessage()
		    ];
	    }
    }
}
<?php

class contactController
{
	private $subject;
	private $content;
    function httpGetMethod($get)
    {
        return[
        	"error" => ""
        ];
    }


    function httpPostMethod(array $post){
	    
    	try{

		    if(empty($post["name"])||empty($post["lastname"])||empty($post["number"])||empty($post["mail"])||empty($post["question"]))
			    throw new DomainException("Veuillez remplir tous les champs");
		   // $this->subject=$post["subject"];

		    $userMail = $post["mail"];
		    $name = $post["name"];
		    $lastname = $post["lastname"];
		    $this->subject = "Prise de Contact de $name $lastname";
		    $number = $post["number"];
		    $question = $post["question"];
		    $question = wordwrap($question, 70, "\r\n");
		    $this->content = "Identité : $lastname $name \r\n Mail : $userMail \r\n Numéro de Téléphone : $number \r\n Question : $question";
		    $this->content=str_replace("\n.", "\n..",$this->content);

		    //$headers = "From: $name $lastname <$userMail> " . "\r\n" .
			    //"Reply-To: $userMail" . "\r\n" .
			//    'X-Mailer: PHP/' . phpversion() ;
		    ini_set("sendmail_from","$userMail");
		    mail("juliepetitlogo@gmail.com",$this->subject,$this->content /*,$headers*/);
		    return[
		    	"error" => ""
		    ];
		    
	    }
    	catch (DomainException $exception){
    		return[
    			"error"=>$exception->getMessage()
		    ];
	    }
	}
}
    	
    	
    	
    
	    

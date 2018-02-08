<?php

class RegisterController {

    public function httpGetMethod($get){
        return [
            'error' => "",
        ];
    }

    public function httpPostMethod(array $post){
        try {
            // on vérifie que les champs sont remplis
            if (empty($post['firstname']) || empty($post['lastname']) ||
                empty($post['email']) || empty($post['password']))
                throw new DomainException("Tous les champs doivent être complétés pour valider l'inscription");

            $userModel = new UserModel();
            $user_id = $userModel->create(
	            $post['firstname'],
	            $post['lastname'],
	            $post['email'],
	            $post['password']
            );

            $userSession = new UserSession();
            $userSession->create($user_id, $post['email'], $userModel->getFullName($user_id));
            header("location: index.php?page=Login");
			return [
				"error"=> ""
			];
        } catch (DomainException $exception){

            //$form->bind($formFields);
            //$form->setErrorMessage($exception->getMessage());

            return [
                'error' => $exception->getMessage(),
            ];
        }
    }
}
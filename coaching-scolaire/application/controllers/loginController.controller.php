<?php

class loginController
{

    function httpGetMethod($get){    //le $get montre que l'on transfert l'informtion

        return [
            '_form' => "",   // juste histoire de mettre quelque chose, mais en réalité on utilise la méthode post donc on ne retourne rien en get
        ];
    }


    function httpPostMethod( array $formFields) {

        try {
            // on vérifie que les champs sont remplis
            if (empty($formFields['email']) || empty($formFields['password']))
                throw new DomainException("Tous les champs doivent être complétés");

            // on vérifie si l'on peut connecter l'utilisateur, si c'est bon, les données de celui-ci
            // sont enregistrés dans $user_infos
            $userModel = new UserModel();
            $user_infos = $userModel->login($formFields['email'], $formFields['password']);

            // puisque la connection est possible, on va enregistrer les infos utilisateur
            // dans $_SESSION pour une réutilisation future
            $userSession = new UserSession();
            $userSession->create($user_infos['id'], $formFields['email'], $user_infos['fullname']);
            header("location: index.php?page=Admin");


        } catch (DomainException $exception){

            return [
                '_form' => "",
            ];
        }

    }
}
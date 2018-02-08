<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 11/12/2017
 * Time: 14:27
 */

class UserModel {

    public function login($email, $password){

        $db = new Database();

        // On fait une première requête pour savoir si un compte avec $email existe déjà
        $sql = "SELECT id, password, firstname, lastname FROM user WHERE email = ?";
        $result = $db->queryOne($sql, [$email]);

        // s'il n'y a pas de compte associé on renvoit une erreur
        if(empty($result))
            throw new DomainException('Utilisateur non trouvé');

        // si les mot de passes ne coincident pas on renvoi une erreur
        if ($this->verifyPassword($password, $result['password']) == false)
            throw new DomainException('Mot de passe incorrect');

        // enfin si tout va bien jusque là, on retourne les infos de l'utilisateur
        // qui seront utilisées pour remplir les données de la session
        return [
            'id' => $result['id'],
            'fullname' => $result['firstname'] .' '. $result['lastname']
        ];
    }

    private function verifyPassword($password, $hashedPassword) {
        // Si le mot de passe en clair est le même que la version hachée alors renvoie true.

        return crypt($password, $hashedPassword) == $hashedPassword;
    }

    public function create($firstname, $lastname, $email, $password){

        $password = $this->hashPassword($password);

        $db = new Database();

        // On fait une première requête pour savoir si un compte avec $email existe déjà
        $sql = "SELECT id FROM user WHERE email = ?";
        $result = $db->queryOne($sql, [$email]);

        // si le résultat n'est pas vide, on a déjà un compte
        if(!empty($result))
            throw new DomainException("Le compte associé au mail $email existe déjà");

        $sql = 'INSERT INTO user (
                firstname, 
                lastname, 
                email, 
                password 
                
        ) VALUES (?,?,?,?)';


        //on insert le membre dans la base et on renvoit la valeur de $db->last_insert_id
        return $db->executeSql($sql, [
            $firstname,
            $lastname,
            $email,
            $password
        ]);
    }

    private function hashPassword($password) {
        /*
         * Génération du sel, nécessite l'extension PHP OpenSSL pour fonctionner.
         *
         * openssl_random_pseudo_bytes() va renvoyer n'importe quel type de caractères.
         * Or le chiffrement en blowfish nécessite un sel avec uniquement les caractères
         * a-z, A-Z ou 0-9.
         *
         * On utilise donc bin2hex() pour convertir en une chaîne hexadécimale le résultat,
         * qu'on tronque ensuite à 22 caractères pour être sûr d'obtenir la taille
         * nécessaire pour construire le sel du chiffrement en blowfish.
         */
        $salt = '$2y$11$' . substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

        // Voir la documentation de crypt() : http://devdocs.io/php/function.crypt
        return crypt($password, $salt);
    }


    function getFullName($id){
        $db = new Database();

        $sql = "SELECT lastname, firstname FROM user WHERE id = ?";
        $result = $db->queryOne($sql, [$id]);

        return $result['firstname'] . ' ' . $result['lastname'];
    }
}
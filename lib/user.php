<?php

function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password, $role = "user")
{
    /*
        @todo faire la requête d'insertion d'utilisateur et retourner $query->execute();
        Attention faire une requête préparer et à binder les paramètres
    */
    $query = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password, role) VALUES (:first_name, :last_name, :email, :password, :role)');
    $query->bindValue(':first_name', $first_name);
    $query->bindValue(':last_name', $last_name);
    $query->bindValue(':email', $email);
    $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    $query->bindValue(':role', $role);
    return $query->execute();

}

function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    /*
        @todo faire une requête qui récupère l'utilisateur par email et stocker le résultat dans user
        Attention faire une requête préparer et à binder les paramètres
    */
    $query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $query->bindValue(':email', $email);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);


    /*
        @todo Si on a un utilisateur et que le mot de passe correspond (voir fonction  native password_verify)
              alors on retourne $user
              sinon on retourne false
    */

    if ($user) {
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;


}

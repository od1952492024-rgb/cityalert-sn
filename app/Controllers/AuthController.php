<?php
namespace App\Controllers;

use App\Models\Repositories\UserRepository;
use App\Exceptions\ValidationException;

class AuthController {
    private UserRepository $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim($_POST['password']);

            $user = $this->userRepo->findByEmail($email);
            
            // Sécurité de secours : accepte le mot de passe en texte clair ou haché
            if ($user && ($password === $user['password'] || password_verify($password, $user['password']))) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                
                if ($_SESSION['user_role'] === 'admin') {
                    header('Location: /cityalert/public/admin/dashboard');
                } else {
                    header('Location: /cityalert/public/incidents');
                }
                exit;
            } else {
                $error = "Identifiants incorrects.";
            }
        }
        require __DIR__ . '/../../views/auth/login.php';
    }
    public function register() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim(htmlspecialchars($_POST['name']));
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim($_POST['password']);

            if (empty($name) || empty($email) || empty($password)) {
                throw new ValidationException("Tous les champs sont obligatoires.");
            }

            if ($this->userRepo->findByEmail($email)) {
                $error = "Cet email est déjà pris.";
            } else {
                $this->userRepo->create($name, $email, $password);
                header('Location: /cityalert/public/');
                exit;
            }
        }
        require __DIR__ . '/../../views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /cityalert/public/');
        exit;
    }
}
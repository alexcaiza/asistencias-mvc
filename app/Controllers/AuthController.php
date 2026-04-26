<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller {
    public function index() {
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole($_SESSION['user_rol']);
        }
        $this->view('auth/login', ['title' => 'Iniciar Sesión']);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $userModel = $this->model('Usuario');
            $user = $userModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'] . ' ' . $user['apellido'];
                $_SESSION['user_rol'] = $user['rol_nombre'];
                
                $this->redirectBasedOnRole($user['rol_nombre']);
            } else {
                $this->view('auth/login', [
                    'title' => 'Iniciar Sesión',
                    'error' => 'Credenciales incorrectas o cuenta inactiva.'
                ]);
            }
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('auth');
    }

    private function redirectBasedOnRole($role) {
        if ($role == 'administrador') {
            $this->redirect('admin');
        } else {
            $this->redirect('worker');
        }
    }
}

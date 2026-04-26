<?php

namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] != 'administrador') {
            header("Location: " . URL_BASE . "/auth");
            exit;
        }
    }

    public function index() {
        $asistenciaModel = $this->model('Asistencia');
        $usuarioModel = $this->model('Usuario');

        $this->view('admin/index', [
            'title' => 'Panel de Administración',
            'asistencias' => $asistenciaModel->getAllAttendance(),
            'usuarios' => $usuarioModel->getAllUsers()
        ]);
    }

    public function asistensias() {
        $asistenciaModel = $this->model('Asistencia');
        $asistencias = $asistenciaModel->getAllAttendance();

        $this->view('admin/asistensias/index', [
            'title' => 'Gestión de Asistencias',
            'asistencias' => $asistencias
        ]);
    }

    public function usuarios() {
        $usuarioModel = $this->model('Usuario');
        $usuarios = $usuarioModel->getAllUsers();

        $this->view('admin/usuarios/index', [
            'title' => 'Gestión de Usuarios',
            'usuarios' => $usuarios
        ]);
    }

    public function crear() {
        $this->view('admin/usuarios/crear', ['title' => 'Agregar Usuario']);
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('Usuario');
            
            $data = [
                'rol_id'   => $_POST['rol_id'],
                'nombre'   => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'dni'      => trim($_POST['dni']),
                'email'    => trim($_POST['email']),
                'password' => $_POST['password']
            ];

            if ($_POST['password'] !== $_POST['confirm_password']) {
                $this->view('admin/usuarios/crear', [
                    'title' => 'Agregar Usuario',
                    'error' => 'Las contraseñas no coinciden.',
                    'data'  => $data
                ]);
            } else if (empty($data['rol_id'])) {
                $this->view('admin/usuarios/crear', [
                    'title' => 'Agregar Usuario',
                    'error' => 'Por favor, seleccione un rol.',
                    'data'  => $data
                ]);
            } else if ($userModel->emailExists($data['email'])) {
                $this->view('admin/usuarios/crear', [
                    'title' => 'Agregar Usuario',
                    'error' => 'El correo electrónico ya está registrado.',
                    'data'  => $data
                ]);
            } else if (!empty($data['dni']) && $userModel->dniExists($data['dni'])) {
                $this->view('admin/usuarios/crear', [
                    'title' => 'Agregar Usuario',
                    'error' => 'El DNI ya está registrado.',
                    'data'  => $data
                ]);
            } else {
                $userModel->create($data);
                $this->redirect('admin/usuarios');
            }
        }
    }

    public function editar($id) {
        $userModel = $this->model('Usuario');
        $usuario = $userModel->getUserById($id);

        if (!$usuario) {
            $this->redirect('admin/usuarios');
        }

        $this->view('admin/usuarios/editar', [
            'title'   => 'Editar Usuario',
            'usuario' => $usuario
        ]);
    }

    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('Usuario');
            
            $data = [
                'nombre'   => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'dni'      => trim($_POST['dni']),
                'email'    => trim($_POST['email']),
                'status'   => $_POST['status'],
                'password' => $_POST['password']
            ];

            if ($userModel->emailExists($data['email'], $id)) {
                $usuario = $userModel->getUserById($id);
                $this->view('admin/usuarios/editar', [
                    'title'   => 'Editar Usuario',
                    'error'   => 'El correo electrónico ya está en uso por otro usuario.',
                    'usuario' => $usuario
                ]);
            } else if (!empty($data['dni']) && $userModel->dniExists($data['dni'], $id)) {
                $usuario = $userModel->getUserById($id);
                $this->view('admin/usuarios/editar', [
                    'title'   => 'Editar Usuario',
                    'error'   => 'El DNI ya está en uso por otro usuario.',
                    'usuario' => $usuario
                ]);
            } else {
                $userModel->update($id, $data);
                $this->redirect('admin/usuarios');
            }
        }
    }

    public function eliminar($id) {
        $userModel = $this->model('Usuario');
        $userModel->delete($id);
        $this->redirect('admin/usuarios');
    }

    public function editarAsistencia($id) {
        $asistenciaModel = $this->model('Asistencia');
        $usuarioModel = $this->model('Usuario');

        $asistencia = $asistenciaModel->getAttendanceById($id);
        $usuarios = $usuarioModel->getAllUsers();

        if (!$asistencia) {
            $this->redirect('admin/asistensias');
        }

        $this->view('admin/asistensias/editar', [
            'title'      => 'Editar Asistencia',
            'asistencia' => $asistencia,
            'usuarios'   => $usuarios
        ]);
    }

    public function actualizarAsistencia($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $asistenciaModel = $this->model('Asistencia');

            $data = [
                'usuario_id'   => $_POST['usuario_id'],
                'fecha'        => $_POST['fecha'],
                'hora_entrada' => $_POST['hora_entrada'],
                'hora_salida'  => $_POST['hora_salida'] ?: null,
                'estado'       => $_POST['estado']
            ];

            $asistenciaModel->update($id, $data);
            $this->redirect('admin/asistensias');
        }
    }

    public function eliminarAsistencia($id) {
        $asistenciaModel = $this->model('Asistencia');
        $asistenciaModel->delete($id);
        $this->redirect('admin/asistensias');
    }
}

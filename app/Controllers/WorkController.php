<?php

namespace App\Controllers;

use App\Core\Controller;

class WorkController extends Controller {
    public function index() {
        $this->view('work/index', ['title' => 'Marcación de Asistencia']);
    }

    public function marcar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dni = trim($_POST['dni']);

            error_log("WorkController::marcar - DNI recibido: " . $dni);

            if (empty($dni)) {
                $this->view('work/index', [
                    'title' => 'Marcación de Asistencia',
                    'error' => 'Por favor ingrese su número de DNI'
                ]);
                return;
            }

            $usuarioModel = $this->model('Usuario');
            $usuario = $usuarioModel->getByDni($dni);

            error_log("WorkController::marcar - Usuario encontrado: " . ($usuario ? print_r($usuario, true) : 'null'));

            if (!$usuario) {
                $this->view('work/index', [
                    'title' => 'Marcación de Asistencia',
                    'error' => 'DNI no encontrado o usuario inactivo'
                ]);
                return;
            }

            $asistenciaModel = $this->model('Asistencia');
            $asistenciaToday = $asistenciaModel->getTodayAttendance($usuario['id']);

            error_log("WorkController::marcar - Asistencia hoy: " . ($asistenciaToday ? print_r($asistenciaToday, true) : 'null'));

            $currentHour = date('H:i');
            $estado = ($currentHour > '08:15') ? 'Tarde' : 'A tiempo';

            if (!$asistenciaToday) {
                $resultado = $asistenciaModel->registrarEntrada($usuario['id'], $estado);
                error_log("WorkController::marcar - Resultado registrarEntrada: " . ($resultado ? 'success' : 'failed'));
                $this->view('work/index', [
                    'title' => 'Marcación de Asistencia',
                    'success' => true,
                    'tipo' => 'entrada',
                    'nombre' => $usuario['nombre'] . ' ' . $usuario['apellido'],
                    'hora' => date('H:i'),
                    'estado' => $estado
                ]);
            } else if ($asistenciaToday && $asistenciaToday['hora_salida'] == null) {
                $resultado = $asistenciaModel->registrarSalida($asistenciaToday['id']);
                error_log("WorkController::marcar - Resultado registrarSalida: " . ($resultado ? 'success' : 'failed'));
                $this->view('work/index', [
                    'title' => 'Marcación de Asistencia',
                    'success' => true,
                    'tipo' => 'salida',
                    'nombre' => $usuario['nombre'] . ' ' . $usuario['apellido'],
                    'hora' => date('H:i'),
                    'entrada' => $asistenciaToday['hora_entrada']
                ]);
            } else {
                $this->view('work/index', [
                    'title' => 'Marcación de Asistencia',
                    'warning' => 'Ya registró su entrada y salida el día de hoy',
                    'nombre' => $usuario['nombre'] . ' ' . $usuario['apellido'],
                    'asistencia' => $asistenciaToday
                ]);
            }
        } else {
            $this->redirect('work');
        }
    }
}
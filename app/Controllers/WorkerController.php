<?php

namespace App\Controllers;

use App\Core\Controller;

class WorkerController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] != 'trabajador') {
            header("Location: " . URL_BASE . "/auth");
            exit;
        }
    }

    public function index() {
        $asistenciaModel = $this->model('Asistencia');
        $asistenciaToday = $asistenciaModel->getTodayAttendance($_SESSION['user_id']);
        $recentAttendance = $asistenciaModel->getRecentAttendance($_SESSION['user_id'], 5);

        $this->view('worker/index', [
            'title' => 'Panel de Trabajador',
            'asistencia' => $asistenciaToday,
            'recentAttendance' => $recentAttendance
        ]);
    }

    public function historial() {
        $asistenciaModel = $this->model('Asistencia');
        $asistenciaToday = $asistenciaModel->getTodayAttendance($_SESSION['user_id']);

        $fecha_inicio = $_GET['fecha_inicio'] ?? null;
        $fecha_fin = $_GET['fecha_fin'] ?? null;

        if ($fecha_inicio && $fecha_fin && $fecha_inicio <= $fecha_fin) {
            $recentAttendance = $asistenciaModel->getAttendanceByDateRange($_SESSION['user_id'], $fecha_inicio, $fecha_fin);
        } else {
            $recentAttendance = $asistenciaModel->getRecentAttendance($_SESSION['user_id'], 5);
        }

        $this->view('worker/index', [
            'title' => 'Panel de Trabajador',
            'asistencia' => $asistenciaToday,
            'recentAttendance' => $recentAttendance,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ]);
    }

    public function registrar() {
        $asistenciaModel = $this->model('Asistencia');
        $asistenciaToday = $asistenciaModel->getTodayAttendance($_SESSION['user_id']);

        if (!$asistenciaToday) {
            // Lógica simple para estado: Si es más de las 08:15 AM, es Tarde
            $currentHour = date('H:i');
            $estado = ($currentHour > '08:15') ? 'Tarde' : 'A tiempo';
            $asistenciaModel->registrarEntrada($_SESSION['user_id'], $estado);
        } else if ($asistenciaToday && $asistenciaToday['hora_salida'] == null) {
            $asistenciaModel->registrarSalida($asistenciaToday['id']);
        }

        $this->redirect('worker');
    }
}

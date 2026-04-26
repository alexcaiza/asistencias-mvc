<?php

namespace App\Models;

use App\Core\Model;

class Asistencia extends Model {
    public function getTodayAttendance($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM asistencias WHERE usuario_id = :user_id AND fecha = CURDATE()");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch();
    }

    public function registrarEntrada($user_id, $estado) {
        $stmt = $this->db->prepare("
            INSERT INTO asistencias (usuario_id, fecha, hora_entrada, estado) 
            VALUES (:user_id, CURDATE(), CURTIME(), :estado)
        ");
        return $stmt->execute([
            'user_id' => $user_id,
            'estado' => $estado
        ]);
    }

    public function registrarSalida($attendance_id) {
        $stmt = $this->db->prepare("
            UPDATE asistencias 
            SET hora_salida = CURTIME() 
            WHERE id = :id
        ");
        return $stmt->execute(['id' => $attendance_id]);
    }

    public function getAllAttendance() {
        $stmt = $this->db->prepare("
            SELECT a.*, u.nombre, u.apellido, u.dni 
            FROM asistencias a
            JOIN usuarios u ON a.usuario_id = u.id 
            ORDER BY a.fecha DESC, a.hora_entrada DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAttendanceById($id) {
        $stmt = $this->db->prepare("
            SELECT a.*, u.nombre, u.apellido, u.dni 
            FROM asistencias a
            JOIN usuarios u ON a.usuario_id = u.id 
            WHERE a.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function update($id, $data) {
        $sql = "UPDATE asistencias SET usuario_id = :usuario_id, fecha = :fecha, hora_entrada = :hora_entrada, hora_salida = :hora_salida, estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'          => $id,
            'usuario_id'  => $data['usuario_id'],
            'fecha'       => $data['fecha'],
            'hora_entrada' => $data['hora_entrada'],
            'hora_salida' => $data['hora_salida'],
            'estado'      => $data['estado']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM asistencias WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getRecentAttendance($user_id, $limit = 5) {
        $stmt = $this->db->prepare("
            SELECT * FROM asistencias 
            WHERE usuario_id = :user_id 
            ORDER BY fecha DESC, hora_entrada DESC 
            LIMIT $limit
        ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function getAttendanceByDateRange($user_id, $fecha_inicio, $fecha_fin) {
        $stmt = $this->db->prepare("
            SELECT * FROM asistencias 
            WHERE usuario_id = :user_id 
            AND fecha BETWEEN :fecha_inicio AND :fecha_fin 
            ORDER BY fecha DESC, hora_entrada DESC
        ");
        $stmt->execute([
            'user_id'      => $user_id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin'    => $fecha_fin
        ]);
        return $stmt->fetchAll();
    }
}
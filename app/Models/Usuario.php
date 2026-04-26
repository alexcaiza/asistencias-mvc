<?php

namespace App\Models;

use App\Core\Model;

class Usuario extends Model {
    public function login($email, $password) {
        $stmt = $this->db->prepare("
            SELECT u.*, r.nombre as rol_nombre 
            FROM usuarios u 
            JOIN roles r ON u.rol_id = r.id 
            WHERE u.email = :email AND u.status = 1
        ");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getByDni($dni) {
        $stmt = $this->db->prepare("
            SELECT u.*, r.nombre as rol_nombre 
            FROM usuarios u 
            JOIN roles r ON u.rol_id = r.id 
            WHERE u.dni = :dni AND u.status = 1
        ");
        $stmt->execute(['dni' => $dni]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $stmt = $this->db->prepare("
            SELECT u.*, r.nombre as rol_nombre 
            FROM usuarios u 
            JOIN roles r ON u.rol_id = r.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (rol_id, nombre, apellido, dni, email, password, status) 
            VALUES (:rol_id, :nombre, :apellido, :dni, :email, :password, 1)
        ");
        return $stmt->execute([
            'rol_id'   => $data['rol_id'],
            'nombre'   => $data['nombre'],
            'apellido' => $data['apellido'],
            'dni'      => $data['dni'] ?? null,
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT)
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, dni = :dni, email = :email, status = :status";
        $params = [
            'id'       => $id,
            'nombre'   => $data['nombre'],
            'apellido' => $data['apellido'],
            'dni'      => $data['dni'] ?? null,
            'email'    => $data['email'],
            'status'   => $data['status']
        ];

        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id) {
        // Borrado lógico
        $stmt = $this->db->prepare("UPDATE usuarios SET status = 0 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $params = ['email' => $email];
        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() ? true : false;
    }

    public function dniExists($dni, $excludeId = null) {
        $sql = "SELECT id FROM usuarios WHERE dni = :dni";
        $params = ['dni' => $dni];
        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() ? true : false;
    }
}

<?php

require_once 'database.php';

class Formulario {
    private $conn;
    private $table_name = "citas";

    public $id_cita;
    public $nombre_propietario;
    public $numero_contacto;
    public $nombre_mascota;
    public $raza_mascota;
    public $servicio;
    public $fecha_cita;
    public $hora_cita;
    public $id_usuario;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conn;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                    (nombre_propietario, numero_contacto, nombre_mascota, raza_mascota, servicio, fecha_cita, hora_cita, id_usuario) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación del statement: " . $this->conn->error);
        }

        $stmt->bind_param("sssssssi", 
            $this->nombre_propietario, 
            $this->numero_contacto, 
            $this->nombre_mascota, 
            $this->raza_mascota, 
            $this->servicio, 
            $this->fecha_cita, 
            $this->hora_cita,
            $this->id_usuario
        );

        $result = $stmt->execute();
        if ($result === false) {
            die("Error en la ejecución del statement: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    public function getAllByUser($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación del statement: " . $this->conn->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $citas = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        return $citas;
    }

    public function deleteById($id_cita, $user_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cita = ? AND id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación del statement: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id_cita, $user_id);
        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }

    public function getById($id_cita, $user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cita = ? AND id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación del statement: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id_cita, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cita = $result->fetch_assoc();

        $stmt->close();
        return $cita;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                    SET nombre_propietario = ?, numero_contacto = ?, nombre_mascota = ?, raza_mascota = ?, servicio = ?, fecha_cita = ?, hora_cita = ?
                    WHERE id_cita = ? AND id_usuario = ?";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación del statement: " . $this->conn->error);
        }

        $stmt->bind_param("sssssssii", 
            $this->nombre_propietario, 
            $this->numero_contacto, 
            $this->nombre_mascota, 
            $this->raza_mascota, 
            $this->servicio, 
            $this->fecha_cita, 
            $this->hora_cita,
            $this->id_cita,
            $this->id_usuario
        );

        $result = $stmt->execute();
        if ($result === false) {
            die("Error en la ejecución del statement: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }
}
?>

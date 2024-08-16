<?php

require_once __DIR__ . '/../models/Formulario.php'; 
require_once __DIR__ . '/../controllers/UserController.php'; // Incluir UserController para obtener los datos del usuario

class FormularioController {
    public function create() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener información del usuario usando UserController
        $userController = new UserController();
        if (!isset($_SESSION['id'])) {
            $_SESSION['id'] = 10; // ID de usuario para pruebas
        }

        $user_id = $_SESSION['id'];
        $user_info = $userController->getUserInfoById($user_id); // Método para obtener la información del usuario

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formulario = new Formulario();

            $formulario->nombre_propietario = isset($_POST['name']) ? $_POST['name'] : '';
            $formulario->numero_contacto = isset($_POST['tel']) ? $_POST['tel'] : '';
            $formulario->nombre_mascota = isset($_POST['mascota']) ? $_POST['mascota'] : '';
            $formulario->raza_mascota = isset($_POST['razamascota']) ? $_POST['razamascota'] : '';
            $formulario->servicio = isset($_POST['servicio']) ? $_POST['servicio'] : '';
            $formulario->fecha_cita = isset($_POST['fecha']) ? $_POST['fecha'] : '';
            $formulario->hora_cita = isset($_POST['hora']) ? $_POST['hora'] : '';
            $formulario->id_usuario = $user_id;

            if ($formulario->create()) {
                echo "<script>alert('Cita agendada exitosamente.');</script>";
            } else {
                echo "<script>alert('Error al agendar la cita.');</script>";
            }

            // Evitar reenvío de formularios al actualizar la página
            header('Location: index.php?controller=FormularioController&action=create');
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once 'views/create.php';
        } else {
            echo "Método de solicitud no permitido.";
        }
    }


    public function list() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['id'])) {
            $_SESSION['id'] = 10; // ID de usuario para pruebas
        }

        $user_id = $_SESSION['id'];
        $formulario = new Formulario();
        $citas = $formulario->getAllByUser($user_id);

        require_once 'views/lista_citas.php';
    }

    public function delete() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['id'])) {
            $_SESSION['id'] = 10; // ID de usuario para pruebas
        }

        $user_id = $_SESSION['id'];
        $id_cita = $_GET['id'] ?? null;

        if ($id_cita) {
            $formulario = new Formulario();
            if ($formulario->deleteById($id_cita, $user_id)) {
                echo "Cita borrada exitosamente.";
            } else {
                echo "Error al borrar la cita.";
            }
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['id'])) {
                $_SESSION['id'] = 10; // ID de usuario para pruebas
            }

            $user_id = $_SESSION['id'];
            $id_cita = $_POST['id_cita'] ?? null;
            $formulario = new Formulario();

            if ($id_cita) {
                $formulario->id_cita = $id_cita;
                $formulario->nombre_propietario = $_POST['name'] ?? '';
                $formulario->numero_contacto = $_POST['tel'] ?? '';
                $formulario->nombre_mascota = $_POST['mascota'] ?? '';
                $formulario->raza_mascota = $_POST['razamascota'] ?? '';
                $formulario->servicio = $_POST['servicio'] ?? '';
                $formulario->fecha_cita = $_POST['fecha'] ?? '';
                $formulario->hora_cita = $_POST['hora'] ?? '';
                $formulario->id_usuario = $user_id;

                if ($formulario->update()) {
                    echo "Cita actualizada exitosamente.";
                } else {
                    echo "Error al actualizar la cita.";
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['id'])) {
                $_SESSION['id'] = 10; // ID de usuario para pruebas
            }

            $user_id = $_SESSION['id'];
            $id_cita = $_GET['id'] ?? null;

            if ($id_cita) {
                $formulario = new Formulario();
                $cita = $formulario->getById($id_cita, $user_id);

                if ($cita) {
                    require_once 'views/editar_cita.php';
                } else {
                    echo "Cita no encontrada.";
                }
            }
        } else {
            echo "Método de solicitud no permitido.";
        }
    }
}

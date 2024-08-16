<?php
require_once "models/database.php"; // Incluir configuración de la base de datos
require_once "models/User.php"; // Incluir el modelo User
require_once "models/Formulario.php"; // Incluir el modelo Formulario (Asegúrate de que está incluido)
require_once "controllers/UserController.php"; // Incluir el controlador UserController
require_once "controllers/Users.php"; // Incluir el controlador Users
require_once "controllers/Landing.php"; // Incluir el controlador Landing
require_once 'controllers/FormularioController.php'; // Incluir el controlador FormularioController

// Verificar el controlador y la acción solicitada
if (!isset($_REQUEST['controller'])) {
    // Si no se especifica un controlador, cargar el controlador de Landing o el que desees
    $controller = new Landing();
    $controller->main();
} else {
    // Si se especifica un controlador
    $controllerName = $_REQUEST['controller'];

    // Determinar la clase del controlador basado en el nombre del controlador solicitado
    switch ($controllerName) {
        case 'Users':
            $controller = new Users();
            break;
        case 'UserController':
            $controller = new UserController();
            break;
        case 'FormularioController':
            $controller = new FormularioController();
            break;
        // Agregar más casos según sea necesario para otros controladores
        default:
            // Manejar el caso donde el controlador no exista
            echo "Error: Controlador '{$controllerName}' no encontrado.";
            exit;
    }

    // Determinar la acción a realizar
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'mostrarFormularioRegistro';

    // Verificar si el método existe en el controlador
    if (method_exists($controller, $action)) {
        // Llamar a la acción del controlador
        call_user_func(array($controller, $action));
    } else {
        // Manejar el caso donde el método no exista
        echo "Error: Acción '{$action}' no encontrada en el controlador '{$controllerName}'.";
    }
}
?>
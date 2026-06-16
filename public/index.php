<?php
session_start();

// Autoloader PSR-4 Manuel
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\ValidationException;

try {
    $router = new Router();

    // Routes Authentification
    $router->add('', 'AuthController', 'login');
    $router->add('register', 'AuthController', 'register');
    $router->add('logout', 'AuthController', 'logout');

    // Routes Incidents
    $router->add('incidents', 'IncidentController', 'index');
    $router->add('incidents/create', 'IncidentController', 'create');
    $router->add('incidents/show/{id}', 'IncidentController', 'show');
    $router->add('incidents/status/{id}', 'IncidentController', 'updateStatus');
    $router->add('incidents/comment/{id}', 'IncidentController', 'addComment');
    $router->add('incidents/delete/{id}', 'IncidentController', 'delete');

    // Routes Administration
    $router->add('admin/dashboard', 'AdminController', 'dashboard');

    $url = $_GET['url'] ?? '';
    $router->dispatch($url);

} catch (EntityNotFoundException $e) {
    http_response_code(404);
    echo "<div style='padding:50px; text-align:center; font-family:sans-serif;'><h1>❌ 404 Not Found</h1><p>{$e->getMessage()}</p><a href='/cityalert/public/incidents'>Retour au tableau de bord</a></div>";
} catch (ValidationException $e) {
    http_response_code(400);
    echo "<div style='padding:50px; text-align:center; font-family:sans-serif;'><h1>⚠️ Erreur de Validation</h1><p>{$e->getMessage()}</p><a href='javascript:history.back()'>Retour</a></div>";
} catch (\Exception $e) {
    http_response_code(500);
    echo "<div style='padding:50px; text-align:center; font-family:sans-serif;'><h1>💥 Erreur Interne</h1><p>{$e->getMessage()}</p></div>";
}
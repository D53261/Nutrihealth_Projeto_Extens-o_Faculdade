<?php
declare(strict_types=1);

$basePath = dirname(__DIR__);

spl_autoload_register(function (string $class) use ($basePath): void {
    $prefix = 'App\\';
    $baseDir = $basePath . '/app/';

    if (strpos($class, $prefix) !== 0) {
        return;
    }

    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = $baseDir . $relative . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Controllers\UserController;
use App\Controllers\AnotationController;

$action = $_GET['action'] ?? 'index';

if (strpos($action, 'anotacoes_') === 0) {
    $controller = new AnotationController();
    $subAction = substr($action, strlen('anotacoes_'));

    switch ($subAction) {
        case 'index':
            $controller->index();
            break;
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'delete':
            $controller->delete();
            break;
        default:
            http_response_code(404);
            echo "❌ Ação de anotação não encontrada.";
            break;
    }

    exit;
}

$controller = new UserController();

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        http_response_code(404);
        echo "❌ Rota não encontrada.";
        break;
}

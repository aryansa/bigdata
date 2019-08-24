<?php

namespace App;

use App\Controllers\AdminController;
use App\Controllers\AdminLinksController;
use App\Controllers\LinksController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\StreamingController;
use App\Controllers\ViewController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routes
{

    public static function register(RouteCollection $collection)
    {
        $routes = $collection;
        self::addRoute($routes, '/', LinksController::class, 'index');
        self::addRoute($routes, 'login/', LoginController::class, 'index');
        self::addRoute($routes, 'logout/', LogoutController::class, 'index');
        self::addRoute($routes, '/admin/', AdminController::class, "index");
        self::addRoute($routes, '/admin/managelinks/', AdminLinksController::class, "index");
        self::addRoute($routes, '/admin/manegelinks/new/', AdminLinksController::class, "newLink");
        self::addRoute($routes, '/admin/managelinks/update/{id}', AdminLinksController::class, "updateLink");
        self::addRoute($routes, '/admin/managelinks/delete/{id}', AdminLinksController::class, "deleteLink");
        self::addRoute($routes, '/admin/managelinks/statistics{t</>}{id}', AdminLinksController::class, "linkStatistics");
        self::addRoute($routes, '/view/{id}', ViewController::class, "view");
        self::addRoute($routes, '/stream/', StreamingController::class, "stream");
        self::addRoute($routes, '/streaming/', StreamingController::class, "update");

    }


    private static function addRoute(RouteCollection $routeCollection, string $url, string $controller, string $method)
    {
        $routeCollection->add($controller . "::" . $method, new Route($url, ['_controller' => $controller . "::" . $method, 'id' => 0]));
    }

}
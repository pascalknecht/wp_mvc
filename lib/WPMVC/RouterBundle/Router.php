<?php
namespace WPMVC\RouterBundle;

class Router {
    public static function add_route( $route_name, $route, $controller, $method ) {
        $controller_file_name = MVC_Controller_Path . $controller . '.php';
        // Throw error if not found
        if( !file_exists( $controller_file_name ) ) {
            throw new \Exception( 'Controller ' . $controller . ' does not exist in ' . $controller_file_name );
        }
        // Include Controller
        include_once( $controller_file_name );
	    
        add_action( 'wp_router_generate_routes', function( $router ) use(  $route_name, $route, $controller, $method ) {
            $controller_class_name = '\\' . $controller;
            $router->add_route(
                $route_name, array(
                    'path' => $route,
                    'query_vars' => array(
                        'company_name' => 1,
                    ),
                    'page_arguments' => array('company_name'),
                    'page_callback' => array( new $controller_class_name, $method ),
                    'access_callback' => true,
                    'title' => 'Test Title',
                )
            );
        });
    }
}
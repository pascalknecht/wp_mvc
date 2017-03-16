<?php

namespace WPMVC\CoreBundle;

use WPMVC\CoreBundle\Config\DoctrineConfig;

class Controller {

    protected $page_title = 'Page Title';

    protected $twig;

    protected $doctrine;

    /**
     * @return mixed
     */
    public function getDoctrine() {
        return $this->doctrine;
    }

    public function __construct() {
        $this->loadTwig();
        $this->loadDoctrine();
    }

    protected function loadTwig() {
        $loader = new \Twig_Loader_Filesystem(MVC_View_Path);
        // set up environment
        $params = array(
            'cache' => "../cache",
            'auto_reload' => true,
            'autoescape' => true,
            'debug' => WP_DEBUG
        );
        $this->twig = new \Twig_Environment($loader, $params);
        if( WP_DEBUG ) {
            $this->twig->addExtension(new \Twig_Extension_Debug());
        }

        // Add WordPress Integration
        $this->twig->addFunction(new \Twig_SimpleFunction('function', array(&$this, 'exec_function')));
    }

    protected function loadDoctrine(){
        $this->doctrine = DoctrineConfig::getDoctrineConf();
        // Load Models
        $classLoader = new \Doctrine\Common\ClassLoader('Entity', MVC_Entity_Path );
        $classLoader->register();
    }

    public function redirect($id, $arguments = array() ) {
        $router = \WP_Router::get_instance();
        $url = $router->get_url( $id );
        wp_redirect($url);
        exit;
    }

    public function loadHelper( $helperName ) {
        $helperName = ucfirst( $helperName ) . 'Helper';
        require_once( MVC_Helper_Path . $helperName );
    }

    public function loadFormType( $formTypeName) {
        $formTypeName = ucfirst( $formTypeName ) . 'Type';
        require_once( MVC_Form_Path . $formTypeName );
    }

    public function exec_function( $function_name ) {
        $args = func_get_args();
        array_shift($args);
        if ( is_string($function_name) ) {
            $function_name = trim($function_name);
        }
        return call_user_func_array($function_name, ($args));
    }

    /**
     * @return mixed
     */
    public function getPageTitle() {
        return $this->page_title;
    }

    /**
     * @param mixed $page_title
     */
    public function setPageTitle($page_title) {
        $this->page_title = $page_title;
    }


}

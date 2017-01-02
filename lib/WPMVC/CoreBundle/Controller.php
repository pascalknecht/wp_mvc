<?php

namespace WPMVC\CoreBundle;

use WPMVC\CoreBundle\Config\DoctrineConfig;

class Controller {

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

    }

    protected function loadDoctrine(){
        $this->doctrine = DoctrineConfig::getDoctrineConf();
        // Load Models
        $classLoader = new \Doctrine\Common\ClassLoader('Entity', MVC_Entity_Path );
        $classLoader->register();
    }

    public function redirect($id, $arguments) {
        $url = \WP_Router::get_url($id, $arguments);
        wp_redirect($url);
    }


}

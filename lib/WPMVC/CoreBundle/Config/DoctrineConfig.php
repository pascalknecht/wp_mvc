<?php
namespace CoreBundle\Config;

class DoctrineConfig {
    public static function getDoctrineConf() {
        // Doctrine ORM
        $ormconfig = new \Doctrine\ORM\Configuration();
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $ormconfig->setQueryCacheImpl($cache);
        $ormconfig->setProxyDir( MVC_Entity_Path . 'EntityProxy');
        $ormconfig->setProxyNamespace('EntityProxy');
        $ormconfig->setAutoGenerateProxyClasses(true);


        \Doctrine\Common\Annotations\AnnotationRegistry::registerFile(MVC_Vendor_Path . 'doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
        $driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
            new \Doctrine\Common\Annotations\AnnotationReader(),
            array(MVC_Entity_Path . 'Entity')
        );
        
        $ormconfig->setMetadataDriverImpl($driver);
        $ormconfig->setMetadataCacheImpl($cache);

        // EntityManager
        $config = array(
            'dbname' => DB_NAME,
            'user'   => DB_USER,
            'password' => DB_PASSWORD,
            'host' => DB_HOST,
            'driver' => 'pdo_mysql',
            'charset' => DB_CHARSET
        );
        $doctrine = \Doctrine\ORM\EntityManager::create($config, $ormconfig);

        return $doctrine;
    }
}
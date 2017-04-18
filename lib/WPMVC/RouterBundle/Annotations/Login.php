<?php

namespace WPMVC\RouterBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
final class Login extends Annotation {

    public $login_required;

}
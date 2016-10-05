<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerLoader(function ($className) {
    return class_exists($className);
});
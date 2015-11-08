<?php

namespace Bex\Behat\ExtensionDriverLocator;

use Bex\Behat\ExtensionDriverLocator\ClassValidator;
use Symfony\Component\DependencyInjection\Container as DIContainer;

class DriverClassNameResolver
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var ClassValidator
     */
    private $classValidator;

    /**
     * @param string         $namespace
     * @param ClassValidator $classValidator
     */
    public function __construct($namespace, ClassValidator $classValidator)
    {
        $this->namespace = $namespace;
        $this->classValidator = $classValidator;
    }

    /**
     * @param  string $driverKey
     *
     * @return string
     */
    public function getClassNameByDriverKey($driverKey)
    {
        $driverClass = $this->namespace . '\\' . ucfirst(DIContainer::camelize($driverKey));
        
        if (!$this->classValidator->isValidDriverClass($driverClass)) {
            throw new \Exception(sprintf('Driver %s was not found in %s', $driverKey, $driverClass));
        }

        return $driverClass;
    }
}
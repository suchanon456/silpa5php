<?php

namespace Silpa5PHP\Config;

/**
 * BaseConfig
 * 
 * Provides the base configuration class for Silpa5PHP framework applications.
 * All configuration files should extend this class to inherit common functionality.
 * 
 * Following the Five Precepts philosophy for configuration management.
 */
class BaseConfig
{
    /**
     * Magical property loader
     * Allows for dynamic property access and setting
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
        
        return null;
    }

    /**
     * Magical property setter
     * Allows for dynamic property setting
     */
    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    /**
     * Import configurations from an array
     * 
     * @param array $config Configuration array to import
     * @return void
     */
    public function importConfig(array $config): void
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Get all public properties as an array
     * Useful for passing configuration to other parts of the system
     * 
     * @return array
     */
    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        
        $config = [];
        foreach ($properties as $property) {
            $config[$property->getName()] = $property->getValue($this);
        }
        
        return $config;
    }
}

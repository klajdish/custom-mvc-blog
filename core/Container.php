<?php

namespace Core;

use Psr\Container\ContainerInterface;
use Core\Exceptions\NotFoundException;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    public $services = [];

    public function get($id)
    {
        $item = $this->resolve($id);
        if (!($item instanceof ReflectionClass) && !is_object($item)) {
            return $item;
        }

        if (isset($this->services[$id]) && $this->services[$id]['isSingleton'] && !is_string($this->services[$id]['value']) ) {
            return $this->services[$id]['value'];
        }


        $obj = $this->getInstance($item);
        if ( isset($this->services[$id]) && $this->services[$id]['isSingleton'] ) {
            $this->services[$id]['value'] = $obj;
        }

        return $obj;
    }

    public function has($id): bool
    {
        try {
            $item = $this->resolve($id);
        } catch (NotFoundException $e) {
            return false;
        }
        if ($item instanceof ReflectionClass) {
            return $item->isInstantiable();
        }
        return isset($item);
    }

    public function singleton(string $key, $value, $isSingleton = true)
    {
        $this->set($key, $value, $isSingleton);
    }

    public function set(string $key, $value, $isSingleton = false)
    {
        $this->services[$key]['value'] = $value;
        $this->services[$key]['isSingleton'] = $isSingleton;
        return $this;
    }

    private function resolve($id)
    {
        try {
            $name = $id;
            if (isset($this->services[$id]['value'])) {
                $name = $this->services[$id]['value'];
                if (is_callable($name)) {
                    return $name();
                }
                if($this->services[$id]['isSingleton'] && is_object($name)){
                    return $name;
                }
            }
            return (new ReflectionClass($name));
        } catch (ReflectionException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getInstance(ReflectionClass $item)
    {
        $constructor = $item->getConstructor();
        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }
        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }
        return $item->newInstanceArgs($params);
    }
}
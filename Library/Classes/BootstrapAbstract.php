<?php

abstract class BootstrapAbstract
{
    public function bootstrap()
    {
        foreach ($this->_getInitFunctions() as $function)
            $this->$function();

        return $this;
    }

    protected function _getInitFunctions()
    {
        $reflection = new ReflectionObject($this);

        $functions = [];

        foreach ($reflection->getMethods(ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE) as $function) {
            if (preg_match('/^_init/', $function->name))
                $functions[] = $function->name;
        }

        return $functions;
    }
}
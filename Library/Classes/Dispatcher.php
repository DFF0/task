<?php

class Dispatcher
{
    public function dispatch(Request $request, Response $response)
    {
        $controller = $this->getController($request->getControllerName());
        $controller->setRequest($request);
        $controller->setResponse($response);

        $function = $this->getControllerFunction($request->getActionName());

        $controller->dispatch($function);
    }

    /**
     *
     * @param string $controllerName
     * @return ActionController
     */
    public function getController($controllerName)
    {
        $className = $this->getControllerClass($controllerName);

        if (!class_exists($className))
            throw new Exception('Can\'t load class ' . $className);

        return new $className;
    }

    public function getControllerClass($controllerName)
    {
        return $controllerName . 'Controller';
    }

    public function getControllerFunction($actionName)
    {
        return $actionName . 'Action';
    }
}
<?php

class FrontController
{
    protected $_request = null;

    protected $_response = null;

    protected $_dispatcher = null;

    protected $_router = null;

    protected static $_instance = null;

    /**
     *
     * @return FrontController
     */
    public static function getInstance()
    {
        if (!isset(static::$_instance))
            static::$_instance = new static;

        return static::$_instance;
    }

    public function run()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $this->getRouter()->route($request);
        $this->getDispatcher()->dispatch($request, $response);

        $response->send();
    }

    public function getRequest()
    {
        if (!isset($this->_request))
            $this->_request = new HttpRequest();

        return $this->_request;
    }

    public function getResponse()
    {
        if (!isset($this->_response))
            $this->_response = new HttpResponse();

        return $this->_response;
    }

    public function getDispatcher()
    {
        if (!isset($this->_dispatcher))
            $this->_dispatcher = new Dispatcher();

        return $this->_dispatcher;
    }

    public function getRouter()
    {
        if (!isset($this->_router))
            $this->_router = new RewriteRouter();

        return $this->_router;
    }
}
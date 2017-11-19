<?php

class ActionController
{
    /**
     *
     * @var Request
     */
    protected $_request = null;

    /**
     *
     * @var Response
     */
    protected $_response = null;

    /**
     *
     * @var View
     */
    protected $_view = null;

    /**
     *
     * @var Layout
     */
    protected $_layout = null;

    /**
     *
     * @var PDO
     */
    protected $_db = null;

    public function __construct()
    {
        $this->_db = Registry::get('db');
    }

    public function setRequest(Request $request)
    {
        $this->_request = $request;
    }

    public function setResponse(Response $response)
    {
        $this->_response = $response;
    }

    protected function _init()
    {

    }

    public function dispatch($action)
    {
        if (!method_exists($this, $action))
            throw new Exception('Invalid function name ' . __CLASS__ . '->' . $action . '()');

        $this->_initLayout();
        $this->_initView();

        $this->_init();

        ob_start();
        $this->$action();

        if ($this->_view->enabled())
            $this->_view->render();

        $content = ob_get_clean();

        if ($this->_layout->enabled()) {
            ob_start();
            $this->_layout->setContent($content);
            $this->_layout->render();
            $content = ob_get_clean();
        }

        $this->_response->setContent($content);
    }

    protected function _initView()
    {
        if (!isset($this->_view)) {
            $this->_view = new View();
            $this->_view->setRequest($this->_request);
            $this->_view->setResponse($this->_response);
            $this->_view->setScriptName($this->_request->getControllerName() . '/' . $this->_request->getActionName() . '.phtml');
            $this->_view->setLayout($this->_layout);
            $this->_view->enable();
        }

        $this->_view;
    }

    protected function _initLayout()
    {
        if (!isset($this->_layout)) {
            $this->_layout = new Layout();
            $this->_layout->enable();
            $this->_layout->setResponse($this->_response);
        }

        $this->_layout;
    }
}
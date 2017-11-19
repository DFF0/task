<?php

class Application
{
    /**
     *
     * @var FrontController
     */
    protected $_frontController = null;

    /**
     *
     * @var Bootstrap
     */
    protected $_bootstrap = null;

    protected $_autoloader = null;

    public function __construct()
    {
        $this->getAutoloader()->register();
    }

    public function run()
    {
        $this->getFronController()->run();
    }

    public function getAutoloader()
    {
        if (!isset($this->_autoloader))
            $this->_autoloader = new Autoloader();

        return $this->_autoloader;
    }

    /**
     *
     * @return Bootstrap
     */
    public function getBootstrap()
    {
        if (!isset($this->_bootstrap)) {
            include 'Bootstrap.php';
            $this->_bootstrap = new Bootstrap();
        }

        return $this->_bootstrap;
    }

    /**
     *
     * @return FrontController
     */
    public function getFronController()
    {
        if (!isset($this->_frontController))
            $this->_frontController = FrontController::getInstance();

        return $this->_frontController;
    }
}
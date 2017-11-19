<?php

class Examples extends Plugin
{
    protected $_examplesDirectory = 'Scripts/Examples';
    protected $_examples = null;

    public function clear()
    {
        $this->_examples = [];
    }

    public function loadExamples()
    {
        $this->clear();

        $iterator = new DirectoryIterator($this->_examplesDirectory);

        foreach ($iterator as $file) {
            /* @var $file DirectoryIterator */
            if (preg_match('/\.php$/', $file->getPathname()))
                $this->addExample($file->getPathname());
        }
    }

    public function addExample($path)
    {
        if (!isset($this->_examples))
            $this->clear();

        if (!is_readable($path))
            throw new Exception('Example file ' . $path . ' is not readable');

        $this->_examples[] = [
            'name' => basename($path),
            'html' => highlight_file($path, true),
        ];
    }

    public function getExample()
    {
        if (!isset($this->_examples))
            $this->loadExamples();

        return $this->_examples;
    }
}
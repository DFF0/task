<?php

class ExamplesController extends ActionController
{
    public function _init()
    {
        foreach ($this->_layout->Examples->getExample() as $exmaple) {
            $this->_layout->LocalMenu->add(
                '<a href="?example=' . $exmaple['name'] . '">' . $exmaple['name'] . '</a>'
            );
        }
    }

    public function IndexAction()
    {
        foreach ($this->_layout->Examples->getExample() as $example) {
            if ($example['name'] == $this->_request->getParam('example')) {
                $this->_view->example = $example;
                break;
            }
        }
    }
}
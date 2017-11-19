<?php

class Response
{
    protected $_headers = null;

    protected $_content = null;

    public function setContent($content)
    {
        $this->_content = $content;
    }

    public function appendContent($content)
    {
        $this->_content .= $content;
    }

    public function prependContent($content)
    {
        $this->_content = $content . $this->_content;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function send()
    {
        $this->sendHeaders();
    }

    public function sendHeaders()
    {

    }

    public function addHeader($header, $value, $replace = false)
    {
        if (!isset($this->_headers))
            $this->_headers = [];

        if (!isset($this->_headers[$header]) || $replace)
            $this->_headers[$header] = ['header' => $header, 'value' => $value];
    }

}
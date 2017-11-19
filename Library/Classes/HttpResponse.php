<?php

class HttpResponse extends Response
{
    public function send()
    {
        $this->sendHeaders();
        echo $this->getContent();
    }

    public function sendHeaders()
    {
        if ($this->_headers) {
            foreach ($this->_headers as $data)
                header($data['header'] . ': ' . $data['value']);
        }
    }
}
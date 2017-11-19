<?php

class RewriteRouter extends Router
{
    public function route(Request $request)
    {
        if (!$request instanceof HttpRequest)
            throw new Exception ('Invalid request class');

        if (preg_match('~/(?P<controller>[^/]+)(?:/(?P<action>[^/]+)?)~', $request->getBaseUrl(), $matches)) {
            $request->setControllerName($matches['controller']);

            if (isset($matches['action']))
                $request->setActionName($matches['action']);
            else
                $request->setActionName('Index');
        } else {
            $request->setControllerName('Index');
            $request->setActionName('Index');
        }
    }
}
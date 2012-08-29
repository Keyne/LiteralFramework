<?php
/**
 * Literal Framework
 */
namespace Literal\Http;

/**
 * The web server representation created in order to allow access to the server variables in a object-oriented fashion.
 */
class ServerParameters extends \Literal\Common\Parameters\ArrayParameters
{
    /**
     * Returns the path being requested relative to the executed script
     * @param $uri
     * @return mixed
     * @throws \RuntimeException
     */
    public function getPathInfo()
    {
        $requestUri = $this->get('REQUEST_URI');
        if(!$requestUri) {
            return '/';
        }

        // Remove the query string from REQUEST_URI
        $pointer = strpos($requestUri, '?');
        if ($pointer) {
            $requestUri = substr($requestUri, 0, $pointer);
        }

        // Removes the base path from the REQUEST_URI
        $basePath = $this->getBasePath();
        $pathInfo = str_replace($basePath, '', $requestUri);

        return $pathInfo;
    }

    /**
     * Returns the root path from which this request is executed.
     * @return string
     */
    public function getBasePath()
    {
        $document_root = $this->get('DOCUMENT_ROOT');
        if(!$document_root) {
            throw new \RuntimeException('Unable to get the document root path');
        }

        $script_filename = $this->get('SCRIPT_FILENAME');
        if(!$script_filename) {
            throw new \RuntimeException('Unable to get the script filename');
        }

        $basedir = str_replace($document_root, '', dirname($script_filename));

        return $basedir;
    }
}

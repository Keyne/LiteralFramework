<?php
/**
 * Literal Framework
 */
namespace Literal\Http;

use Literal\Common\Parameters\ArrayParameters;

/**
 * HTTP Request class
 */
class Request
{
    /**
     * @var ServerParameters The server parameters
     */
    private $server;

    /**
     * @var ArrayParameters Post data from $_POST
     */
    private $post;

    /**
     * @var ArrayParameters Query string from $_GET
     */
    private $query;

    /**
     * @var ArrayParameters The request options (e.g. Used to set the controller and action name)
     */
    private $options;

    /**
     * @var ArrayParameters The files from $_FILES
     */
    private $files;

    /**
     * @var ArrayParameters The session from $_SESSION
     */
    private $session;

    /**
     * @var ArrayParameters The cookies from $_COOKIES
     */
    private $cookies;

    /**
     * Initializes the request object
     * @param ServerParameters $serverParameters
     */
    public function __construct(ServerParameters $serverParameters)
    {
        $this->server = $serverParameters;
    }

    public function getPathInfo()
    {
        return $this->server->getPathInfo();
    }

    public function getBasePath()
    {
        return $this->server->getBasePath();
    }

    /**
     * Loads the request and sets the post, get, cookies and files data
     * @param ArrayParameters $query
     * @param ArrayParameters $post
     * @param ArrayParameters $files
     * @param ArrayParameters $session
     * @param ArrayParameters $cookies
     * @internal param array $data
     */
    public function load(ArrayParameters $query, ArrayParameters $post, ArrayParameters $files, ArrayParameters $session, ArrayParameters $cookies)
    {
        $this->query = $query;
        $this->post = $post;
        $this->files = $files;
        $this->cookies = $session;
        $this->cookies = $cookies;
    }

    /**
     * Returns the post data
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Sets the post data
     * @return $this
     */
    public function setPost($var, $value)
    {
        $this->post[$var] = $value;
        return $this;
    }

    /**
     * Checks if the request is a post request
     * @return bool
     */
    public function isPost()
    {
        return (count($this->post) > 0) ? true : false;
    }

    /**
     * Returns the query string
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Sets the query data (i.e. $_GET)
     * @return $this
     */
    public function setQuery($var, $value)
    {
        $this->query[$var] = $value;
        return $this;
    }

    /**
     * Returns the files
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files data
     * @return $this
     */
    public function setFiles($var, $value)
    {
        $this->files[$var] = $value;
        return $this;
    }

    /**
     * Returns the cookies
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Sets the cookies data
     * @return $this
     */
    public function setCookies($var, $value)
    {
        $this->cookies[$var] = $value;
        return $this;
    }

    /**
     * @return \Literal\Common\Parameters\ArrayParameters
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return \Literal\Common\Parameters\ArrayParameters
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * @param \Literal\Common\Parameters\ArrayParameters $options
     * @return Request
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * @param \Literal\Common\Parameters\ArrayParameters $options
     * @return Request
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return \Literal\Common\Parameters\ArrayParameters
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param \Literal\Common\Parameters\ArrayParameters $session
     * @return Request
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }
}

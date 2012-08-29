<?php
/**
 * Literal Framework
 */
namespace Literal\Http;

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
     * @var array Post data from $_POST
     */
    private $post = array();

    /**
     * @var array Query string from $_GET
     */
    private $query = array();

    /**
     * @var array The files from $_FILES
     */
    private $files = array();

    /**
     * @var array The cookies from $_COOKIES
     */
    private $cookies = array();

    /**
     * Initializes the request object
     * @param ServerParameters $serverParameters
     */
    public function __construct($serverParameters)
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
     * Loads the request and sets the server, post, get, cookies and files data
     * @param array $data
     */
    public function load(array $query, array $post, array $files, array $cookies)
    {
        $this->query = $query;
        $this->post = $post;
        $this->files = $files;
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
     * Returns the query string E.g. page.php?a=1&b=2 from $_GET
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
}

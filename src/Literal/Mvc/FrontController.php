<?php
/**
 * Literal Framework
 */
namespace Literal\Mvc;

use Literal\Di\Container;

use Literal\Http\Request,
    Literal\Http\Response,
    Literal\Routing\Router,
    Literal\Routing\RouteTargetBuilderInterface,
    Literal\View\ViewFactory,
    Literal\Common\Parameters\ArrayParameters;


/**
 * MVC FrontController
 */
class FrontController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var ViewFactory
     */
    private $viewFactory;

    /**
     * @param ArrayParameters $config
     */
    public function __construct(ArrayParameters $config)
    {
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Router $router
     * @return $this
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param ViewFactory $viewFactory
     * @return $this
     */
    public function setViewFactory(ViewFactory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
        return $this;
    }

    /**
     * @param Request $request
     * @throws \BadFunctionCallException
     * @return Response
     */
    public function handle(Request $request)
    {
        $route = $this->router->process($request);
        $target = $route->resolveTarget();

        /**
         * @var RouteTargetBuilderInterface $controllerBuilder
         */
        $controllerBuilder = $route->getRouteTargetBuilder();
        $addressee = $this->parseTarget($target);

        if(!$controllerBuilder) {
            $controllerBuilder = new $addressee['builder']();
        }

        $targetObject = $controllerBuilder->buildTarget();

        $response = call_user_func_array(array($targetObject, $addressee['action']), (array)$route->getFilteredParameters());

        if(!$response instanceof \Literal\Http\Response) {
            if(!is_array($response)) {
                throw new \BadFunctionCallException('The response returned from controller class must be an array ' .
                                                    'or an instance of \Literal\Http\Response');
            }
            $viewModel = $response;

            $viewResolver = $this->viewFactory->buildViewResolver();
            $viewResolver->setAddressee($addressee);
            $script = $viewResolver->getViewScript();

            $viewRenderer = $this->viewFactory->buildViewRenderer();
            $content = $viewRenderer->render($viewModel, $script);
            $response = new \Literal\Http\Response($content);
        }

         return $response;
    }

    /**
     * Returns the target controller, its builder and action (method)
     * @param string $target
     * @throws \InvalidArgumentException
     * @return array
     */
    public function parseTarget($target)
    {
        $class = explode('::', $target);
        if(!is_callable(array($class[0], $class[1]))) {
            throw new \InvalidArgumentException('Unable to find target class/method: ' . $class[0] . '->' . $class[1]);
        }
        $builder = $class[0] . 'Builder';
        return array('builder' => $builder, 'class' => $class[0], 'action' => $class[1]);
    }

    /**
     * Dispatches the request and sends the response to the browser
     */
    public function dispatch()
    {
        $response = $this->handle($this->request);
        $response->send();
    }
}

<?php
/**
 * Literal Framework
 */
namespace Literal\Application\Listener;

use Literal\Http\Response,
    Literal\Application\Event\RequestEvent,
    Literal\View\ViewFactory,
    Literal\View\View;

/**
 * Response builder listener
 */
class ResponseListener
{
    /**
     * @var ViewFactory
     */
    private $viewFactory;

    /**
     * @param ViewFactory $viewFactory
     */
    public function __construct(ViewFactory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Initializes the response
     * @param RequestEvent $requestEvent
     * @throws \UnexpectedValueException
     * @return RequestEvent
     */
    public function init(RequestEvent $requestEvent)
    {
        $result = $requestEvent->getResult();

        if($result instanceof Response) {
            $response = $result;
        } elseif($result instanceof View) {
            $response = $this->buildResponse($result);
        } elseif(is_array($result)) {
            $request = $requestEvent->getRequest();
            $controller = $request->getOption('controller');
            $action = $request->getOption('action');

            $view = $this->viewFactory->buildDefault($controller, $action);
            $variables = $view->getVariables();
            $variables->exchangeArray($result);
            $response = $this->buildResponse($view);
        } else {
            throw new \UnexpectedValueException('Invalid request result');
        }

        $requestEvent->setResponse($response);

        return $requestEvent;
    }

    /**
     * Builds the response object
     * @param View $view
     * @return Response
     */
    public function buildResponse(View $view)
    {
        $content = $view->render();

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent($content);

        return $response;
    }

    /**
     * Sends the response
     * @param \Literal\Application\Event\RequestEvent $requestEvent
     */
    public function send(RequestEvent $requestEvent)
    {
        $response = $requestEvent->getResponse();
        $response->send();
    }
}

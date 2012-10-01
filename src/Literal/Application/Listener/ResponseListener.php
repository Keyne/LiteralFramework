<?php
/**
 * Literal Framework
 */
namespace Literal\Application\Listener;

use Literal\Http\Response,
    Literal\Application\Event\RequestEvent,
    Literal\View\Model\ViewModel,
    Literal\View\Template\Renderer;

/**
 * Response builder listener
 */
class ResponseListener
{
    /**
     * Initializes the response
     * @param RequestEvent $requestEvent
     * @return RequestEvent
     */
    public function init(RequestEvent $requestEvent)
    {
        $response = $this->buildResponse($requestEvent->getResult());
        $requestEvent->setResponse($response);

        return $requestEvent;
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

    /**
     * Builds the request object
     * @param ViewModel|string $viewModel
     * @throws \UnexpectedValueException
     * @return Response
     */
    public function buildResponse($viewModel)
    {
        if($viewModel instanceof ViewModel) {
            $content = $this->renderTemplate($viewModel);
        } elseif(is_string($viewModel)) {
            $content = $viewModel;
        } else {
            throw new \UnexpectedValueException('Expected a ViewModel or a string representing the response body content');
        }

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent($content);

        return $response;
    }

    /**
     * Builds the template renderer
     * @return Renderer
     */
    public function buildTemplateRenderer()
    {
        $viewRenderer = new Renderer();

        return $viewRenderer;
    }

    /**
     * Renders the template and returns the content
     * @param ViewModel $viewModel
     * @return string
     */
    public function renderTemplate(ViewModel $viewModel)
    {
        $renderer = $this->buildTemplateRenderer();

        $templatePath = $viewModel->getTemplatePath();
        $content = $renderer->renderTemplate($templatePath, $viewModel);

        return $content;
    }
}

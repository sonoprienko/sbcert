<?php
namespace SBCert\Controller;

use Pop\Application;
use Pop\Controller\AbstractController;
use Pop\Form\Filter;
use Pop\Http\Request;
use Pop\Http\Response;
use Pop\View\View;


class IndexController extends AbstractController
{
    protected $application;
    protected $request;
    protected $response;
    protected $viewPath;

    public function __construct(Application $application, Request $request, Response $response)
    {
        $this->application = $application;
        $this->request     = $request;
        $this->response    = $response;
        $this->viewPath    = __DIR__ . '/../../view';
    }

    public function index()
    {
        $view = new View($this->viewPath . '/index.phtml');
        $this->response->setBody($view->render());
        $this->response->send();
    }

    public function error()
    {
        $view = new View($this->viewPath . '/error.phtml');
        $view->title = 'Error - Page Not Found';
        $this->response->setBody($view->render());
        $this->response->send(404);
    }
}
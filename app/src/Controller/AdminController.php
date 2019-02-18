<?php

namespace SBCert\Controller;

use Pop\Application;
use Pop\Controller\AbstractController;
use Pop\Http\Request;
use Pop\Http\Response;
use Pop\View\View;
use SBCert\Form;
use SBCert\Model;


class AdminController extends AbstractController
{

    protected $application;

    protected $request;

    protected $response;

    protected $viewPath;

    public function __construct(Application $application, Request $request, Response $response)
    {
        $this->application = $application;
        $this->request = $request;
        $this->response = $response;
        $this->viewPath = __DIR__ . '/../../view';
    }

    public function admin()
    {
        $view = new View($this->viewPath . '/admin.phtml');
        $view->form = new Form\AdminForm();
        if ($this->request->isPost()) {
            $view->form->setFieldValues($this->request->getPost());
            if ($view->form->isValid()) {
                $view->form->clearFilters();
                $user = new Model\User();
                $user_id = $user->save($view->form);

                if ($user_id) {
                    $token = new Model\Token($view->form['email']);
                    $view->token = $token->save($user_id);
                }
            }
        }
        else {
            $view->token = '';
        }
        $this->response->setBody($view->render());
        $this->response->send();
    }

}
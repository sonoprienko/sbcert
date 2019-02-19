<?php

namespace SBCert\Controller;

use Pop\Application;
use Pop\Controller\AbstractController;
use Pop\Http\Request;
use Pop\Http\Response;
use Pop\View\View;
use SBCert\Form;
use SBCert\Model;


class RegisterController extends AbstractController
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

    public function register()
    {
        $view = new View($this->viewPath . '/register.phtml');
        $view->restricted = TRUE;

        if ($this->request->isGet()) {
            $token_id = $this->request->getQuery('token');

            if ($token_id) {
                $user_id = Model\Token::getUserId($token_id);
                if ($user_id) {
                    $view->restricted = FALSE;
                    $user = (new Model\User())->getById($user_id);

                    $view->form = new Form\RegisterForm();
                    $view->form->addTextByType($user->type);
                }
            }
        }
        elseif ($this->request->isPost()) {
            $view->restricted = FALSE;

            $view->form = new Form\RegisterForm();
            $view->form->setFieldValues($this->request->getPost());

            if ($view->form->isValid()) {
                $view->form->clearFilters();

                $token_id = $this->request->getQuery('token');

                if ($token_id) {
                    $user_id = Model\Token::getUserId($token_id);
                    if ($user_id) {
                        $user = new Model\User();
                        $user->save($view->form, $user_id, $token_id);

                        $view->form->addTextByType($user->type);
                    }
                }
            }
        }

        $this->response->setBody($view->render());
        $this->response->send();
    }

}
<?php

namespace SBCert\Form;

use Pop\Form\Form;
use SBCert\Model;

class RegisterForm extends Form
{

    public function __construct(array $fields = NULL, $action = NULL, $method = 'post')
    {
        parent::__construct($fields, $action, $method);
        $fieldConfig = [
            'first_name' => [
                'type' => 'text',
                'label' => 'First Name',
                'required' => TRUE,
                'attributes' => [
                    'size' => 60,
                ],
            ],
            'last_name' => [
                'type' => 'text',
                'label' => 'Last Name',
                'required' => TRUE,
                'attributes' => [
                    'size' => 60,
                ],
            ],
            'password' => [
                'type' => 'password',
                'label' => 'Password',
                'required' => TRUE,
                'attributes' => [
                    'size' => 60,
                ],
            ],
            'submit' => [
                'type' => 'submit',
                'value' => 'Submit',
            ],
        ];
        $this->addFieldsFromConfig($fieldConfig);
    }

    public function addTextByType($type = 0)
    {
        switch ($type) {
            case 2:
                $options = $this->getOptions();
                $text = '<p>' . 'Patient type: ' . $options[$type] . '</p>';
                $this->addNodeValue($text);
                break;
        }
    }

    private function getOptions()
    {
        $options = [];

        $types = Model\UserType::getAll();
        foreach ($types as $value) {
            $id = $value['id'];
            $type = $value['type'];
            $options[$id] = $type;
        }
        return $options;
    }
}
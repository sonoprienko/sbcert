<?php

namespace SBCert\Form;

use Pop\Form\Form;
use SBCert\Model;

class AdminForm extends Form
{

    public function __construct(array $fields = NULL, $action = NULL, $method = 'post')
    {
        parent::__construct($fields, $action, $method);
        $fieldConfig = [
            'type' => [
                'type' => 'select',
                'label' => 'Patient type',
                'required'   => true,
                'values' => $this->getOptions(),
            ],
            'email' => [
                'type' => 'email',
                'label' => 'Email',
                'required'   => true,
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


    private function getOptions () {
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
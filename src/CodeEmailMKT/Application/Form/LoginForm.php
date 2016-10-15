<?php

namespace CodeEmailMKT\Application\Form;

use Zend\Form\Element\{
    Password,
    Submit,
    Text
};

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = 'login', array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'name' => 'email',
            'type' => Text::class,
            'options' => [
                'label' => 'Email'
            ],
            'attributes' => [
                'id' => 'email',
                'type' => 'email'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'options' => [
                'label' => 'Senha',
            ],
            'attributes' => [
                'id' => 'password'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'type' => 'submit'
            ]
        ]);
    }
}
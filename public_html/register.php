<?php

use App\Users\Model;

require '../bootloader.php';

$form_create = [
    'callbacks' => [
        'success' => 'form_success_create',
        'fail' => 'form_fail_create'
    ],
    'attr' => [
        'action' => 'register.php',
        'method' => 'POST',
    ],
    'fields' => [
        'name' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => 'Your Name',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example name',
                ]
            ],
            'validators' => [
                'validate_not_empty',
            ],
        ],
        'email' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => 'Your Email',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example name@email.com',
                ]
            ],
            'validators' => [
                'validate_not_empty',
            ],
        ],
        'password' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => 'Your Password',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example password',
                ]
            ],
            'validators' => [
                'validate_not_empty',
            ],
        ],
    ],
    'buttons' => [
//        'clear' => [
//            'title' => 'Clear',
//            'extra' => [
//                'attr' => [
//                    'class' => 'clear-btn',
//                ]
//            ]
//        ],
        'save' => [
            'title' => 'Create',
            'extra' => [
                'attr' => [
                    'class' => 'save-btn',
                ]
            ]
        ],
    ],
];

$data = [
    'left' => [
        [
            'title' => 'Home',
            'url' => '/index.php',
        ],
    ],
    'right' => [
        [
            'title' => 'Login',
            'url' => '/login.php',
        ],
        [
            'title' => 'Register',
            'url' => '/register.php',
        ],
        [
            'title' => 'Logout',
            'url' => '/logout.php',
        ],
    ],
];

function form_success_create($input, &$form_create)
{
    $modelUser = new App\Users\Model();
    $user = new\App\Users\User($input);

    $modelUser->insert($user);

    $form_create['message'] = 'register form submitted';
}

function form_fail_create(&$form_create, $safe_input)
{
    $form_create['message'] = 'register form not properly submitted';
}

if (!empty($_POST)) {
    $safe_input = get_form_input($form_create);
    $success = validate_form($safe_input, $form_create);
} else {
    $success = false;
}

$modelUser = new \App\Users\Model();

$users = $modelUser->get([]);

$view = [];
$view['form'] = new \App\Views\Form($form_create);
$view['navigation'] = new \App\Views\Navigation();

?>

<html>
<head>
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>OOP</title>
</head>
<body>

<div>
    <?php print $view['form']->render(); ?>
    <?php print $view['navigation']->render(); ?>
</div>

</body>
</html>

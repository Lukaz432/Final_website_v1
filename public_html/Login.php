<?php

use App\Users\Model;

require '../bootloader.php';

$form_create = [
    'callbacks' => [
        'success' => 'form_success_create',
        'fail' => 'form_fail_create'
    ],
    'attr' => [
        'action' => 'login.php',
        'method' => 'POST',
    ],

    'validators' => [
        'validate_login'
    ],
    'fields' => [
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
    header('Location: index.php');
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

$show_form = !$success;

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
<?php print $view['navigation']->render(); ?>

<div class="login-form">
    <?php if ($show_form): ?>
        <?php print $view['form']->render(); ?>

    <?php endif; ?>
</div>

</body>
</html>
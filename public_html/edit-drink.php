<?php

use App\Drinks\Model;

require '../bootloader.php';

function form_success_edit($safe_input, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $drink = new \App\Drinks\Drink($safe_input);
    $modelDrinks->update($drink);
}

function form_fail_edit(&$form, $safe_input)
{
    $form_edit['message'] = 'form edit failed';
}

$modelDrinks = new \App\Drinks\Model();
$drink = $modelDrinks->getById($_GET['id']);
var_dump($drink);

$form_edit = [
    'callbacks' => [
        'success' => 'form_success_edit',
        'fail' => 'form_fail',
    ],
    'attr' => [
        'action' => 'edit-drink.php',
        'method' => 'POST'
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
            'value' => $_GET['id'],
        ],
        'name' => [
            'value' => $drink->getName(),
            'label' => 'Pavadinimas',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'pvz: Absolut',
                ],
                'validators' => [
                    'validate_not_empty',
                ]
            ]
        ],
        'amount' => [
            'value' => $drink->getAmount(),
            'label' => 'kiekis',
            'type' => 'number',
            'extra' => [
                'attr' => [
                    'placeholder' => 'pvz: 500',
                ],
                'validators' => [
                    'validate_not_empty',
                    'validate_is_number'
                ]
            ]
        ],
        'abarot' => [
            'value' => $drink->getAbarot(),
            'label' => 'abarot',
            'type' => 'number',
            'extra' => [
                'attr' => [
                    'placeholder' => 'pvz: 4.4',
                    'step' => '0.1'
                ],
                'validators' => [
                    'validate_not_empty',
                    'validate_is_number'
                ]
            ],
        ],
        'image' => [
            'value' => $drink->getImage(),
            'label' => 'nuotraukos (url)',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'pvz: http://..',
                ],
                'validators' => [
                    'validate_not_empty',
                ]
            ]
        ],
        'price' => [
            'value' => $drink->getPrice(),
            'label' => 'price',
            'type' => 'number',
            'extra' => [
                'attr' => [
                    'placeholder' => 'pvz: 4.4',
                    'step' => '0.1'
                ],
                'validators' => [
                    'validate_not_empty',
                    'validate_is_number'
                ]
            ],
        ],
        'in_stock' => [
            'value' => $drink->getStock(),
            'label' => 'in_stock',
            'type' => 'number',
            'extra' => [
                'attr' => [
                    'placeholder' => 'pvz: 4',
                    'step' => '0.1'
                ],
                'validators' => [
                    'validate_not_empty',
                    'validate_is_number'
                ]
            ],
        ],
    ],
];

if (!empty($_POST)) {
    $safe_input = get_form_input($form_edit);
    $success = validate_form($safe_input, $form_edit);
} else {
    $success = false;
}

$view = [];
$view['nav'] = new \App\Views\Navigation();
$view['form'] = new \App\Views\Form($form_edit);

?>
<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>Document</title>
</head>
<body>
<?php print $view['nav']->render(); ?>
<?php print $view['form']->render(); ?>
</body>
</html>
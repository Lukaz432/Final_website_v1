<?php

use App\Drinks\Model;

require '../bootloader.php';

function form_success_create($input, &$form_create)
{
    $modelDrinks = new \App\Drinks\Model();
    $drink = new\App\Drinks\Drink($input);

    $modelDrinks->insert($drink);

    $form_create['message'] = 'form submitted successfully';
}

function form_fail_create($remove, &$form_create)
{
    $form_create['message'] = 'form not properly submitted';
}

function form_success_remove($input, &$form_create)
{
    $modelDrinks = new \App\Drinks\Model();
    $drink = new\App\Drinks\Drink($input);

    $modelDrinks->delete($drink);

    $form_create['message'] = 'form removed successfully';
}

function form_fail_remove($safe_input, &$form_create)
{
    $form_create['message'] = 'form remove failed';
}

function form_success_order($input, &$form)
{
    $modelOrder = new \App\Orders\Model();
    $order = new \App\Orders\Order([
        'timestamp' => time(),
        'drink_id' => $input['id'],
        'status' => 'ordered',
    ]);

    $modelOrder->insert($order);
    $modelDrinks = new \App\Drinks\Model();
    $drink = $modelDrinks->getByID($input['id']);

    $in_stock_get = $drink->getStock() - 1;
    $drink->setStock($in_stock_get);
    $modelDrinks->update($drink);

    $cookie = new \Core\Cookie('cookie_delivery');

    $data = [
            'cookie_delivery' => 1,
    ];

    $data = $cookie->save();
//    var_dump($cookie->read());
    if(isset($data['drinks_taken']))
    {
        $data['drinks_taken']++;

//        $data = $cookie->save($data);
    }
}

function form_fail_order($safe_input, &$form_create)
{
    $form_order['message'] = 'form order failed';
}

$form_create = [
    'callbacks' => [
        'success' => 'form_success_create',
        'fail' => 'form_fail_create',
    ],
    'attr' => [
        'action' => 'index.php',
        'method' => 'POST',
    ],
    'fields' => [
        'name' => [
            'label' => 'Drink Name',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example: beer',
                ]
            ],
            'validators' => [
                'validate_not_empty',
            ],
        ],
        'image' => [
            'label' => 'Drink Image',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example: beer pic',
                ]
            ],
            'validators' => [
                'validate_not_empty',
            ],
        ],
        'abarot' => [
            'label' => 'Drink Abarot',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example: 5.5',
                    'step' => '0.1',
                ]
            ],
            'validators' => [
                'validate_not_empty',
                'validate_is_number',
            ],
        ],
        'amount' => [
            'label' => 'Drink Amount (ml)',
            'type' => 'string',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example: 500',
                    'step' => '0.1'
                ]
            ],
            'validators' => [
                'validate_not_empty',
                'validate_is_number',
            ],
        ],
        'price' => [
            'label' => 'Price (Eur)',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example: 3.5',
                    'step' => '0.1'
                ]
            ],
            'validators' => [
                'validate_not_empty',
                'validate_is_number',
            ],
        ],
        'stock' => [
            'label' => 'Stock',
            'type' => 'number',
            'extra' => [
                'attr' => [
                    'placeholder' => 'example: 5',
                ]
            ],
            'validators' => [
                'validate_not_empty',
                'validate_is_number',
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

$form_remove = [
    'callbacks' => [
        'success' =>
            'form_success_remove',
        'fail' =>
            'form_fail_remove',
    ],
    'attr' => [
        'action' => 'index.php',
        'method' => 'POST',
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
            'value' => '999'
        ],
    ],
    'buttons' => [
        'clear' => [
            'title' => 'Remove',
            'extra' => [
                'attr' => [
                    'class' => 'clear-btn',
                ]
            ]
        ],
    ],
];

$form_order = [
    'callbacks' => [
        'success' =>
            'form_success_order',
        'fail' =>
            'form_fail_order',
    ],
    'attr' => [
        'action' => 'index.php',
        'method' => 'POST',
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ],
    ],
    'buttons' => [
        'order' => [
            'title' => 'Order',
            'extra' => [
                'attr' => [
                    'class' => 'order-btn',
                ]
            ]
        ],
    ],
];

$form_edit = [
    'callbacks' => [
        'success' =>
            'form_success_edit',
    ],
    'attr' => [
        'action' => 'edit-drink.php',
        'method' => 'GET',
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ],
    ],
    'buttons' => [
        'edit' => [
            'title' => 'Edit',
            'extra' => [
                'attr' => [
                    'class' => 'order-btn',
                ]
            ]
        ],
    ],
];

if (!empty($_POST)) {
    switch (get_form_action()) {
        case 'clear':
            $safe_input = get_form_input($form_remove);
            $success = validate_form($safe_input, $form_remove);
            break;
        case 'save':
            $safe_input = get_form_input($form_create);
            $success = validate_form($safe_input, $form_create);
            break;
        case 'order':
            $safe_input = get_form_input($form_order);
            $success = validate_form($safe_input, $form_order);
            break;
        case 'edit':
            $safe_input = get_form_input($form_edit);
            $success = validate_form($safe_input, $form_edit);
            break;
    }
    $success = false;
}

$modelDrinks = new \App\Drinks\Model();
$drinks = $modelDrinks->get([]);

$catalog = [];
foreach ($drinks as $drink) {
    $form_remove['fields']['id']['value'] = $drink->getId();
    $form_order['fields']['id']['value'] = $drink->getId();
    $form_edit['fields']['id']['value'] = $drink->getId();
    $catalog[] = [
        'form_remove' => new \App\Views\Form($form_remove),
        'form_order' => new \App\Views\Form($form_order),
        'form_edit' => new \App\Views\Form($form_edit),
        'dataholder' => $drink,
    ];
}

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

<?php if (\App\App::$session->userLoggedIn()): ?>
    <?php print $view['form']->render(); ?>
<?php endif; ?>

<section class="container">
    <?php foreach ($catalog as $item): ?>
        <?php $item['dataholder']->getName() ?>
        <div class="container-drink">
            <div class="container-drink-properties">
                <div class="card-image">
                    <div class="card-amount">
                        <span><?php print $item['dataholder']->getPrice(true) ?></span>
                    </div>
                    <img src="<?php print $item['dataholder']->getImage() ?>">
                </div>
                <div class="card-name">
                    <span><?php print $item['dataholder']->getName() ?></span>
                </div>
                <div class="card-abarot">
                    <span><?php print $item['dataholder']->getAbarot(true) ?></span>
                </div>
                <div class="card-amount">
                    <span><?php print $item['dataholder']->getAmount(true) ?></span>
                </div>
            </div>
            <div class="card-amount">
                <span>In Stock: <?php print $item['dataholder']->getStock() ?></span>
            </div>
            <?php if (\App\App::$session->userLoggedIn()): ?>
                <?php print $item['form_remove']->render() ?>
                <?php print $item['form_edit']->render() ?>
            <?php else: ?>
                <?php print $item['form_order']->render() ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</section>
</body>
</html>
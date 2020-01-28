<?php

use \App\Orders\Model;

require '../bootloader.php';

$form_delivery_btn = [
    'callbacks' => [
        'success' => 'form_success_delivery',
    ],
    'attr' => [
        'method' => 'POST'
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ],
    ],
    'buttons' => [
        'delivery' => [
            'title' => 'Deliver',
            'extra' => [
                'att' => [
                    'class' => 'save-btn',
                ]
            ]
        ]
    ],
];

function form_success_delivery($safe_input, &$form)
{
    $modelOrders = new \App\Orders\Model();
    $order = $modelOrders->getByID($safe_input['id']);
    $order->setStatus('delivered');
    $modelOrders->update($order);
}

$modelOrders = new \App\Orders\Model();
$orders = $modelOrders->get([]);

$view = [];
$view['nav'] = new \App\Views\Navigation();
$view['form_delivery_btn'] = new \App\Views\Form($form_delivery_btn);

$modelDrink = new \App\Drinks\Model();
$drink = new \App\Drinks\Drink();

foreach ($orders as $order) {
    $form_delivery_btn['fields']['id']['value'] = $order->getID();
    $drinks_orders_array [] = [
        'order' => $order,
        'drink' => $modelOrders->getByID($order->getDrinkID()),
        'form_delivery_btn' => new \App\Views\Form($form_delivery_btn),
    ];
}

if (!empty($_POST)) {
    $safe_input = get_form_input($form_delivery_btn);
    $success = validate_form($safe_input, $form_delivery_btn);
}

?>
<html>
<body>
<?php print $view['nav']->render(); ?>
<table>
    <tr>
        <th>Drink Name</th>
        <th>Drink ID</th>
        <th>Order ID</th>
        <th>Time</th>
        <th>Status</th>
    </tr>
    <?php foreach ($drinks_orders_array as $item): ?>
        <tr>
            <td>
                <?php print $item['drink']->getName(); ?>
            </td>
            <td>
                <?php print $item['order']->getId(); ?>
            </td>
            <td>
                <?php print $item['order']->getDrinkId(); ?>
            </td>
            <td>
                <?php print $item['order']->getTimestamp(); ?>
            </td>
            <td>
                <?php print $item['order']->getStatus(); ?>
            </td>
            <td>
                <?php print $item['form_delivery_btn']->render(); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
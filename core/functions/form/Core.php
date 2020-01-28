<?php

require 'Validators.php';

function get_form_input($form_create) {
    $filter_parameters = [];
    foreach ($form_create['fields'] as $field_id => $field) {
        if (isset($field['filter'])) {
            $filter_parameters[$field_id] = $field['filter'];
        } else {
            $filter_parameters[$field_id] = FILTER_SANITIZE_SPECIAL_CHARS;
        }
    }
    return filter_input_array(INPUT_POST, $filter_parameters);
}

/** Removes dangerous symbols
 * Sanitizes submitted button data
 * @return string
 */
function get_form_action() {
    return filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Validates entered data against
 * field validators defined in $form_create
 *
 * @param array $filtered_input filtered POST data
 * @param array $form_create
 * @return boolean
 */
function validate_form($filtered_input, &$form_create) {
    $success = true;

    foreach ($form_create['fields'] as $field_id => &$field) {
        $field_value = $filtered_input[$field_id];

        // Set field value from submitted form, so the user
        // doesnt have to enter it again if form fails
        $field['value'] = $field_value;
        foreach ($field['validators'] ?? [] as $validator_id => $validator) {
            // We can make validator receive params, setting it as an array itself
            // in that case, validator id becomes its callback function
            if (is_array($validator)) {
                $is_valid = $validator_id($field_value, $field, $validator);
            } else {
                $is_valid = $validator($field_value, $field);
            }
            if (!$is_valid) {
                $success = false;
                break;
            }
        }
    }

    if ($success && isset($form_create['validators'])) {
        foreach ($form_create['validators'] as $validator_id => $validator) {
            if (is_array($validator)) {
                $is_valid = $validator_id($filtered_input, $form_create, $validator);
            } else {
                $is_valid = $validator($filtered_input, $form_create);
            }
            if (!$is_valid) {
                $success = false;
                break;
            }
        }
    }

    if ($success) {
        if (isset($form_create['callbacks']['success'])) {
            $form_create['callbacks']['success']($filtered_input, $form_create);
        }
    } else {
        if (isset($form_create['callbacks']['fail'])) {
            $form_create['callbacks']['fail']($filtered_input, $form_create);
        }
    }

    return $success;
}

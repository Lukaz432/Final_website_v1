<form <?php print html_attr(($data['attr'] ?? []) + ['method' => 'POST']); ?>>

    <!-- Field Generation Start -->
    <?php foreach ($data['fields'] ?? [] as $field_id => $field): ?>
        <div class='field-wrapper'>
            <?php if (isset($field['label'])): ?>
            <label>
            <span class="label">
                <?php print $field['label']; ?>
            </span>
                <?php endif; ?>
                <input <?php print html_attr(
                    [
                        'name' => $field_id,
                        'type' => $field['type'],
                        'value' => $field['value'] ?? '',
                    ] + ($field['extra']['attr'] ?? [])
                ); ?>>
                <?php if (isset($field['label'])): ?>
            </label>
        <?php endif; ?>

            <?php if (isset($field['type']) && $field['type'] == 'select'): ?>
            <select>
                <?php foreach ($field['option'] as $key => $optionval): ?>
                <option value="<?php print $key ?>"> <?php print $optionval;  ?></option>
                    <?php endforeach; ?>
                    </select>
            <?php endif; ?>

        </div>
        <?php if (isset($field['error'])): ?>
            <div>
                <span><?php print $field['error']; ?></span>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <!-- Field Generation End -->

    <!-- Button Generation Start -->
    <?php foreach ($data['buttons'] ?? [] as $button_id => $button): ?>
        <button <?php print html_attr(['name' => 'action', 'value' => $button_id] + ($button['extra']['attr'] ?? [])); ?>>
            <?php print $button['title']; ?>
        </button>
    <?php endforeach; ?>
    <!-- Button Generation End -->

    <?php if (isset($data['message'])): ?>
        <div>
            <span><?php print $data['message']; ?></span>
        </div>
    <?php endif; ?>

</form>
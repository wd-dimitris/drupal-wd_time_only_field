<?php

namespace Drupal\wd_time_only_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'wd_time_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "wd_time_default",
 *   label = @Translation("Time Only"),
 *   field_types = {
 *     "wd_time_only"
 *   }
 * )
 */
class WdTimeFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = [];
        foreach ($items as $delta => $item) {
            // Render each element as markup.
            $element[$delta] = [
                '#type' => 'markup',
                '#markup' => $item->value,
            ];
        }
        return $element;

    }


}
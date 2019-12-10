<?php

namespace Drupal\wd_time_only_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type of time only.
 *
 * @FieldType(
 *   id = "wd_time_only",
 *   label = @Translation("WD Time Only"),
 *   category = @Translation("WD"),
 *   default_formatter = "wd_time_default",
 *   default_widget = "wd_time_default",
 * )
 */
class WdTimeOnly extends FieldItemBase {

    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        return [
            'columns' => [
                'value' => [
                    'type' => 'varchar',
                    'length' => '5',
                    'not null' => FALSE,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() {
        $value = $this->get('value')->getValue();
        return $value === NULL || $value === '';
    }

    /**
     * {@inheritdoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties['value'] = DataDefinition::create('string')
            ->setLabel(t('Time'));
        return $properties;
    }
}
<?php

namespace Drupal\wd_time_only_field\Plugin\Field\FieldWidget;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'wd_time_widget' widget.
 *
 * @FieldWidget(
 *   id = "wd_time_default",
 *   label = @Translation("Time Only"),
 *   field_types = {
 *     "wd_time_only"
 *   }
 * )
 */
class WdTimeWidget extends WidgetBase {

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return [
            'start' => '08:00',
            'end' => '21:00',
            'increment' => '30',
            ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
        $value = isset($items[$delta]->value) ? $items[$delta]->value : '';

        $start = $this->getSetting('start');
        $end = $this->getSetting('end');
        $increment = $this->getSetting('increment');

        $dt = new DrupalDateTime($start);
        $current = $dt->format('H:i');
        $timeOptions = [];
        while($current <= $end){
            $timeOptions[$current] = $current;
            $dt->modify("+ $increment minutes");
            $current = $dt->format('H:i');
        }

        $element += [
            '#type' => 'select',
            '#default_value' => $value,
            '#options' => $timeOptions,
        ];
        return ['value' => $element];
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state) {
        $element = parent::settingsForm($form, $form_state);

        $element['start'] = [
            '#type' => 'textfield',
            '#title' => t('Start Time'),
            '#default_value' => $this->getSetting('start'),
            '#element_validate' => [
                [$this, 'startTimeValidate'],
            ],
        ];

        $element['end'] = [
            '#type' => 'textfield',
            '#title' => t('End Time'),
            '#default_value' => $this->getSetting('end'),
            '#element_validate' => [
                [$this, 'endTimeValidate'],
            ],
        ];

        $element['increment'] = [
            '#type' => 'select',
            '#title' => t('Time increments'),
            '#default_value' => $this->getSetting('increment'),
            '#options' => [
                '1' => t('1 minute'),
                '5' => t('5 minute'),
                '10' => t('10 minute'),
                '15' => t('15 minute'),
                '30' => t('30 minute'),
            ],
        ];

        return $element;
    }

    public function startTimeValidate($element, FormStateInterface $form_state){
        $start = $element['#value'];
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $start)) {
            $form_state->setError($element, t('Start time should be in hh:mm format'));
        }
    }

    public function endTimeValidate($element, FormStateInterface $form_state){
        $end = $element['#value'];
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $end)) {
            $form_state->setError($element, t('End time should be in hh:mm format'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = [];

        $summary[] = t('Start Time: @start', ['@start' => $this->getSetting('start')]);
        $summary[] = t('End Time: @end', ['@end' => $this->getSetting('end')]);
        $summary[] = t('Time increments: @increment', ['@increment' => $this->getSetting('increment')]);

        return $summary;
    }

}
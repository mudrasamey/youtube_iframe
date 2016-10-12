<?php

/**
 * @file
 * Contains \Drupal\youtube_iframe\Plugin\Field\FieldFormatter\YoutubeIframe.
 */

namespace Drupal\youtube_iframe\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;



/**
 * Plugin implementation of the 'youtube_iframe' field formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_iframe",
 *   label = @Translation("Youtube Iframe"),
 *   field_types = {
 *     "string",
 *     "text",
 *     "link",
 *   }
 * )
 */
class YoutubeIframe extends FormatterBase {

  public static function defaultSettings() {
    return array(
      'youtube_width' => 400,
      'youtube_height' => 300,
      'youtube_autoplay' => 1,
    ) + parent::defaultSettings();
  }
  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();
    $element['youtube_width'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Width'),
      '#description' => $this->t('Width of the iframe'),
      '#default_value' => $settings['youtube_width'],
    );
    $element['youtube_height'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Height'),
      '#description' => $this->t('Height of the iframe'),
      '#default_value' => $settings['youtube_height'],
    );
    $element['youtube_autoplay'] = array(
      '#title' => $this->t('Autoplay'),
      '#type' => 'checkbox',
      '#default_value' => $settings['youtube_autoplay'],
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $summary[] = t('Set custom size of the iframe');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    foreach ($items as $delta => $item) {
      $url = $item->getValue();
      $elements[$delta] = array(
        '#theme' => 'youtube_iframe_formatter',
        '#url' => $url['value'],
        '#height' => $this->getSetting('youtube_height'),
        '#width' => $this->getSetting('youtube_width'),
        '#autoplay' => $this->getSetting('youtube_autoplay'),
      );
    }
    return $elements;
  }
}
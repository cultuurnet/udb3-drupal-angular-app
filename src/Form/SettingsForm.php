<?php

namespace Drupal\culturefeed_udb3_app\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form to configure culturefeed udb3 app.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'culturefeed_udb3_app_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['culturefeed_udb3_app.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('culturefeed_udb3_app.settings');

    $form['websocket_server'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('WebSocket server'),
      '#default_value' => $config->get('websocket_server'),
    );

    $form['upload_terms_conditions_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Url with terms & conditions for uploads'),
      '#default_value' => $config->get('upload_terms_conditions_url'),
    );

    $form['upload_copy_right_info_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Url with more information about copyright info for uploads'),
      '#default_value' => $config->get('upload_copy_right_info_url'),
    );

    return parent::buildForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $values = $form_state->getValues();
    $this->config('culturefeed_udb3_app.settings')
      ->set('websocket_server', $values['websocket_server'])
      ->set('upload_terms_conditions_url', $values['upload_terms_conditions_url'])
      ->set('upload_copy_right_info_url', $values['upload_copy_right_info_url'])
      ->save();
    parent::submitForm($form, $form_state);
  }

}

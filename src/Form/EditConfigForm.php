<?php

namespace Drupal\module_mk\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implement an example form
 */

class EditConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'edit_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'module_mk.identity',
    ];
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('module_mk.identity');
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Insert a new name'),
      '#default_value' => $config->get('name')
    );
    $form['surname'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Insert a new surname'),
      '#default_value' => $config->get('surname')
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('name')) == 0) {
      $form_state->setErrorByName('name', $this->t('Insert a name.'));
    }
    if (strlen($form_state->getValue('surname')) == 0) {
      $form_state->setErrorByName('surname', $this->t('Insert a surname.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('The new identity is @name @surname', array('@name' => $form_state->getValue('name'), '@surname' => $form_state->getValue('surname'))));
    //Load config in edit mode
    $this->config('module_mk.identity')
      ->set('name', $form_state->getValue('name'))
      ->set('surname', $form_state->getValue('surname'))
      ->save();
    $form_state->setRedirect('module_mk.hello-config');

    parent::submitForm($form, $form_state);
  }

}

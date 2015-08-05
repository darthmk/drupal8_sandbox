<?php

namespace Drupal\module_mk\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implement an example form
 */

class RedirectForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'redirect_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['redirect_to'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Insert the route')
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('redirect_to')) == 0) {
      $form_state->setErrorByName('redirect_to', $this->t('Insert a valid route. (ex. system.admin)'));
    }
    else {
      $url = Url::fromRoute($form_state->getValue('redirect_to'));
      try {
        $url->toString();
      } catch (\Exception $e) {
        //drupal_set_message($this->t('The route is routed? @routed', array('@routed' => $url->toString())));
        $form_state->setErrorByName('redirect_to', $this->t('Insert a valid route. (ex. system.admin)'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('The route is @route', array('@route' => $form_state->getValue('redirect_to'))));
    $form_state->setRedirect($form_state->getValue('redirect_to'));
  }

}
<?php
namespace Drupal\module_mk\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Greets the user.
 */
class Hello extends ControllerBase {
  public function content() {
    //return $this->redirect('system.admin');
    $build = array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello World!'),
    );
    return $build;
  }

  public function greet($name, $surname) {
    //return $this->redirect('system.admin');
    $build = array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello @name @surname!', array('@name' => $name, '@surname' => $surname)),
    );
    return $build;
  }

  public function greet_from_config() {
    $config = \Drupal::config('module_mk.identity');
    $build = array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello @name @surname!', array('@name' => $config->get('name'), '@surname' => $config->get('surname'))),
    );
    return $build;
  }

  public function greet_from_config_install() {
    $config = \Drupal::config('module_mk.settings');
    $build = array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello @username @email!', array('@username' => $config->get('identity.name'), '@email' => $config->get('identity.email'))),
    );
    return $build;
  }
}

<?php

namespace Drupal\badgekit\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\badgekit\Form
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'badgekit_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('badgekit.settings');

    $form['badgekit_url'] = array(
      '#type' => 'url',
      '#title' => $this->t('URL'),
      '#default_value' => $config->get('url'),
    );
    $form['badgekit_secret'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Secret'),
      '#default_value' => $config->get('secret'),
    );

    if ($config->get('url') && $config->get('secret')) {
      $systems = \Drupal::service('badgekit.service_client')->getSystems();
      $system_options = ['' => 'None'];
      $issuer_options = ['' => 'None'];
      $program_options = ['' => 'None'];
      foreach ($systems['systems'] as $system) {
        $system_options[$system['slug']] = $system['name'];
        foreach ($system['issuers'] as $issuer) {
          $issuer_options[$issuer['slug']] = $issuer['name'];
          foreach ($issuer['programs'] as $program) {
            $program_options[$program['slug']] = $program['name'];
          }
        }
      }

      $form['badgekit_system'] = array(
        '#type' => 'select',
        '#title' => $this->t('System'),
        '#default_value' => $config->get('system'),
        '#options' => $system_options,
      );

      $form['badgekit_issuer'] = array(
        '#type' => 'select',
        '#title' => $this->t('Issuer'),
        '#default_value' => $config->get('issuer'),
        '#options' => $issuer_options,
      );

      $form['badgekit_program'] = array(
        '#type' => 'select',
        '#title' => $this->t('Program'),
        '#default_value' => $config->get('program'),
        '#options' => $program_options,
      );
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('badgekit.settings')
      ->set('url', $form_state->getValue('badgekit_url'))
      ->set('secret', $form_state->getValue('badgekit_secret'))
      ->set('system', $form_state->getValue('badgekit_system'))
      ->set('issuer', $form_state->getValue('badgekit_issuer'))
      ->set('program', $form_state->getValue('badgekit_program'))
      ->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'badgekit.settings',
    ];
  }
}

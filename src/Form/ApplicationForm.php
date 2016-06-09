<?php

namespace Drupal\badgekit\Form;

use Caxy\BadgeKit\ServiceClient;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Command\Exception\CommandClientException;

/**
 * Class ApplicationForm.
 *
 * @package Drupal\badgekit\Form
 */
class ApplicationForm extends FormBase
{


    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'badgekit_application_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        /** @var ServiceClient $client */
        $client = \Drupal::service('badgekit.service_client');

        $result = $client->getBadges();

        $options = [];
        foreach ($result['badges'] as $badge) {
            $options[$badge['slug']] = $badge['name'];
        }
        $form['badge'] = array(
          '#title' => 'Badge',
          '#type' => 'select',
          '#options' => $options,
        );
        $form['reflection'] = array(
          '#type' => 'textarea',
          '#title' => $this->t('Reflection'),
        );
        $form['submit'] = array(
          '#type' => 'submit',
          '#value' => 'Submit',
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        /** @var ServiceClient $client */
        $client = \Drupal::service('badgekit.service_client');
        $config = $this->config('badgekit.settings');

        try {
            $result = $client->createApplication([
              'badge' => $form_state->getValue('badge'),
              'body' => [
                'learner' => $this->currentUser()->getEmail(),
              ]
            ]);
        } catch (CommandClientException $e) {
            // this probably should happen in the validate step instead of submit.
        }
    }

}

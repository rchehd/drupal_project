<?php

namespace Drupal\pets_owners_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class for create form 'Pets owners form'.
 */
class PetsOwnersForm extends FormBase {

  /**
   * Method to build form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Form for pets owners'),
    ];

    // Name.
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Name must be at least 5 characters in length.'),
      '#required' => TRUE,
    ];

    // Gender.
    $form['settings']['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => [
        0 => $this->t('Male'),
        1 => $this->t('Female'),
        2 => $this->t('Unknown'),
      ],
      '#default_value' => 2,
    ];

    // Prefix.
    $form['settings']['prefix'] = [
      '#type' => 'select',
      '#title' => $this->t('Prefix'),
      '#options' => [
        'red' => $this->t('Mr'),
        'blue' => $this->t('Mrs'),
        'green' => $this->t('Ms'),
      ],
      '#empty_option' => $this->t(' '),
    ];

    // Form age.
    $form['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#description' => $this->t('Your age must be numeric or text.'),
      '#required' => TRUE,
    ];

    // Parent form.
    $form['parent'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Parents'),
    ];

    $form['parent']['mother'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Mother's name"),
    ];

    $form['parent']['father'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Father's name"),
    ];

    // Have you some pets?.
    $form['have_pets'] = [
      '#type' => 'checkbox',
      '#title' => 'Have you some pets?',
    ];
    $form['pets'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'pets',
      ],
      '#states' => [
        'invisible' => [
          ':input[name="have_pets"]' => ['checked' => FALSE],
        ],
      ],
    ];
    $form['pets']['have'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Names of your pets'),
    ];

    // Email.
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    // Button.
    $form['button'] = [
      '#type' => 'submit',
      '#value' => 'Ok',
    ];
    return $form;
  }

  /**
   * Set id to our form.
   */
  public function getFormId() {
    return 'pets_owners_form';
  }

  /**
   * Method to Display “Thank you” .
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addMessage($this->t('Thank you!'));
  }

  /**
   * Method to validate data on form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate name.
    $name = $form_state->getValue('name');
    if (strlen($name) > 100) {
      $form_state->setErrorByName('Name', $this->t('Your Name must be 100 symbols max.'));
    }
    // Validate age.
    $age = $form_state->getValue('age');
    if (!is_numeric($age)) {
      $form_state->setErrorByName('Age', $this->t('Your age must be numeric.'));
    }
    elseif ($age < 0 || $age > 120) {
      $form_state->setErrorByName('Age', $this->t('Your age should be more than 0 and less than 120'));
    }
    // Validate email.
    $age = $form_state->getValue('email');
    $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
    $valid = preg_match($emailPattern, $age);
    if ($valid == FALSE) {
      $form_state->setErrorByName('Age', $this->t('Your email is not correct!'));
    }
  }

}

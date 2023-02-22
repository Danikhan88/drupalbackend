<?php

/**
 * @file
 * Contains \Drupal\student_registration\Form\RegistrationForm.
 */

namespace Drupal\dependency_injection_services\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class EditForm extends FormBase
{
    //this loaddata is an object which we call in our Submit function

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'custom_form';
    }
    //we called our constructor(service) here which we have defined in DB_insert file under services folder
    // public function __construct()
    // {
    //     $this->loaddata = \Drupal::service('dependency_injection_services.dbinsert');
    // }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $id = \Drupal::routeMatch()->getParameter('id');
        $query = \Drupal::database();
        $data = $query->select('custom_form', 'e')
            ->fields('e', ['id', 'name', 'father_name', 'phone'])
            ->condition('e.id', $id, '=')
            ->execute()
            ->fetchAll();

        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name:'),
            '#required' => true,
            '#maxlength' => 30,
            '#default_value' => $data[0]->name,
        );
        $form['father_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Father Name:'),
            '#required' => true,
            '#maxlength' => 50,
            '#default_value' => $data[0]->father_name,
        );
        $form['phone'] = array(
            '#type' => 'tel',
            '#title' => t('Contact Number'),
            '#maxlength' => 30,
            '#default_value' => $data[0]->phone,
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Update'),
            '#button_type' => 'primary',
        );

        $form['#attached']['library'][] = 'custom_module/custom_module_css_js';
        //Adding css and js to a form

        return $form;
        // kint($form);
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $formField = $form_state->getValues();

        $name = trim($formField['name']);
        $father_Name = trim($formField['father_name']);
        $email = trim($formField['mail']);
        $contact = trim($formField['phone']);

        if (!preg_match("/^([a-zA-Z- ' ]+)$/", $name)) {
            $form_state->setErrorByName('name', $this->t('Enter valid name'));
        }
        if (!preg_match("/^([a-zA-Z- ' ]+)$/", $father_Name)) {
            $form_state->setErrorByName('father_name', $this->t('Enter valid name'));
        }

        if (strlen($form_state->getValue('phone')) < 11) {
            $form_state->setErrorByName('phone', $this->t('Please enter a valid Contact Number'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        //Here we have called loaddata object and setData funtion which we have defind in Db_insert file under services folder
        $query = \Drupal::service('dependency_injection_services.dbinsert')->editData($form_state);
        $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../');
        $response->send();
        \Drupal::messenger()->addMessage(t("Data Updated  Successfully"));
    }
}
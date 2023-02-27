<?php
/**
 * @file
 * Contains \Drupal\student_registration\Form\RegistrationForm.
 */
namespace Drupal\dependency_injection_services\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dependency_injection_services\services\Db_insert;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomForm extends FormBase
{
    //this loaddata is an object which we call in our Submit function
    protected $loaddata;
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'custom_form';
    }
  
    public function __construct(Db_insert $loaddata) {
        $this->loaddata = $loaddata;
         // $this->loaddata = \Drupal::service('dependency_injection_services.dbinsert');
      }
      
    public static function create(ContainerInterface $container) {
        return new static(
          $container->get('dependency_injection_services.dbinsert')
        );
      }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name:'),
            '#required' => true,
            '#maxlength' => 30,
        );
        $form['father_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Father Name:'),
            '#required' => true,
            '#maxlength' => 50,
        );
        $form['mail'] = array(
            '#type' => 'textfield',
            '#title' => t('Email ID:'),
            '#required' => true,

        );
        $form['phone'] = array(
            '#type' => 'tel',
            '#title' => t('Contact Number'),
            '#maxlength' => 30,
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Register'),
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

        if (!\Drupal::service('email.validator')->isValid($email)) {
            $form_state->setErrorByName('mail', $this->t('Enter valid email address'));
        }

        if (strlen($form_state->getValue('phone')) < 11) {
            $form_state->setErrorByName('phone', $this->t('Please enter a valid Contact Number'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $formField = $form_state->getValues();

        $formData['mail'] = $formField['mail'];
        $mail = $formData['mail'];

        $user_email = \Drupal::database()->select('custom_form', 'ufd')
            ->condition('ufd.mail', $mail)
            ->fields('ufd', ['mail'])
            ->execute()
            ->fetchCol();
        if ($user_email) {
            \Drupal::messenger()->addError(t("Email ID  is already taken"));
        } else {
            //Here we have called loaddata object and setData funtion which we have defind in Db_insert file under services folder
            $query = $this->loaddata->setData($form_state);
            $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../');
            $response->send();
            \Drupal::messenger()->addMessage(t("Data Inserted  Successfully"));
        }
    }
}
<?php
/**
 * @file
 * Contains \Drupal\student_registration\Form\RegistrationForm.
 */
namespace Drupal\custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;


class EditForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'student_edit_form';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {

    $id = \Drupal::routeMatch()->getParameter('id');
        $query = \Drupal::database();
        $data = $query->select('reg_form', 'e')
        ->fields('e', ['id', 'student_name','student_phone','student_dob','student_gender'])
        ->condition('e.id', $id, '=')
        ->execute()
        ->fetchAll();

    $form['student_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Student Name:'),
      '#required' => TRUE,
      '#maxlength' => 30,
      '#default_value'=> $data[0]->student_name,
    );
    $form['student_phone'] = array (
      '#type' => 'tel',
      '#title' => t('Student Contact Number'),
      '#maxlength' => 30,
      '#default_value'=> $data[0]->student_phone,
    );
    $form['student_dob'] = array (
      '#type' => 'date',
      '#title' => t('Studet DOB:'),
      '#required' => TRUE,
      '#default_value'=> $data[0]->student_dob,
    );
    $form['student_gender'] = array (
      '#type' => 'select',
      '#title' => ('Select Gender:'),
      '#options' => array(
        'Male' => t('Male'),
		    'Female' => t('Female'),
        'Other' => t('Other'),
      ),
      '#default_value'=> $data[0]->student_gender,

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
  function custom_module_form_alter(&$form, &$form_state, $form_id){
    $form['#validate'][] = 'custom_module_validate';
}
function custom_module_validate(&$form,&$form_state){
  $student_email = $form_state['values']['textfield'];

  $check_unique_query = 'SELECT * FROM {reg_form} WHERE text_field_value = :student_mail LIMIT 1';
  if (db_query($check_unique_query,array(':student_email'=>$student_email))->fetchField()){
      form_set_error('textfield','This Email ID is already in use');
  }
}
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $formField = $form_state->getValues();

    $studentName = trim($formField['student_name']);
    $studentContact = trim($formField['student_phone']);

    if (!preg_match("/^([a-zA-Z- ' ]+)$/", $studentName)) {
      $form_state->setErrorByName('student_name', $this->t('Enter valid student name'));
    }

    if(strlen($form_state->getValue('student_phone')) < 11) {
      $form_state->setErrorByName('student_phone', $this->t('Please enter a valid Contact Number'));
    }
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $id = \Drupal::routeMatch()->getParameter('id');
  
        $formField = $form_state->getValues();
        $formData['student_name'] = $formField['student_name'];
        $formData['student_phone'] = $formField['student_phone'];
        $formData['student_dob'] = $formField['student_dob'];
        $formData['student_gender'] = $formField['student_gender'];

        $query = \Drupal::database();
        $data = $query->update('reg_form')
        ->fields($formData)
        ->condition('id', $id)
        ->execute();
         
          $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../');
          $response->send();
          \Drupal::messenger()->addMessage(t("Student Updated  Successfully"));
        }
  }

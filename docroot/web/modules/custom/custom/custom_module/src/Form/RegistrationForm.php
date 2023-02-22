<?php
/**
 * @file
 * Contains \Drupal\student_registration\Form\RegistrationForm.
 */
namespace Drupal\custom_module\Form;
// namespace Drupal\custom_module\File;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;


class RegistrationForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'student_registration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['student_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Student Name:'),
      '#required' => TRUE,
      '#maxlength' => 30,
    );
    $form['student_rollno'] = array(
      '#type' => 'textfield',
      '#title' => t('Studetn Enroll Number:'),
      '#required' => TRUE,
      '#maxlength' => 50,
    );
    $form['student_mail'] = array(
      '#type' => 'textfield',
      '#title' => t('Student Email ID:'),
      '#required' => TRUE,
     
    );
    $form['student_phone'] = array (
      '#type' => 'tel',
      '#title' => t('Student Contact Number'),
      '#maxlength' => 30,
    );
    $form['student_dob'] = array (
      '#type' => 'date',
      '#title' => t('Studet DOB:'),
      '#required' => TRUE,
    );
    $form['student_gender'] = array (
      '#type' => 'select',
      '#title' => ('Select Gender:'),
      '#options' => array(
        'Male' => t('Male'),
		    'Female' => t('Female'),
        'Other' => t('Other'),
      ),
    );

    // $form['file_upload'] = array(
    //   '#type' => 'managed_file',
    //   '#title' => t('Upload file'),
    //   '#description' => t('Upload a file, allowed extensions: pdf doc docx'),
    //   '#upload_location' => 'public://my_module_files/',
    //   '#upload_validators' => array(
    //     'file_validate_extensions' => array('pdf doc docx jpg png'),
    //   ),
    // );
    $form['file_upload'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload a file'),
      '#upload_location' => 'public://',
      '#upload_validators' => [
        'file_validate_extensions' => ['pdf doc docx jpg png'],
      ],
    ];
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

    public function validateForm(array &$form, FormStateInterface $form_state) {
    $formField = $form_state->getValues();

    $studentName = trim($formField['student_name']);
    $studentRollno = trim($formField['student_rollno']);
    $email = trim($formField['student_mail']);
    $studentContact = trim($formField['student_phone']);

    if (!preg_match("/^([a-zA-Z- ' ]+)$/", $studentName)) {
      $form_state->setErrorByName('student_name', $this->t('Enter valid student name'));
    }

    if(strlen($form_state->getValue('student_rollno')) < 5) {
      $form_state->setErrorByName('student_rollno', $this->t('Please enter a valid Roll Number'));
    }

    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('student_mail', $this->t('Enter valid email address'));
    }

    if(strlen($form_state->getValue('student_phone')) < 11) {
      $form_state->setErrorByName('student_phone', $this->t('Please enter a valid Contact Number'));
    }
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
 
    $file = File::load($form_state->getValue('file_upload')[0]);
    
    // Save the file to the specified directory.
    // $file->setDestination('public://my_module_files/');
    // $file->save();
    $file_uri = 'public://' . $file->getFilename();
    $file->setFileUri($file_uri);
    $file->save();
    
    $formField = $form_state->getValues();


        $formData['student_name'] = $formField['student_name'];
        $formData['student_rollno'] = $formField['student_rollno'];
        $formData['student_mail'] = $formField['student_mail'];
        $mail=$formData['student_mail'];
        $rollno=$formData['student_rollno'];
        $formData['student_phone'] = $formField['student_phone'];
        $formData['student_dob'] = $formField['student_dob'];
        $formData['student_gender'] = $formField['student_gender'];
        $formData['file_upload'] = $formField['file_upload'];
        
        $user_email = \Drupal::database()->select('reg_form', 'ufd')
        ->condition('ufd.student_mail', $mail)
        ->fields('ufd', ['student_mail'])
        ->execute()
        ->fetchCol();

        $user_rollno = \Drupal::database()->select('reg_form', 'ufd')
        ->condition('ufd.student_rollno', $rollno)
        ->fields('ufd', ['student_rollno'])
        ->execute()
        ->fetchCol();
        if($user_email || $user_rollno){
              \Drupal::messenger()->addError(t("Email ID or Roll No is already taken"));
        }else{
          
          
          \Drupal::database()->insert('reg_form')
          ->fields($formData)
          ->execute();
          
          $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../');
          $response->send();
          \Drupal::messenger()->addMessage(t("Student Inserted  Successfully"));
        }
  }
  private function getAllowedFileExtensions(){
    return array('jpg jpeg gif png txt doc docx zip xls xlsx pdf ppt pps odt ods odp');
  }
}
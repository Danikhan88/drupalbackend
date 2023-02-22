<?php
namespace Drupal\custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Exception;

/**
 * Provides route responses for the Example module.
 */
// class MyException extends Exception{
//   function addMessage(){
//     return $this->getMessage();
//   }
// }
class Custom_moduleController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function myPage() {
    return [
      '#markup' => 'Hello, world',
    ];
  }
  public function getstudenetList(){
    $query = \Drupal::database();
    $res = $query->select('reg_form', 'ufd')
    ->fields('ufd', ['id','student_name','student_rollno','student_mail','student_phone','student_dob','student_gender'])
    ->execute()
    ->fetchAll();

    $data = [];
    $count = 1;
    
    foreach($res as $row)
    {
      $data[] = [
        'serial_no'=> $count.".",
        'student_name'=> $row->student_name,
        'student_rollno'=> $row->student_rollno,
        'student_mail'=> $row->student_mail,
        'student_phone'=> $row->student_phone,
        'student_dob'=> $row->student_dob,
        'student_gender'=> $row->student_gender,
      ];
      $count++;
    }

    $header = array('S.No','Student Name','Student Roll No'.'Student Email','Student Contact','Student DOB','Student Gender');

    $build['table'] = [
      '#type' => 'table',
      '#header' =>$header,
      '#rows' => $data,
    ];
    
    return [
       $build,
       '#title' => 'Registered Students List'
    ];
  }
  public function deleteStudent($id){
    $query = \Drupal::database();
    $query->delete('reg_form')
        ->condition('id', $id, '=')
        ->execute();

$response = new \Symfony\Component\HttpFoundation\RedirectResponse('../');
$response->send();

\Drupal::messenger()->addMessage('Student Deleted Successfully');
}


// public function importArticles() {
  // $json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
  // $articles = json_decode($json, TRUE);

  // try{
  //   if($json !==file_get_contents('https://jsonplaceholder.typicode.com/posts')){

  //     throw new Exception("Please provide valid API");
  //   }
   
  //   foreach ($articles as $article_data) {
  //     $node = \Drupal\node\Entity\Node::create([
  //       'type' => 'article',
  //       'title' => $article_data['title'],
  //       'body' => [
  //         'value' => $article_data['body'],
  //         'format' => 'full_html',
  //       ],
  //       'field_authored_by' => $article_data['userId'],
  //       'field_id' => $article_data['id'],
  //     ]);
  
  //     $node->save();
  //   }
  // }
  //   catch(Exception $error){
  //     \Drupal::messenger()->addError($error->getMessage());
  //   }
  public function importArticles() {
  $json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
  $articles = json_decode($json, TRUE);

  try{
    if($json !==file_get_contents('https://jsonplaceholder.typicode.com/posts')){

      throw new Exception("Please provide valid API");
    }
   
    foreach ($articles as $article_data) {
      $node = \Drupal\node\Entity\Node::create([
        'type' => 'article',
        'title' => $article_data['title'],
        'body' => [
          'value' => $article_data['body'],
          'format' => 'full_html',
        ],
        'field_authored_by' => $article_data['userId'],
        'field_id' => $article_data['id'],
      ]);
  
      $node->save();
    }
  }
    catch(Exception $error){
      \Drupal::messenger()->addError($error->getMessage());
    }

  return [
    '#markup' => $this->t('Read the above notification.'),
  ];

  return [
    '#markup' => $this->t('Read the above notification.'),
  ];
}
}
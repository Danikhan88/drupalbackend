<?php
/**
 * @file
 * Contains \Drupal\article\Plugin\Block\XaiBlock.
 */

namespace Drupal\custom_module\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\custom_module\Controller\Custom_moduleController;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "article_block",
 *   admin_label = @Translation("Article block"),
 *   category = @Translation("Custom article block example")
 * )
 */
class ArticleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // return array(
    //   '#type' => 'markup',
    //   '#markup' => 'This block list the article.',
    // );
    
    //Method 1 for Fetching Data from database to a custom block
    
    $query = \Drupal::database();
    $res = $query->select('reg_form', 'ufd')
    ->fields('ufd', ['id','student_name','student_rollno','student_mail','student_phone','student_dob','student_gender'
    ])
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
        'edit'=>$this->t("<a href='edit_student/$row->id'>Edit</a>"),
        'Delete'=>$this->t("<a href='delete_student/$row->id'>Delete</a>"),
      ];
      $count++;
    }

    $header = array('S.No','Student Name','Student Roll No','Student Email','Student Contact','Student DOB',
    'Student Gender','Edit','Delete');

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
  //Method 2 for Fetching Data from database to a custom block

  // public function build() {

  //    $controller_variable = new Custom_moduleController;
  //    $rendering_in_block = $controller_variable->getStudentList();
  //    return $rendering_in_block;

  // }
 
}
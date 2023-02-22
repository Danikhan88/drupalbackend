<?php
/**
 * @file
 * Contains \Drupal\customblock\Plugin\Block\XaiBlock.
 */

namespace Drupal\dependency_injection_services\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\FormInterface;
use Drupal\Core\Block\AccountInterface;
use Drupal\Core\Block\AccessResult;


/**
 * Provides a 'custom' block.
 *
 * @Block(
 *   id = "custom_block",
 *   admin_label = @Translation("Custom block"),
 *   category = @Translation("Custom  block example")
 * )
 */
class CustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    //In this custom block we have rendered data from database using below service which is under services folder and twig template"we have defined this getData funtion in DB_insert and my_temaplate in .module file"
  
    $data = \Drupal::service('dependency_injection_services.dbinsert')->getData();
    return [
       '#theme' => 'my_template',
       '#data' => $data,
    ];
  }
}
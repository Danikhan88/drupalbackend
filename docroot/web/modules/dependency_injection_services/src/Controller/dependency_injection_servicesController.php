<?php
namespace Drupal\dependency_injection_services\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the Example module.
 */
class dependency_injection_servicesController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */

  public function deleteData($id){
    $query = \Drupal::service('dependency_injection_services.dbinsert')->deleteData($id);

$response = new \Symfony\Component\HttpFoundation\RedirectResponse('../');
$response->send();

\Drupal::messenger()->addMessage('Data Deleted Successfully');
}
}
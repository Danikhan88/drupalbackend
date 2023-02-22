<?php

namespace Drupal\dependency_injection_services\services;

use Drupal\Core\Database\Connection;

class Db_insert
{
    //This is Database connection
    protected $database;
    public function __construct(Connection $database)
    {
        $this->database = $database;
    }
    /**
     * set Data funtion
     */
    // we have defined a function "setData" through this we insert our data to Database, we have to call this SetData ftn in our Form in submit ftn
    public function setData($form_state)
    {
        $this->database->insert('custom_form')
            ->fields(
                array(
                    'name' => $form_state->getvalue('name'),
                    'father_name' => $form_state->getvalue('father_name'),
                    'mail' => $form_state->getvalue('mail'),
                    'phone' => $form_state->getvalue('phone'),
                    'created' => time(),
                )
            )->execute();
    }
    /**
     * get Data funtion
     */
    // we have defined a function "getData" through this we fetch our data from Database, we have to call this getData ftn in our customBlock build ftn
    public function getData()
    {
        $query = $this->database->select('custom_form', 'e');
        $query->fields('e');
        $res = $query->execute()->fetchAll();
        return $res;
    }

    /**
     * get Data funtion
     */
    // we have defined a function "editData" through this we Edit our data
    public function editData($form_state)
    {
        $id = \Drupal::routeMatch()->getParameter('id');

        $formField = $form_state->getValues();
        $formData['name'] = $formField['name'];
        $formData['father_name'] = $formField['father_name'];
        $formData['phone'] = $formField['phone'];

        $query = \Drupal::database();
        $data = $query->update('custom_form')
            ->fields($formData)
            ->condition('id', $id)
            ->execute();
    }
    /**
     * Delete Data funtion
     */
    // we have defined a function "deleteData" through this we Delete our data
    public function deleteData($id)
    {
        $query = \Drupal::database();
        $query->delete('custom_form')
            ->condition('id', $id, '=')
            ->execute();
    }
}

<?php

namespace Drupal\custom_entity_module\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the custom entity module entity edit forms.
 */
class CustomEntityModuleForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New custom entity module %label has been created.', $message_arguments));
        $this->logger('custom_entity_module')->notice('Created new custom entity module %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The custom entity module %label has been updated.', $message_arguments));
        $this->logger('custom_entity_module')->notice('Updated custom entity module %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.custom_entity_module.canonical', ['custom_entity_module' => $entity->id()]);

    return $result;
  }

}

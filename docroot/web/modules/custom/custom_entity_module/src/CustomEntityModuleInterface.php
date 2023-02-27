<?php

namespace Drupal\custom_entity_module;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a custom entity module entity type.
 */
interface CustomEntityModuleInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

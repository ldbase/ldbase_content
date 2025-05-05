<?php

namespace Drupal\ldbase_content;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;

/**
 * Class LDbaseObjectService.
 */
class LDbaseObjectService implements LDbaseObjectServiceInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new LDbaseObjectService object.
   *
   * @param Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *  The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  public function isUrlAnLdbaseObjectUrl($url) {
    $ldbase_objects_singular = array('project', 'dataset', 'code', 'document');
    $ldbase_objects_plural = array('projects', 'datasets', 'code', 'documents');
    $url_bits = explode('/', $url);
    if (in_array($url_bits[1], $ldbase_objects_plural)) {
      if (array_key_exists("2", $url_bits)) {
        // separate uuid from any query string
        $parts_array = explode('?', $url_bits[2]);
        $uuid = $parts_array[0];
        $object = $this->getLdbaseObjectFromUuid($uuid);
        if (is_null($object) || !in_array($object->bundle(), $ldbase_objects_singular)) {
          $answer = FALSE;
        }
        else {
          $answer = $uuid;
        }
      }
      else {
        $answer = FALSE;
      }
    }
    else {
      $answer = FALSE;
    }
    return $answer;
  }

  public function getLdbaseObjectFromUuid($uuid) {
    $query = $this->entityTypeManager->getStorage('node')
      ->getQuery()
      ->accessCheck(TRUE)
      ->condition('uuid', $uuid)
      ->execute();
    $results = reset($query);
    if (!empty($results)) {
      $node = Node::load($results);
    }
    else {
      $node = NULL;
    }
    return $node;
  }

  public function getLdbaseRootProjectNodeFromLdbaseObjectNid($nid) {
    $entity = $this->entityTypeManager->getStorage('node')->load($nid);
    $bundle = $entity->bundle();
    if ($bundle == 'project') {
      $parent_project_node = Node::load($nid);
    }
    else {
      $parent_nid = $this->getLdbaseObjectParent($nid);
      $parent_project_node = $this->getLdbaseRootProjectNodeFromLdbaseObjectNid($parent_nid);
      //$parent_project_node = node_load($parent_nid);
    }
    return $parent_project_node;
  }

  public function getLdbaseObjectParent($nid) {
    $node = Node::load($nid);
    $affiliated_parents = $node->field_affiliated_parents->getValue();
    $parent_nid = $affiliated_parents[0]['target_id'];
    return $parent_nid;
  }

  public function getBreadcrumbTrailToLdbaseObject($link_data) {
    $entity = $this->entityTypeManager->getStorage('node')->load($link_data[0]['nid']);
    $bundle = $entity->bundle();
    if ($bundle == 'project') {
      return $link_data;
    }
    else {
      $parent_nid = $this->getLdbaseObjectParent($link_data[0]['nid']);
      $node = Node::load($parent_nid);
      array_unshift($link_data, array('title' => $node->getTitle(), 'nid' => $node->id()));
      return $this->getBreadcrumbTrailToLdbaseObject($link_data);
    }
  }

  public function isLdbaseCodebook($uuid) {
    $object = $this->getLdbaseObjectFromUuid($uuid);
    if (is_null($object) || $object->bundle() != 'document') {
      return FALSE;
    }
    else {
      $document_type = $object->get('field_document_type')->target_id;
      $document_type_term = $this->entityTypeManager->getStorage('taxonomy_term')->load($document_type)->getName();
      if ($document_type_term === 'Codebook') {
        return TRUE;
      }
      else {
        return FALSE;
      }
    }
  }

  public function getLDbaseContentType($uuid) {
    $object = $this->getLdbaseObjectFromUuid($uuid);
    if (is_null($object)) {
      return '';
    }
    else {
        if ($this->isLdbaseCodebook($uuid)) {
          return 'Codebook';
        }
        else {
          return ucfirst($object->bundle());
        }
      }
    }

}

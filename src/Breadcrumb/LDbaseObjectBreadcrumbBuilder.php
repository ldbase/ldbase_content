<?php

namespace Drupal\ldbase_content\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\ldbase_content\LDbaseObjectService;

class LDbaseObjectBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The LDbase Object service.
   *
   * @var \Drupal\ldbase_content\LDbaseObjectService
   */
  protected $ldbaseObjectService;

  /**
   * Constructs an LDbase Object Breadcrumb builder
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *  The entity type manager
   * @param \Drupal\ldbase_content\LDbaseObjectService $ldbase_object_service
   *  The LDBase Object Service
   *
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, LDbaseObjectService $ldbase_object_service) {
    $this->entityTypeManager = $entity_type_manager;
    $this->ldbaseObjectService = $ldbase_object_service;
  }

  public function applies(RouteMatchInterface $route_match) {
    $url = \Drupal::request()->getRequestUri();
    $ldbase_object_uuid = $this->ldbaseObjectService->isUrlAnLdbaseObjectUrl($url);
    if ($ldbase_object_uuid) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addCacheContexts(['url.path', 'route']);
    $breadcrumb->addLink(Link::createFromRoute('Home', '<front>'));
    $url = \Drupal::request()->getRequestUri();
    $ldbase_object_uuid = $this->ldbaseObjectService->isUrlAnLdbaseObjectUrl($url);
    $ldbase_object = $this->ldbaseObjectService->getLdbaseObjectFromUuid($ldbase_object_uuid);
    $breadcrumb_trail = $this->ldbaseObjectService->getBreadcrumbTrailToLdbaseObject(array(array('title' => $ldbase_object->getTitle(), 'nid' => $ldbase_object->id())));

    $url_bits_count = count(explode('/', $url));
    if ($url_bits_count <= 3) {
      array_pop($breadcrumb_trail);
    }

    foreach ($breadcrumb_trail as $breadcrumb_link) {
      $entity = $this->entityTypeManager->getStorage('node')->load($breadcrumb_link['nid']);
      $bundle = $this->ldbaseObjectService->isLdbaseCodebook($entity->uuid()) ? 'codebook' : $entity->bundle();
      $formatted_bundle = ucfirst($bundle);
      $formatted_title = "{$formatted_bundle}: {$breadcrumb_link['title']}";
      $breadcrumb->addLink(Link::createFromRoute($formatted_title, 'entity.node.canonical', ['node' => $breadcrumb_link['nid']], ['absolute' => TRUE]));
    }
    return $breadcrumb;
  }
}

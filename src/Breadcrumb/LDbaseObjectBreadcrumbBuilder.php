<?php

namespace Drupal\ldbase_content\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;


class LDbaseObjectBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  public function applies(RouteMatchInterface $route_match) {
    $url = \Drupal::request()->getRequestUri();
    $ldbase_object_uuid = \Drupal::service('ldbase.object_service')->isUrlAnLdbaseObjectUrl($url);
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
    $ldbase_object_uuid = \Drupal::service('ldbase.object_service')->isUrlAnLdbaseObjectUrl($url);
    $ldbase_object = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($ldbase_object_uuid);
    $breadcrumb_trail = \Drupal::service('ldbase.object_service')->getBreadcrumbTrailToLdbaseObject(array(array('title' => $ldbase_object->getTitle(), 'nid' => $ldbase_object->id())));

    $url_bits_count = count(explode('/', $url));
    if ($url_bits_count <= 3) {
      array_pop($breadcrumb_trail);
    }

    foreach ($breadcrumb_trail as $breadcrumb_link) {
      $entity = entity_load('node', $breadcrumb_link['nid']);
      $bundle = \Drupal::service('ldbase.object_service')->isLdbaseCodebook($entity->uuid()) ? 'codebook' : $entity->bundle();
      $formatted_bundle = ucfirst($bundle);
      $formatted_title = "{$formatted_bundle}: {$breadcrumb_link['title']}";
      $breadcrumb->addLink(Link::createFromRoute($formatted_title, 'entity.node.canonical', ['node' => $breadcrumb_link['nid']], ['absolute' => TRUE]));
    }
    return $breadcrumb;
  }
}

<?php

namespace Drupal\ldbase_content\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\taxonomy\Entity\Vocabulary;

class LDbaseTaxonomyBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs an LDbase Object Breadcrumb builder
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *  The entity type manager
   *
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * @inheritDoc
   */
  public function applies(RouteMatchInterface $route_match) {
    $applies_to = ['taxonomy','funding_agencies','participants','code_or_data_format'];
    $url = \Drupal::request()->getRequestUri();
    $url_bits = explode('/', $url);
    if (array_key_exists('1', $url_bits) && in_array($url_bits[1],$applies_to)) {
      $answer = TRUE;
    }
    else {
      $answer = FALSE;
    }
    return $answer;
  }

  /**
   * @inheritDoc
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addCacheContexts(['url.path', 'route']);
    $breadcrumb->addLink(Link::createFromRoute('Home', '<front>'));
    $breadcrumb->addLink(Link::createFromRoute('Browse Data', 'ldbase.browse_data'));

    $url = \Drupal::request()->getRequestUri();
    $url_bits = explode('/', $url);
    if (array_key_exists('3', $url_bits) && is_numeric($url_bits[3])) {
      $term_storage = $this->entityTypeManager->getStorage('taxonomy_term');
      $term = $term_storage->load($url_bits[3]);
      $vid = $term->bundle();
      $vocabulary = Vocabulary::load($vid);
      $vocabulary_name = $vocabulary->label();
      switch ($vid) {
        case 'funding_agencies':
          $view_route = 'view.vocabulary_lists.funding_agencies';
          break;
        case 'participants':
          $view_route = 'view.vocabulary_lists.participants';
          break;
        case 'code_or_data_format':
          $view_route = 'view.vocabulary_lists.code_or_data_format';
          break;
        default:
          $view_route = 'view.vocabulary_lists.page_3';
      }
      $breadcrumb->addLink(Link::createFromRoute($vocabulary_name, $view_route, ['vocabulary' => $vid]));
    }

    return $breadcrumb;
  }

}

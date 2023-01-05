<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * Provides a Sub-tree block.
 *
 * @Block(
 *   id="sub_tree_block",
 *   admin_label = @Translation("LDbase Dataset Sub-tree Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseItemSubTreeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * An entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityManager;

  /**
   * An LDbase object service
   *
   * @var \Drupal\ldbase_content\LDbaseObjectService
   */
  protected $ldbaseObjects;

  /**
   * The request stack
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('ldbase.object_service'),
      $container->get('request_stack')
    );
  }

  /**
   * Constructs an LDbase subtree block
   *
   * @param array $configuration
   *   Block configuration.
   * @param string $plugin_id
   *   The plugin ID.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   An entity type manager.
   * @param \Drupal\ldbase_content\LDbaseObjectService $ldbase_objects
   *   An embargoes management service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   *
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_manager, $ldbase_objects, RequestStack $request_stack) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityManager = $entity_manager;
    $this->ldbaseObjects = $ldbase_objects;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $url = $this->requestStack->getCurrentRequest()->getRequestUri();
    $ldbase_object_uuid = $this->ldbaseObjects->isUrlAnLdbaseObjectUrl($url);

    if ($ldbase_object_uuid) {
      $node = $this->ldbaseObjects->getLdbaseObjectFromUuid($ldbase_object_uuid);
      $item_children = $this->getSubtreeItems($node->id());
      $render = [
        '#theme' => 'ldbase_project_subtree',
        '#subtree_title' => 'Items Connected to this Dataset',
        '#items' => $item_children,
      ];

      return $render;
    }
    else {
      return [];
    }
  }

  public function getSubtreeItems($parent_item_id) {
    $subtree_items = [];

    $datasets_query = $this->entityManager->getStorage('node')->getQuery()
      ->accessCheck(TRUE)
      ->condition('type','dataset')
      ->condition('field_affiliated_parents', $parent_item_id);
    $datasets_result = $datasets_query->execute();
    foreach ($datasets_result as $result) {
      $subtree_item = [];
      $node = $this->entityManager->getStorage('node')->load($result);
      $item_title = 'Dataset: ' . $node->getTitle();
      $item_url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
      $subtree_item['link'] = Link::fromTextAndUrl(t($item_title), $item_url)->toRenderable();
      $subtree_item['description'] = $node->get('body')->value;
      $subtree_item['below'] = $this->getSubtreeItems($node->id());

      $subtree_items[] = $subtree_item;
    }

    $code_query = $this->entityManager->getStorage('node')->getQuery()
      ->accessCheck(TRUE)
      ->condition('type','code')
      ->condition('field_affiliated_parents', $parent_item_id);
    $code_result = $code_query->execute();
    foreach ($code_result as $result) {
      $subtree_item = [];
      $node = $this->entityManager->getStorage('node')->load($result);
      $item_title = 'Code: ' . $node->getTitle();
      $item_url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
      $subtree_item['link'] = Link::fromTextAndUrl(t($item_title), $item_url)->toRenderable();
      $subtree_item['description'] = $node->get('body')->value;
      $subtree_item['below'] = $this->getSubtreeItems($node->id());

      $subtree_items[] = $subtree_item;
    }

    $document_query = $this->entityManager->getStorage('node')->getQuery()
      ->accessCheck(TRUE)
      ->condition('type','document')
      ->condition('field_affiliated_parents', $parent_item_id);
    $document_result = $document_query->execute();
    foreach ($document_result as $result) {
      $subtree_item = [];
      $node = $this->entityManager->getStorage('node')->load($result);
      $doc_type = $this->ldbaseObjects->isLdbaseCodebook($node->uuid()) ? 'Codebook' : 'Document';
      $item_title = $doc_type . ': ' . $node->getTitle();
      $item_url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
      $subtree_item['link'] = Link::fromTextAndUrl(t($item_title), $item_url)->toRenderable();
      $subtree_item['description'] = $node->get('body')->value;
      $subtree_item['below'] = $this->getSubtreeItems($node->id());

      $subtree_items[] = $subtree_item;
    }

    return $subtree_items;
  }

  public function getCacheMaxAge() {
    return 0;
  }

}

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
 * Provides a block for displaying a Projects latest items.
 *
 * @Block(
 *   id = "project_latest_items",
 *   admin_label = @Translation("LDbase Project Latest Items Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseProjectLatestItemsBlock extends BlockBase implements ContainerFactoryPluginInterface {
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
   * Constructs an Latest Items for Project block
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
      $project_node = $this->ldbaseObjects->getLdbaseObjectFromUuid($ldbase_object_uuid);
      if ($project_node->bundle() == 'project'){
        // get project's group
        $project_group_result = $this->entityManager->getStorage('group_content')->loadByEntity($project_node);
        $project_group_content = current($project_group_result);
        $group_id = $project_group_content->getGroup()->id();
        // get all group items (includes members and top project)
        $all_group_contents = $this->entityManager->getStorage('group_content')->loadByProperties(['gid' => $group_id]);
        // create arrays to hold each item type
        $block_data = [];
        $allowed_types = ['dataset','document','code'];
        foreach ($allowed_types as $type) {
          $$type = [];
          $$type['type'] = $type == 'code' ? ucfirst($type) : ucfirst($type) . 's';
          $$type['items'] = [];
        }
        // loop over group contents
        $do_not_use_types = ['group_membership','project','embargo'];
        $nids_to_get = [];
        foreach ($all_group_contents as $group_content) {
          $group_content_type = $group_content->get('type')->target_id;
          $content_type = explode('-', $group_content_type);

          if (!in_array(end($content_type), $do_not_use_types)) {
            $target_id = $group_content->get('entity_id')->target_id;
            // add the id to an array so we can use an entity query with its
            // buit-in access checks
            $nids_to_get[] = $target_id;
          }
        }

        $items_query = $this->entityManager->getStorage('node')->getQuery()
          ->condition('nid', $nids_to_get, 'IN');
        $items_results = $items_query->execute();
        foreach ($items_results as $result) {
          $node = $this->entityManager->getStorage('node')->load($result);
          $node_type = $node->bundle();
          if ($node_type == 'document') {
            $doc_type = $this->ldbaseObjects->isLdbaseCodebook($node->uuid()) ? 'Codebook' : 'Document';
            $item_title = $doc_type . ': ' . $node->getTitle();
          }
          else {
            $item_title = ucfirst($node_type) . ': ' . $node->getTitle();
          }
          $item['title'] = $item_title;
          $item_url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
          $item['link'] = Link::fromTextAndUrl(t($item_title), $item_url)->toRenderable();
          $item['description'] = $node->get('body')->value;
          $item['changed'] = $node->get('changed')->value;
          $$node_type['items'][] = $item;
        }
        // sort each item type by most recent first
        foreach ($allowed_types as $type) {
          usort($$type['items'], function($a, $b) {
            return $b['changed'] <=> $a['changed'];
          });
          $block_data[] = $$type;
        }

        $render = [
          '#theme' => 'ldbase_latest_project_items',
          '#section_prefix' => 'Most Recent',
          '#section_suffix' => 'in Project',
          '#block_data' => $block_data,
        ];
        return $render;
      }
      else {
        return [];
      }
    }
    else {
      return [];
    }
  }

  public function getCacheMaxAge() {
    return 0;
  }
}

<?php

namespace Drupal\ldbase_content\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\ldbase_content\LDbaseObjectService;
use Drupal\ldbase_handlers\PublishStatusService;

class ProjectHierarchyOrderForm extends FormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   *  The LDbase object service,
   * @var \Drupal\ldbase_content\LDbaseObjectService
   */
  protected $ldbase_service;

  /**
   * The renderer.
   * @var \Drupal\Core\RendererInterface;
   */
  protected $renderer;

  /**
   * The LDbase Handlers Publish Status Service.
   * @var \Drupal\ldbase_handlers\PublishStatusService
   */
  protected $publish_status_service;

  /**
   * @inerhitDoc
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('ldbase.object_service'),
      $container->get('renderer'),
      $container->get('ldbase_handlers.publish_status_service')
    );
  }

  /**
   * Construct a Form.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, LDbaseObjectService $ldbase_service, RendererInterface $renderer, PublishStatusService $publish_status_service) {
    $this->entityTypeManager = $entityTypeManager;
    $this->ldbase_service = $ldbase_service;
    $this->renderer = $renderer;
    $this->publish_status_service = $publish_status_service;
  }

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'project_hierarchy_order_form';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $url = $this->getRequest()->getRequestUri();
    $project_uuid = $this->ldbase_service->isUrlAnLdbaseObjectUrl($url);

    $project_node = $this->ldbase_service->getLdbaseObjectFromUuid($project_uuid);

    $results = $this->getData($project_uuid);

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t("Use this form to rearrange the parts of your project."),
    ];

    $form['info'] = [
      '#markup' => '<ul>
        <li>' . $this->t("Your project title is displayed but cannot be nested under other content.") . '</li>
        <li>' . $this->t("Drag-and-drop items to change their positions.") . '</li>
        <li>' . $this->t("Indentations indicate that the content is nested. If all of your content is lined up on the left, then everything is stored under the project.") . '</li>
        <li>' . $this->t("Nesting <span class='published'>Published</span> items under an <span class='unpublished'>Unpublished</span> item will automatically <strong>unpublish</strong> those nested items when you save your changes.") . '</li></ul>',
    ];

    $form['project-nid'] = [
      '#type' => 'hidden',
      '#value' => $project_node->id(),
    ];

    $form['table-row'] = [
      '#type' => 'table',
      '#header' => [
        'Project: '.$this->t($project_node->getTitle()),
        $this->t('Weight'),
        $this->t('Parent'),
      ],
      '#empty' => $this->t('Once you add Datasets, Documents, and Code to this project, you will be able to sort them here.'),
      // TableDrag: Each array value is a list of callback arguments for
      // drupal_add_tabledrag(). The #id of the table is automatically
      // prepended; if there is none, an HTML ID is auto-generated.
      '#tabledrag' => [
        [
          'action' => 'match',
          'relationship' => 'parent',
          'group' => 'row-pid',
          'source' => 'row-id',
          'hidden' => TRUE, /* hides the WEIGHT & PARENT tree columns below */
          'limit' => FALSE,
        ],
        [
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'row-weight',
        ],
      ],
    ];

    foreach ($results as $row) {
      // mark the table tow as draggable
      $form['table-row'][$row['id']]['#attributes']['class'][] = 'draggable';
      // parent project may not be nested
      if ($row['pid'] == 0) {
        $form['table-row'][$row['id']]['#attributes']['class'] = 'tabledrag-root';
      }
      // TableDrag: Sort the table row according to its existing/configured
      // weight.
      $form['table-row'][$row['id']]['#weight'] = $row->weight;

      // Indent item on load.
      if (isset($row['depth']) && $row['depth'] > 0) {
        $indentation = [
          '#theme' => 'indentation',
          '#size' => $row['depth'],
        ];
      }

      // Some table columns containing raw markup.

      $form['table-row'][$row['id']]['name'] = [
        '#markup' => '<span class=' . $row['status'] .'>' . ucfirst($row['status']) . '</span>' . ' ' .  $row['bundle'] . ': ' .  $row['name'],
        '#prefix' => !empty($indentation) ? $this->renderer->render($indentation) : '',
        '#attributes' => [
          'class' => ['row-weight'],
        ],
      ];

      // This is hidden from #tabledrag array (above).
      // TableDrag: Weight column element.
      $form['table-row'][$row['id']]['weight'] = [
        '#type' => 'weight',
        '#title' => $this->t('Weight for ID @id', ['@id' => $row['id']]),
        '#title_display' => 'invisible',
        '#default_value' => $row['weight'],
        // Classify the weight element for #tabledrag.
        '#attributes' => [
          'class' => ['row-weight'],
        ],
      ];
      $form['table-row'][$row['id']]['parent']['id'] = [
        '#parents' => ['table-row', $row['id'], 'id'],
        '#type' => 'hidden',
        '#value' => $row['id'],
        '#attributes' => [
          'class' => ['row-id'],
        ],
      ];
      $form['table-row'][$row['id']]['parent']['pid'] = [
        '#parents' => ['table-row', $row['id'], 'pid'],
        '#type' => 'number',
        '#size' => 3,
        '#min' => 0,
        '#title' => $this->t('Parent ID'),
        '#default_value' => $row['pid'],
        '#attributes' => [
          'class' => ['row-pid'],
        ],
      ];
    }
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save All Changes'),
    ];
//dd($form);
    return $form;
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Because the form elements were keyed with the item ids from the database,
    // we can simply iterate through the submitted values.
    $submissions = $form_state->getValue('table-row');
    foreach ($submissions as $id => $item) {
      $node = $this->entityTypeManager->getStorage('node')->load($id);
      $node->set('field_hierarchy_weight', $item['weight']);
      $node->set('field_affiliated_parents', $item['pid']);
      $node->save();
    }
    // now that the hierarchy is saved, loop over it again to check for published items nested underunpublished ones
    foreach ($submissions as $id =>$item) {
      $node = $this->entityTypeManager->getStorage('node')->load($id);
      // unpublish all children of unpublished nodes to be safe
      if (!$node->isPublished()) {
        $unpublished_children = $this->publish_status_service->unpublishChildNodes($node->id());
        if ($unpublished_children) {
          $text = count($unpublished_children) > 1 ? 'nodes' : 'node';
          $this->messenger()
            ->addStatus($this->t('%count child %text also unpublished.', ['%count' => count($unpublished_children), '%text' => $text]));
        }
      }
    }

    $project_nid = $form_state->getValue('project-nid');
    $route_name = 'entity.node.canonical';
    $route_parameters = ['node' => $project_nid];
    $form_state->setRedirect($route_name, $route_parameters);
  }

  /**
   * Gets the project hierarchy.
   *
   * returns associative array
   */
  public function getData($project_uuid) {
    $project_node = $this->ldbase_service->getLdbaseObjectFromUuid($project_uuid);
    $root_project = $this->ldbase_service->getLdbaseRootProjectNodeFromLdbaseObjectNid($project_node->id());

    // Initialize a variable to store our ordered tree structure.
    $tree = [];

    // Depth will be incremented in our getTree()
    // function for the first parent item, so we start it at -1.
    //$depth = -1;
    $depth = -2;
    $this->getTree($root_project, $tree, $depth);

    return $tree;
  }

  /**
   * Recursively adds $item to $item_tree, ordered by parent/child/weight.
   *
   * @param mixed $item
   *   The item.
   * @param array $tree
   *   The item tree.
   * @param int $depth
   *   The depth of the item.
   */
  public function getTree($item, array &$tree = [], &$depth = 0) {
    // Increase our $depth value by one.
    $depth++;

    // Set the current tree 'depth' for this item, used to calculate
    // indentation.
    $item->depth = $depth;

    $item_array = [
      'id' => $item->id(),
      'status' => $item->isPublished() ? 'published' : 'unpublished',
      'bundle' => $this->ldbase_service->getLDbaseContentType($item->uuid()),
      'name' => $item->getTitle(),
      'weight' => $item->hasField('field_hierarchy_weight') ? $item->get('field_hierarchy_weight')->value : 0,
      'pid' => $item->hasField('field_affiliated_parents') ?$item->get('field_affiliated_parents')->target_id : 0,
      'depth' => $item->depth,
    ];
    // Add the item to the tree.
    //$tree[$item->id()] = $item_array;
    if ($item_array['pid'] != 0) {
      $tree[$item->id()] = $item_array;
    }

    // Retrieve each of the children belonging to this nested demo.
    $node_storage = $this->entityTypeManager->getStorage('node');
    $children_query_results = $node_storage
      ->getQuery()
      ->accessCheck(TRUE)
      ->condition('field_affiliated_parents', $item->id())
      ->sort('field_hierarchy_weight')
      ->execute();

    $children = $node_storage->loadMultiple($children_query_results);


    foreach ($children as $child) {
      // Make sure this child does not already exist in the tree, to
      // avoid loops.
      if (!in_array($child->id(), array_keys($tree))) {
        // Add this child's tree to the $tree array.
        $this->getTree($child, $tree, $depth);
      }
    }

    // Finished processing this tree branch.  Decrease our $depth value by one
    // to represent moving to the next branch.
    $depth--;
  }


}

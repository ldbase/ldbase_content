<?php

namespace Drupal\ldbase_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Drupal\Core\Render\Markup;

/**
 * Controller routines for page example routes.
 */
class LDbaseProjectTreeController extends ControllerBase {

  public static function output_tree($project_uuid, $current_uuid = NULL) {
    if ($current_uuid) {
      $current_object = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($current_uuid);
      $current_object_id = $current_object->id();
    }
    else {
      $current_object_id = FALSE;
    }

    $project_node = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($project_uuid);
    $project = \Drupal::service('ldbase.object_service')->getLdbaseRootProjectNodeFromLdbaseObjectNid($project_node->id());
    $current_object_class = ($project->id() == $current_object_id ? ' project-tree-view-item-current' : '');

    $tree = "<div id='project-tree-view-wrapper' class='project-tree-view'><ul id='project-tree-view-list-root' class='project-tree-view'><li class='project-tree-view project-tree-view-root-item project-tree-view-item-link{$current_object_class}'><a href='/projects/{$project->uuid()}'>Project: {$project->getTitle()}</a>";

    $tree .= \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsHtmlList($project->id(), $current_object_id);

    $tree .= "</li></ul></div>";

    return $tree;
  }

  public static function getAffiliatedChildrenAsHtmlList($parent_project_id, $current_object_id = NULL) {
    // only add surrounding ul if results are found
    $add_ul = false;

    $list = "";

    $children_query = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('field_affiliated_parents', $parent_project_id)
      ->sort('field_hierarchy_weight');
    $children_results = $children_query->execute();

    foreach ($children_results as $result) {
      $add_ul = true;
      $node = Node::load($result);
      $current_object_class = ($node->id() == $current_object_id ? ' project-tree-view-item-current' : '');
      $bundle_for_link = \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getBundleForLink($node->bundle());
      if ($node->bundle() == 'document') {
        $formatted_bundle = \Drupal::service('ldbase.object_service')->isLdbaseCodebook($node->uuid()) ? 'Codebook' : 'Document';
      }
      else {
        $formatted_bundle = ucfirst($node->bundle());
      }

      $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-link{$current_object_class}'><a href='/{$bundle_for_link}/{$node->uuid()}'>{$formatted_bundle}: {$node->getTitle()}</a>";
      $list .= \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsHtmlList($node->id(), $current_object_id);
      $list .= "</li>";
    }

    if ($add_ul) {
      $list = "<ul class='project-tree-view project-tree-view-list'>" . $list . "</ul>";
    }
    else {
      $list = "";
    }

    return $list;
  }

  public static function output_select_options($project_node, $current_node = NULL) {
    $options[$project_node->id()] = ucfirst($project_node->bundle()) . ': ' . $project_node->getTitle();
    $children = \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsOptionArray($project_node->id(), $current_node->id());
    foreach ($children as $key => $value) {
      $options[$key] = $value;
    }
    return $options;
  }

  public static function getAffiliatedChildrenAsOptionArray($parent_project_id, $current_object_id = NULL, $option_prefix = NULL) {
    $options = [];
    // indent for select options
    $option_prefix = empty($option_prefix) ? '--' : $option_prefix . '--';

    $datasets_query = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('type','dataset')
      ->condition('field_affiliated_parents', $parent_project_id);
    $datasets_result = $datasets_query->execute();
    foreach ($datasets_result as $result) {
      $node = Node::load($result);
      // do not add self or children to options to prevent from becoming your own grandpa
      if ($node->id() != $current_object_id) {
        $options[$node->id()] = $option_prefix . ucfirst($node->bundle()) . ': ' . $node->getTitle();
        $child_options = \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsOptionArray($node->id(), $current_object_id, $option_prefix);
        foreach ($child_options as $key => $value) {
          $options[$key] = $value;
        }
      }
    }

    $code_query = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('type','code')
      ->condition('field_affiliated_parents', $parent_project_id);
    $code_result = $code_query->execute();
    foreach ($code_result as $result) {
      $node = Node::load($result);
      // do not add self or children to options to prevent from becoming your own grandpa
      if ($node->id() != $current_object_id) {
        $options[$node->id()] = $option_prefix . ucfirst($node->bundle()) . ': ' . $node->getTitle();
        $child_options = \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsOptionArray($node->id(), $current_object_id, $option_prefix);
        foreach ($child_options as $key => $value) {
          $options[$key] = $value;
        }
      }
    }


    $documents_query = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('type','document')
      ->condition('field_affiliated_parents', $parent_project_id);
    $documents_result = $documents_query->execute();
    foreach ($documents_result as $result) {
      $node = Node::load($result);
      // do not add self or children to options to prevent from becoming your own grandpa
      if ($node->id() != $current_object_id) {
        $doc_type = \Drupal::service('ldbase.object_service')->isLdbaseCodebook($node->uuid()) ? 'Codebook' : 'Document';
        $options[$node->id()] = $option_prefix . $doc_type . ': ' . $node->getTitle();
        $child_options = \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsOptionArray($node->id(), $current_object_id, $option_prefix);
        foreach ($child_options as $key => $value) {
          $options[$key] = $value;
        }
      }
    }

    return $options;
  }

  public static function getBundleForLink($bundle) {

    switch ($bundle) {
      case 'dataset':
        $return_text = 'datasets';
        break;
      case 'document':
        $return_text = 'documents';
        break;
      case 'code':
        $return_text = 'code';
        break;
    }
    return $return_text;
  }

}

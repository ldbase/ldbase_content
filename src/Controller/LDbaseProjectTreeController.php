<?php

namespace Drupal\ldbase_content\Controller;

use Drupal\Core\Controller\ControllerBase;
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

    return [
      '#markup' => Markup::create($tree)
    ];
  }

  public static function getAffiliatedChildrenAsHtmlList($parent_project_id, $current_object_id = NULL) {

    $list = "<ul class='project-tree-view project-tree-view-list'>";

    $datasets_query = \Drupal::entityQuery('node')
      ->condition('type','dataset')
      ->condition('field_affiliated_parents', $parent_project_id);
    $datasets_result = $datasets_query->execute();
    foreach ($datasets_result as $result) {
      $node = node_load($result);
      $current_object_class = ($node->id() == $current_object_id ? ' project-tree-view-item-current' : '');
      $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-link{$current_object_class}'><a href='/datasets/{$node->uuid()}'>Dataset: {$node->getTitle()}</a>";
      $list .= \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsHtmlList($node->id(), $current_object_id);
      $list .= "</li>";
    }

    $code_query = \Drupal::entityQuery('node')
      ->condition('type','code')
      ->condition('field_affiliated_parents', $parent_project_id);
    $code_result = $code_query->execute();
    foreach ($code_result as $result) {
      $node = node_load($result);
      $current_object_class = ($node->id() == $current_object_id ? ' project-tree-view-item-current' : '');
      $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-link{$current_object_class}'><a href='/code/{$node->uuid()}'>Code: {$node->getTitle()}</a>";
      $list .= \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsHtmlList($node->id(), $current_object_id);
      $list .= "</li>";
    }


    $documents_query = \Drupal::entityQuery('node')
      ->condition('type','document')
      ->condition('field_affiliated_parents', $parent_project_id);
    $documents_result = $documents_query->execute();
    foreach ($documents_result as $result) {
      $node = node_load($result);
      $current_object_class = ($node->id() == $current_object_id ? ' project-tree-view-item-current' : '');
      $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-link{$current_object_class}'><a href='/documents/{$node->uuid()}'>Document: {$node->getTitle()}</a>";
      $list .= \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::getAffiliatedChildrenAsHtmlList($node->id(), $current_object_id);
      $list .= "</li>";
    }

    $list .= "</ul>";

    return $list;
  }

}

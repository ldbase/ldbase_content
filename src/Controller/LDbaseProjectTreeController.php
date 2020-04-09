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


  public function output_tree($project_uuid) {

    $project = $this->getProjectByUuid($project_uuid);

    $tree = "<div id='project-tree-view-wrapper' class='project-tree-view'><ul id='project-tree-view-list-root' class='project-tree-view'><li id='project-tree-view-root-item project-tree-view-item-link' class='project-tree-view'><a href='/projects/{$project->uuid()}'>{$project->getTitle()}<a/>";

    $tree .= $this->getAffiliatedChildrenAsHtmlList($project->id());

    $tree .= "</li></ul></div>";

    return [
      '#markup' => Markup::create($tree)
    ];
  }

  public function getAffiliatedChildrenAsHtmlList($id) {

    $list = "<ul class='project-tree-view project-tree-view-list'>";

    $datasets_query = \Drupal::entityQuery('node')
      ->condition('type','dataset')
      ->condition('field_affiliated_parents', $id);
    $datasets_result = $datasets_query->execute();
    if (count($datasets_result) > 0) {
      $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-category'>Datasets<ul class='project-tree-view project-tree-view-list'>";
      foreach ($datasets_result as $result) {
        $node = node_load($result);
        $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-link'><a href='/datasets/{$node->uuid()}'>{$node->getTitle()}</a>";
        $list .= $this->getAffiliatedChildrenAsHtmlList($node->id());
        $list .= "</li>";
      }
      $list .= "</li></ul>";
    }

    $code_query = \Drupal::entityQuery('node')
      ->condition('type','code')
      ->condition('field_affiliated_parents', $id);
    $code_result = $code_query->execute();
    if (count($code_result) > 0) {
      $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-category'>Code<ul class='project-tree-view project-tree-view-list'>";
      foreach ($code_result as $result) {
        $node = node_load($result);
        $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-link'><a href='/code/{$node->uuid()}'>{$node->getTitle()}</a>";
        $list .= $this->getAffiliatedChildrenAsHtmlList($node->id());
        $list .= "</li>";
      }
      $list .= "</li></ul>";
    }


    $documents_query = \Drupal::entityQuery('node')
      ->condition('type','document')
      ->condition('field_affiliated_parents', $id);
    $documents_result = $documents_query->execute();
    if (count($documents_result) > 0) {
      $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-category'>Documents<ul class='project-tree-view project-tree-view-list'>";
      foreach ($documents_result as $result) {
        $node = node_load($result);
        $list .= "<li class='project-tree-view project-tree-view-item project-tree-view-item-link'><a href='/documents/{$node->uuid()}'>{$node->getTitle()}</a>";
        $list .= $this->getAffiliatedChildrenAsHtmlList($node->id());
        $list .= "</li>";
      }
      $list .= "</li></ul>";
    }

    $list .= "</ul>";

    return $list;
  }

  public function getProjectByUuid($uuid) {
    $query = \Drupal::entityQuery('node')
      ->condition('type','project')
      ->condition('uuid', $uuid);
    $result = $query->execute();
    $node = node_load($result[1]);
    return $node;
  }

}

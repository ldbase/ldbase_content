<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides a "Node Analytics" block.
 *
 * @Block(
 *   id="node_analytics_block",
 *   admin_label = @Translation("Node Analytics Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class NodeAnalyticsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $matomo_enabled = \Drupal::service('module_handler')->moduleExists('matomo');
    if (!$matomo_enabled) {
      $content = 'Matomo not enabled';
    }
    else if ($matomo_enabled) {
      $matomo_config = \Drupal::config('matomo.settings');
      $matomo_url = $matomo_config->get('url_http');
      $matomo_id = $matomo_config->get('site_id');
      if ($matomo_url == '' || $matomo_id == '') {
        $content = 'Matomo not configured';
      }
      else {
        $nid = \Drupal::routeMatch()->getParameter('node')->id();
        $request_url = $matomo_url . "index.php?module=API&method=LDbaseReports.getNodeUsage&idSite={$matomo_id}&idNode={$nid}";
        $response = simplexml_load_string(file_get_contents($request_url));
        $views = (int) $response->row->views; 
        $downloads = (int) $response->row->downloads; 
        if ($views > 0) {
          $views_row = <<<EOS
<span id='node_analytics_block_views' class='node_analytics_block node_analytics_block_row'>
<span id='node_analytics_block_views_label' class='node_analytics_block node_analytics_block_label'><strong>Views:</strong> 
<span id='node_analytics_block_views_value' class='node_analytics_block node_analytics_block_value'>{$views}</span> 
</span><br>
EOS;
        }
        else {
          $views_row = '';
        }
        if ($downloads > 0) {
          $downloads_row = <<<EOS
<span id='node_analytics_block_downloads' class='node_analytics_block node_analytics_block_row'>
<span id='node_analytics_block_downloads_label' class='node_analytics_block node_analytics_block_label'><strong>Downloads:</strong> 
<span id='node_analytics_block_downloads_value' class='node_analytics_block node_analytics_block_value'>{$downloads}</span> 
</span><br>
EOS;
        }
        else {
          $downloads_row = '';
        }
        $content = "<div id='node_analytics_block_wrapper' class='node_analtyics_block'><br>";
        $content .= $views_row;
        $content .= $downloads_row;
        $content .= "</div>";
      }
    }
    return [
      '#markup' => Markup::create($content),
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }

}

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
        $node = \Drupal::routeMatch()->getParameter('node');
        $ctype = $node->getType();
        $nid = $node->id();
        $current_date = date('Y-m-d', time());
        $date_range = "1992-01-01,{$current_date}";
        $matomo_url = str_replace(':9999', '', $matomo_url);

        $request_url = $matomo_url . "index.php?module=API&method=Actions.get&idSite={$matomo_id}&period=range&date={$date_range}&format=xml&segment=customVariablePageValue1=={$nid}";
        $response = simplexml_load_string(file_get_contents($request_url));
        $pageviews = (int) $response->nb_pageviews;
        $downloads = (int) $response->nb_downloads;

        if ($pageviews > 0) {
          $pageviews_row = <<<EOS
<span id='node_analytics_block_pageviews' class='node_analytics_block node_analytics_block_row'>
<span id='node_analytics_block_pageviews_label' class='node_analytics_block node_analytics_block_label'><strong>Page Views:</strong> 
<span id='node_analytics_block_pageviews_value' class='node_analytics_block node_analytics_block_value'>{$pageviews}</span> 
</span><br>
EOS;
        }
        else {
          $pageviews_row = '';
        }

        $downloadable_ctypes = ['dataset', 'code', 'document'];
        if ($downloads > 0 && in_array($ctype, $downloadable_ctypes)) {
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
        $content .= $pageviews_row;
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

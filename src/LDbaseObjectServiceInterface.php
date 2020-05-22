<?php

namespace Drupal\ldbase_content;

/**
 * Interface LDbaseObjectServiceInterface.
 */
interface LDbaseObjectServiceInterface {

  public function isUrlAnLdbaseObjectUrl($url);
  public function getLdbaseObjectFromUuid($uuid);
  public function getLdbaseRootProjectNodeFromLdbaseObjectNid($nid);
  public function getLdbaseObjectParent($nid);


}

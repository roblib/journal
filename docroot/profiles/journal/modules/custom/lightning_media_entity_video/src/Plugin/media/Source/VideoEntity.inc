<?php

namespace Drupal\lightning_media_image\Plugin\media\Source;

use Drupal\lightning_media\FileInputExtensionMatchTrait;
use Drupal\lightning_media\InputMatchInterface;
use Drupal\media\Plugin\media\Source\VideoFile as BaseVideo;
use Drupal\media\MediaTypeInterface;

/**
 * Input-matching version of the Video Entity media source.
 */
class VideoEntity extends BaseVideo implements InputMatchInterface {

  use FileInputExtensionMatchTrait;

  /**
   * Checks if this media type can handle a given input value.
   *
   * @param mixed $value
   *   The input value.
   * @param \Drupal\media\MediaTypeInterface $bundle
   *   The media bundle that is using this plugin.
   *
   * @return bool
   *   TRUE if the input can be handled by this plugin, FALSE otherwise.
   */
  public function appliesTo($value, MediaTypeInterface $bundle) {
    return TRUE;
  }

}

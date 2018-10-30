<?php

namespace Drupal\journal_types;

use Drupal\bibcite_entity\Entity\Contributor;

class CitationTools {
  /**
   * Get citation metadata from an Article eneity type.
   * @return array The Article metadata.
   */
  public function getCitationMetadataForArticle($article_entity) {
    $data = [];
    $data['bibcite_type_of_work'] = 'Journal article';
    $data['title'] = $article_entity->get('title')->getValue();
    $issue_entity_item = $article_entity->get('field_article_issue')->first();

    $affiliations = $article_entity->get('field_authors_and_affiliations')->referencedEntities();
    $contributors = [];
    foreach($affiliations as $affiliation) {
      $contributors += $affiliation->get('field_affiliation_contributor')->getValue();
    }
    $bibcite_contributors = [];
    foreach($contributors as $contributor) {
      $data['author'][] = Contributor::create([
        'first_name' => $contributor['given'],
        'last_name' => $contributor['family'],
        'middle_name' => $contributor['middle'],

      ]);

    }


    if (!empty($issue_entity_item)) {
      $data['issue_entity_id'] = $issue_entity_item->get('target_id')->getValue();
    }

    if (!empty($data['issue_entity_id'])) {
      $data['issue_entity'] = $this->entityTypeManager->getStorage('node')
        ->load($data['issue_entity_id']);

      $data += $this->getCitationMetadataForIssue($data['issue_entity']);
    }
    return $data;
  }

  /**
   * Get citation metadata from a Issue eneity type.
   * @return array The Issue metadata.
   */
  public function getCitationMetadataForIssue($issue_entity) {
    $data = [];
    $data['bibcite_number'] = $issue_entity->get('field_issue_number')->getValue();
    $data['bibcite_year'] = $issue_entity->get('field_issue_year')->getValue();
    $volume_item = $issue_entity->get('field_issue_volume')->first();
    if (!empty($volume_item)) {
      $data['volume_entity_id'] = $volume_item->get('target_id')->getValue();
    }

    if (!empty($data['volume_entity_id'])) {

      $data['volume_entity'] = $this->entityTypeManager->getStorage('node')
        ->load($data['volume_entity_id']);
      $data += $this->getCitationMetadataForVolume($data['volume_entity']);
    }
    return $data;
  }

  /**
   * Get citation metadata from a Volume eneity type.
   * @return array The Volume metadata.
   */
  public function getCitationMetadataForVolume($volume_entity) {
    $data = [];
    $data['bibcite_volume'] = $volume_entity->get('title')->getValue();
    $journal_item = $volume_entity->get('field_parent_journal')->first();
    if (!empty($journal_item)) {
      $data['journal_entity_id'] = $journal_item->get('target_id')->getValue();
    }
    if (!empty($data['journal_entity_id'])) {
      $data['journal_entity'] = $this->entityTypeManager->getStorage('node')
        ->load($data['journal_entity_id']);
      $data += $this->getCitationMetadataForJournal($data['journal_entity']);

    }

    return $data;
  }

  /**
   * Get citation metadata from a Journal eneity type.
   * @return array The Journal metadata.
   */
  public function getCitationMetadataForJournal($journal_entity) {
    $data = [];
    $data['bibcite_secondary_title'] = $journal_entity->get('title')->getValue();
    return $data;
  }

  public function getRe

  /**
   * CitationTools constructor.
   *
   * @TODO make this a proper dependency injection.
   * @param $entity_type_manager
   */
  public function __construct($entity_type_manager = FALSE) {
    $this->entityTypeManager = $entity_type_manager ? $entity_type_manager : \Drupal::entityTypeManager();
  }
}
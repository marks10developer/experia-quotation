<?php
/**
 * Implements hook_views_data_alter().
 */
function views_row_selector_views_data_alter(&$data) {
  $data['views']['views_row_selector'] = array(
    'title' => t('Row Selector'),
    'help' => t('Provide a checkbox to select the rows'),
    'field' => array(
      'handler' => 'views_row_selector_field_handler_row_selector',
      'click sortable' => FALSE,
    ),
  );
}
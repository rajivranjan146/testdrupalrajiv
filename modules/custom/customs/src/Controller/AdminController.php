<?php
/**
@file

 */

namespace Drupal\customs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\customs\CustomsStorage;

class AdminController extends ControllerBase {

function contentOriginal() {
  $url = Url::fromRoute('customs_add');
  //$add_link = ;
  $add_link = '<p>' . \Drupal::l(t('New Custom2 content'), $url) . '</p>';

  // Table header
  $header = array( 'id' => t('Id'), 'title' => t('Title'), 'description' => t('Description'), 'start_date' => t('Start date'), 'end_date' => t('End date'), 'venue' => t('venue date'), 'operations' => t('Delete'), );

  $rows = array();
  foreach(CustomsStorage::getAll() as $id=>$content) {
    // Row with attributes on the row and some of its cells.
    $rows[] = array( 'data' => array($id, $content->title, $content->description, $content->start_date, $content->end_date, $content->venue, l('Delete', "admin/content/customs/delete/$id")) );
   }

   $table = array( '#type' => 'table', '#header' => $header, '#rows' => $rows, '#attributes' => array( 'id' => 'customs-table', ), );
   return $add_link . drupal_render($table);
 }


  function content() {
    $url = Url::fromRoute('customs_add');
    //$add_link = ;
    $add_link = '<p>' . \Drupal::l(t('New Custom2 content'), $url) . '</p>';

    $text = array(
      '#type' => 'markup',
      '#markup' => $add_link,
    );

    // Table header.
    $header = array(
      'id' => t('Id'),
      'title' => t('Title'),
      'description' => t('description'),
      'start_date' => t('start_date'),
      'end_date' => t('end_date'),
      'venue' => t('venue'),
      'operations' => t('Operations'),
    );
    $rows = array();
    foreach (CustomsStorage::getAll() as $id => $content) {
     
      $editUrl = Url::fromRoute('customs_edit', array('id' => $id));
      $deleteUrl = Url::fromRoute('customs_delete', array('id' => $id));

      $rows[] = array(
        'data' => array(
          \Drupal::l($id, $editUrl),
          $content->title,
          $content->description,
          $content->start_date,
          $content->end_date,
          $content->venue,
          \Drupal::l('Edit', $editUrl) , \Drupal::l('Delete', $deleteUrl)
        ),
      );
    }
    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'customs-table',
      ),
    );
    //return $add_link . ($table);
    return array(
      $text,
      $table,
    );
  }
}

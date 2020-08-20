<?php

namespace Drupal\customs;

class CustomsStorage {

  static function getAll() {
    $result = db_query('SELECT * FROM {customs}')->fetchAllAssoc('id');
    return $result;
  }

  static function exists($id) {
    return (bool) $this->get($id);
  }

  static function get($id) {
    $result = db_query('SELECT * FROM {customs} WHERE id = :id', array(':id' => $id))->fetchAllAssoc('id');
    if ($result) {
      return $result[$id];
    }
    else {
      return FALSE;
    }
  }

  static function add($title, $description, $start_date, $end_date, $venue) {
    db_insert('customs')->fields(array(
      'title' => $title,
      'description' => $description,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'venue' => $venue,
    ))->execute();
  }

  static function edit($id, $title, $description, $start_date, $end_date, $venue) {
    db_update('customs')->fields(array(
      'title' => $title,
      'description' => $description,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'venue' => $venue,
    ))
    ->condition('id', $id)
    ->execute();
  }
  
  static function delete($id) {
    db_delete('customs')->condition('id', $id)->execute();
  }
}

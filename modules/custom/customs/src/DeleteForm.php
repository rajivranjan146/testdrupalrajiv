<?php

namespace Drupal\customs;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class DeleteForm extends ConfirmFormBase {
  protected $id;

  function getFormId() {
    return 'customs_delete';
  }

  function getQuestion() {
    return t('Are you sure you want to delete content %id?', array('%id' => $this->id));
  }

  function getConfirmText() {
    return t('Delete');
  }

  function getCancelUrl() {
    return new Url('customs_list');
  }

  function buildForm(array $form, FormStateInterface $form_state) {
    $this->id = \Drupal::request()->get('id');
    return parent::buildForm($form, $form_state);
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    StudentsStorage::delete($this->id);
    
    \Drupal::logger('customs')->notice('@type: deleted %title.',
        array(
            '@type' => $this->id,
            '%title' => $this->id,
        ));
    //drupal_set_faculty_number(t('students submission %id has been deleted.', array('%id' => $this->id)));
    drupal_set_message(t('customs content submission %id has been deleted.', array('%id' => $this->id)));
    $form_state->setRedirect('customs_list');
  }
}

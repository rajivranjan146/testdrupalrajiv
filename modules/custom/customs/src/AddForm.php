<?php
/**
 * @file
 * Contains \Drupal\customs\AddForm.
 */

namespace Drupal\customs;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\SafeMarkup;


class AddForm extends FormBase {
  protected $id;

  function getFormId() {
    return 'customs_add';
  }

  function buildForm(array $form, FormStateInterface $form_state) {
    $this->id = \Drupal::request()->get('id');
    $customs = CustomsStorage::get($this->id);

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#required' => 'true',
      '#default_value' => ($customs) ? $customs->title : '',
    );

    $form['description'] = array(
      '#type' => 'textfield',
      '#title' => t('Description'),
      '#required' => 'true',
      '#default_value' => ($customs) ? $customs->description : '',
    );

    $form['start_date'] = array(
      '#type' => 'date',
      '#title' => t('Start Date'),
      '#required' => 'true',
      '#default_value' => ($customs) ? $customs->start_date : '',
    );

    $form['end_date'] = array(
      '#type' => 'date',
      '#title' => t('End Date'),
      '#required' => 'true',
      '#default_value' => ($customs) ? $customs->end_date : '',
    );


    
    $form['venue'] = array(
      '#type' => 'textfield',
      '#title' => t('venue'),
      '#required' => 'true',
      '#default_value' => ($customs) ? $customs->venue : '',
    );


    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => ($customs) ? t('Edit') : t('Add'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
		/*Form validation rules here...*/

  }


  function submitForm(array &$form, FormStateInterface $form_state) {
    
    $title = $form_state->getValue('title');
		$description = $form_state->getValue('description');
    $start_date = $form_state->getValue('start_date');
    $end_date = $form_state->getValue('end_date');
    $venue = $form_state->getValue('venue');

    if (!empty($this->id)) {
      CustomsStorage::edit($this->id, SafeMarkup::checkPlain($title), SafeMarkup::checkPlain($description), SafeMarkup::checkPlain($start_date), SafeMarkup::checkPlain($end_date), SafeMarkup::checkPlain($venue));
      \Drupal::logger('customs')->notice('@type: deleted %title.',
          array(
              '@type' => $this->id,
              '%title' => $this->id,
          ));

      
      drupal_set_message(t('Content has been updated.'), 'status');

    }
    else {

      CustomsStorage::add(SafeMarkup::checkPlain($title), SafeMarkup::checkPlain($description), SafeMarkup::checkPlain($start_date), SafeMarkup::checkPlain($end_date), SafeMarkup::checkPlain($venue));
      \Drupal::logger('customs')->notice('@type: deleted %title.',
          array(
              '@type' => $this->id,
              '%title' => $this->id,
          ));

      
      drupal_set_message(t('Content has been submitted.'), 'status');
    }
    $form_state->setRedirect('customs_list');
    return;
  }
}

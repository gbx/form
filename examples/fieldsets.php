<?php 

/**
 * Multiple fieldsets
 */

require('../../toolkit/bootstrap.php');
require('../bootstrap.php');

$fields = array(
  'address' => array(
    'type'   => 'fieldset',
    'legend' => 'Address',
    'fields' => array(
      'name' => array(
        'label' => 'Name',
        'type'  => 'text'
      ),
      'street' => array(
        'label' => 'Street',
        'type'  => 'text'
      ),
      'zip' => array(
        'label' => 'ZIP',
        'type'  => 'text'
      ),
      'location' => array(
        'label' => 'Locality',
        'type'  => 'text'
      )
    )
  ),
  'contact' => array(
    'type'   => 'fieldset',
    'legend' => 'Contact details',
    'fields' => array(
      'phone' => array(
        'label' => 'Phone',
        'type'  => 'tel'
      ),
      'fax' => array(
        'label' => 'Fax',
        'type'  => 'tel'
      ),
      'email' => array(
        'label' => 'Email',
        'type'  => 'email'
      ),
    )
  )
);

$form = new Kirby\Form($fields, array(
  'buttons' => array(
    'submit' => 'Save'
  )
));

echo $form;
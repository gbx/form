<?php 

/**
 * Help text below fields
 */

require('../../toolkit/bootstrap.php');
require('../bootstrap.php');

$fields = array(
  'comment' => array(
    'label' => 'Your comment',
    'type'  => 'textarea', 
    'help'  => 'Enter your comment...',
  ) 
);

$form = new Kirby\Form($fields, array(
  'buttons' => array(
    'submit' => 'Post'
  )
));

echo $form;
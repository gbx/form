<?php 

/**
 * A simple contact form 
 * with on submit handler 
 */

require('../../toolkit/bootstrap.php');
require('../bootstrap.php');
  
// form fields
$fields = array(
  'name' => array(
    'label'     => 'Name', 
    'type'      => 'text', 
    'required'  => true,
    'autofocus' => true
  ),
  'email' => array(
    'label'     => 'Email address', 
    'type'      => 'email',
    'required'  => true
  ),
  'message' => array(
    'label'     => 'Your message', 
    'type'      => 'textarea', 
    'required'  => true
  ),
);

// form setup
$form = new Kirby\Form($fields, array(
  'buttons' => array(
    'submit' => 'Send'
  )
));

// submit handler
$form->on('submit', function($form) {

  // validate all data
  $validation = v($form->data(), array(
    'name'    => array('required'),
    'email'   => array('required', 'email'),
    'message' => array('required'),
  ));

  // if validation fails…
  if($validation->failed()) {    
    
    $form->raise($validation);
    $form->alert('Please fill in all fields correctly');

    return false;

  } 

  // mail template
  $body = implode(PHP_EOL, array(
    'Name: {name}',
    '----',
    'Email: {email}',
    '----',
    'Message: {message}'
  ));

  // replace all placeholders in the mail template with real data
  $body = str::template($body, $form->data());

  // send the email
  $email = email(array(
    'to'      => 'bastian.allgeier@gmail.com',
    'from'    => 'bastian.allgeier@gmail.com',
    'replyTo' => $form->data('email'),
    'subject' => 'Contact form submission',
    'body'    => $body
  ));

  if($email->failed()) {
    $form->alert('The email could not be sent');
  } else {
    go(url::current());
  }

});

echo $form->html();
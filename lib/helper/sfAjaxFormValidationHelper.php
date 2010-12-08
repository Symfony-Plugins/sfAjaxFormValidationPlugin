<?php
// vim: set ts=2 sts=2 sw=2 et:

function use_ajax_validation_for_form(sfForm $form)
{
  $script = url_for('sf_ajax_form_validation_init', array('form' => get_class($form)));
  sfContext::getInstance()->getResponse()->addJavascript($script, 'last');
}

?>

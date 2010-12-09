<?php
/*
 * vim: set ts=2 sts=2 sw=2 et:
 *
 * This file is part of the sfAjaxFormValidationPlugin package.
 * (c) 2010 Yuri B. Lukyanov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function use_ajax_validation_for_form(sfForm $form)
{
  $script = url_for('sf_ajax_form_validation_init', array('form' => get_class($form)));
  sfContext::getInstance()->getResponse()->addJavascript($script, 'last');
}

?>

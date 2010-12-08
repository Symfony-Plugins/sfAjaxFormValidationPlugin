<?php
// vim: set st=2 sw=2 ts=2 et:

class sfAjaxFormValidationActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = $this->getForm($request);

    $this->field_names = array();
    foreach ($this->form->getValidatorSchema()->getFields() as $name => $field)
    {
      if ($this->form->getCSRFFieldName() != $name)
        $this->field_names[] = $name;
    }

    $this->prepareView();
  }

  public function executeValidate(sfWebRequest $request)
  {
    $this->form = $this->getForm($request);

    $field_name  = $request->getParameter('field');
    $field_value = $request->getParameter('value');

    $json = $this->validateField($this->form, $field_name, $field_value);

    $this->prepareView();

    return $this->renderText($json);
  }

  protected function getForm($request)
  {
    $form_name = $request->getParameter('form');
    $this->forward404Unless($this->isValidFormName($form_name));
    return new $form_name;
  }

  protected function prepareView()
  {
    $this->setLayout(false);
    $this->getResponse()->setHttpHeader('Content-type', 'text/javascript');
  }
  
  protected function isValidFormName($form_class_name)
  {
    return class_exists($form_class_name) && is_subclass_of($form_class_name, 'sfForm');
  }

  protected function validateField($form, $field_name, $field_value)
  {
    $validator = $form->getValidator($field_name);
    try
    {
        $validator->clean($field_value);
        $json = true;
    }
    catch (sfValidatorError $validatorError)
    {
      //TODO: Support I18N
      //sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
      $json = str_replace('%value%', $field_value, $validatorError->getMessage());
    }
    return json_encode($json);
  }
}

?>

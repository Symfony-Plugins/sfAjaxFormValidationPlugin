<?php /* vim: set ts=2 sts=2 sw=2 et: */ ?>

jQuery(function($) {
  $.each(
    ["<?php echo implode('","', $field_names->getRawValue()) ?>"],
    function (i, field) {
      $("form :input[name='<?php echo $form->getName() ?>[" + field + "]']").bind('blur', function(ev) {
        var value = $(ev.target).val();
        $.getJSON("<?php echo url_for("sf_ajax_form_validation_validate", array('form' => get_class($form))) ?>",
            {field: field, value: value}, function(data) {
          $(ev.target).prev(".error_list").remove();
          if (typeof data == 'string') {
            $(ev.target).before("<ul class=\"error_list\"><li>" + data + "</li></ul>")
          }
        });
      });
    }
  );
});

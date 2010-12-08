<?php /* vim: set ts=2 sts=2 sw=2 et: */ ?>

jQuery(function($) {
  $.each(
    ["<?php echo implode('","', $field_names->getRawValue()) ?>"],
    function (i, field) {
      $("form :input[name='<?php echo $form->getName() ?>[" + field + "]']").bind('blur', function(ev) {
        var self = this;
        $.getJSON("<?php echo url_for("sf_ajax_form_validation_validate", array('form' => get_class($form))) ?>",
            {field: field, value: $(self).val()}, function(data) {
          $(self).prev(".error_list").remove();
          if (typeof data == 'string') {
            $(self).before("<ul class=\"error_list\"><li>" + data + "</li></ul>")
          }
        });
      });
    }
  );
});

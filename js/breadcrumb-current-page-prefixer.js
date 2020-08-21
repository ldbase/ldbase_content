(function ($, Drupal) {
  Drupal.behaviors.ldbase_content = {
    attach: function (context, settings) {
      var body = document.getElementsByTagName("body")[0];
      var body_classes = body.classList;
      if (body_classes.contains("page-node-type-project")) {
        var current_page_ctype = 'Project';
      }
      if (body_classes.contains("page-node-type-dataset")) {
        var current_page_ctype = 'Dataset';
      }
      if (body_classes.contains("page-node-type-code")) {
        var current_page_ctype = 'Code';
      }
      if (body_classes.contains("page-node-type-document")) {
        var current_page_ctype = 'Document';
        if (document.getElementsByClassName("field--name-field-document-type")[0].getElementsByTagName('a')[0].innerText == 'Codebook') {
          var current_page_ctype = 'Codebook';
        }
      }
      var breadcrumb_list = document.getElementsByClassName('breadcrumb__item');
      var current_page_breadcrumb = breadcrumb_list[breadcrumb_list.length - 1];
      var current_page_breadcrumb_span = current_page_breadcrumb.children[1];
      var current_page_breadcrumb_text = current_page_breadcrumb_span.innerHTML;
      if (current_page_breadcrumb_text.search(current_page_ctype) != 0) {
        var modified_current_page_breadcrumb_text = current_page_ctype + ": " + current_page_breadcrumb_text;
        current_page_breadcrumb_span.innerHTML = modified_current_page_breadcrumb_text;
      }
    }
  };
})(jQuery, Drupal);

(function ($) {
  Drupal.behaviors.vbo = {
    attach: function(context) {
      $('.views-row-selector-selection-form', context).each(function() {
        Drupal.viewsRowSelector.initTableBehaviors(this);
        Drupal.viewsRowSelector.initGenericBehaviors(this);
      });
    }
  }

  Drupal.viewsRowSelector = Drupal.viewsRowSelector || {};
  Drupal.viewsRowSelector.initTableBehaviors = function(form) {
    $('.views-row-selector-table-select-all', form).show();
    // This is the "select all" checkbox in (each) table header.
    $('.views-row-selector-table-select-all', form).click(function() {
      var table = $(this).closest('table')[0];
      $('input[id^="edit-views-row-selector"]:not(:disabled)', table).attr('checked', this.checked);

      var values = $('input[id^="edit-views-row-selector"]:checked').map(function () {
        return this.value;
      }).get();
      $('.views-row-selector-fieldset-selected-rows').val(values);
    });

    $('.views-row-selector-select', form).click(function() {
      var values = $('input[id^="edit-views-row-selector"]:checked').map(function () {
        return this.value;
      }).get();
      $('.views-row-selector-fieldset-selected-rows').val(values);
    });
  }

  Drupal.viewsRowSelector.initGenericBehaviors = function(form) {
    // Show the "select all" fieldset.
    $('.views-row-selector-select-all-markup', form).show();

    $('.views-row-selector-select-this-page', form).click(function() {
      $('input[id^="edit-views-row-selector"]', form).attr('checked', this.checked);

      // Toggle the "select all" checkbox in grouped tables (if any).
      $('.views-row-selector-table-select-all', form).attr('checked', this.checked);

      var values = $('input[id^="edit-views-row-selector"]:checked').map(function () {
        return this.value;
      }).get();
      $('.views-row-selector-fieldset-selected-rows').val(values);
    });

    $('.views-row-selector-select', form).click(function() {
      // If a checkbox was deselected, uncheck any "select all" checkboxes.
      if (!this.checked) {
        $('.views-row-selector-select-this-page', form).attr('checked', false);

        var table = $(this).closest('table')[0];
        if (table) {
          // Uncheck the "select all" checkbox in the table header.
          $('.views-row-selector-table-select-all', table).attr('checked', false);
        }
      }

      var values = $('input[id^="edit-views-row-selector"]:checked').map(function () {
        return this.value;
      }).get();
      $('.views-row-selector-fieldset-selected-rows').val(values);
    });
  }

})(jQuery);
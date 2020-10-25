(function($) {

  'use strict';

  $(document).ready(function() {

    'use strict';

    //initialize chosen on all the select elements
    var chosenElements = [];

    //Statistics Menu -------------------------------------------------------------------------------------------------
    addToChosen('sb');
    addToChosen('or');

    //Wizard Menu ---------------------------------------------------------------------------------------------------
    addToChosen('category-id');

    //Autolinks Menu ---------------------------------------------------------------------------------------------------
    addToChosen('cf');
    addToChosen('category-id');
    addToChosen('open-new-tab');
    addToChosen('use-nofollow');
    addToChosen('case-sensitive-search');
    addToChosen('left-boundary');
    addToChosen('right-boundary');
    addToChosen('post-types');
    addToChosen('categories');
    addToChosen('tags');
    addToChosen('term-group-id');

    //Terms Menu
    for (var i = 0; i <= 100; i++) {
      addToChosen('post-type-' + i);
      addToChosen('taxonomy-' + i);
      addToChosen('term-' + i);
    }

    //Maintenance menu -------------------------------------------------------------------------------------------------
    addToChosen('task');

    //Options Menu -----------------------------------------------------------------------------------------------------

    //Defaults
    addToChosen('daam-defaults-open-new-tab');
    addToChosen('daam-defaults-use-nofollow');
    addToChosen('daam-defaults-case-sensitive-search');
    addToChosen('daam-defaults-left-boundary');
    addToChosen('daam-defaults-right-boundary');
    addToChosen('daam-defaults-categories');
    addToChosen('daam-defaults-tags');
    addToChosen('daam-defaults-term-group-id');

    //Analysis
    addToChosen('daam-analysis-set-max-execution-time');
    addToChosen('daam-analysis-set-memory-limit');
    addToChosen('daam-analysis-categories');
    addToChosen('daam-analysis-tags');

    //Tracking
    addToChosen('daam-tracking-enable-click-tracking');

    //Pagination
    addToChosen('daam-pagination-statistics-menu');
    addToChosen('daam-pagination-autolinks-menu');
    addToChosen('daam-pagination-categories-menu');
    addToChosen('daam-pagination-tracking-menu');

    //Advanced
    addToChosen('daam-advanced-enable-autolinks');
    addToChosen('daam-advanced-enable-test-mode');
    addToChosen('daam-advanced-random-prioritization');
    addToChosen('daam-advanced-ignore-self-autolinks');
    addToChosen('daam-advanced-categories-and-tags-verification');
    addToChosen('daam-advanced-general-limit-mode');
    addToChosen('daam-advanced-protected-tags');
    addToChosen('daam-advanced-protected-gutenberg-blocks');
    addToChosen('daam-advanced-protected-gutenberg-embeds');

    //Post Editor
    addToChosen('daam-enable-autolinks');

    $(chosenElements.join(',')).chosen({
      placeholder_text_multiple: window.objectL10n.chooseAnOptionText,
    });

    function addToChosen(elementId) {

      if ($('#' + elementId).length && chosenElements.indexOf($('#' + elementId)) === -1) {
        chosenElements.push('#' + elementId);
      }

    }

  });

})(window.jQuery);
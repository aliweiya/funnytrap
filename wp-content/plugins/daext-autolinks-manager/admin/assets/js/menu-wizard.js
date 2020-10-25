(function($) {

  'use strict';

  var hotInstance;

  $(document).ready(function() {

    'use strict';

    initHot();

    bindEventListeners();

  });

  function initHot() {

    var hotData,
        daamContainer;

    //initialize an empty table
    hotData = [
      ['Keyword', 'URL'],
    ];

    for (var i = 0; i < parseInt(window.objectL10n.wizardRows, 10); i++) {
      hotData.push(['', '']);
    }

    //Instantiate the handsontable table
    daamContainer = document.getElementById('daam-table');
    hotInstance = new window.Handsontable(daamContainer,
        {

          //set the table data
          data: hotData,

          //set the new maximum number of rows and columns
          maxRows: parseInt(window.objectL10n.wizardRows, 10) + 1,
          maxCols: 2,

        });

    hotInstance.updateSettings({
      cells: function(row, col) {

        var cellProperties = {};

        if (row === 0 && (col === 0 || col === 1)) {
          cellProperties.readOnly = true;
          cellProperties.disableVisualSelection = true;
        }

        return cellProperties;

      },
    });

  }

  function bindEventListeners() {

    $('#generate-autolinks').click(function(event) {

      event.preventDefault();

      generateAutolinks();

    });

  }

  function generateAutolinks() {

    var name,
        category_id,
        rawTableData,
        tableData = [];

    name = $('#name').val();
    category_id = parseInt($('#category-id').val(), 10);

    //Remove first row from the array (because it includes the labels of the hot table)
    rawTableData = hotInstance.getData().slice(1);

    //Put only the non-empty rows in tableData
    for(var key1 in rawTableData){
      if(rawTableData[key1][0] !== '' && rawTableData[key1][0] !== ''){
        tableData.push(rawTableData[key1]);
      }
    }

    //Convert the resulting JSON value to a JSON string
    tableData = JSON.stringify(tableData);

    //prepare ajax request
    var data = {
      'action': 'daam_wizard_generate_autolinks',
      'security': window.daamNonce,
      'name': name,
      'category_id': category_id,
      'table_data': tableData,
    };

    //set ajax in synchronous mode
    $.ajaxSetup({async: false});

    //send ajax request
    $.post(window.daamAjaxUrl, data, function(result) {

      if (result === 'invalid name') {

        //reload the dashboard menu
        window.location.replace(window.daamAdminUrl + 'admin.php?page=daam-wizard&invalid_name=1');

      } else {

        //reload the dashboard menu
        window.location.replace(window.daamAdminUrl + 'admin.php?page=daam-wizard&result=' + result);

      }

    });

    //set ajax in asynchronous mode
    $.ajaxSetup({async: true});

  }

}(window.jQuery));
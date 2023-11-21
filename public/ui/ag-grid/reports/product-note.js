document.addEventListener('DOMContentLoaded', function () {
var filterParams = {
    comparator: function (filterLocalDateAtMidnight, cellValue) {
      var dateAsString = cellValue;
      if (dateAsString == null) return -1;
      var dateParts = dateAsString.split('-');
      var cellDate = new Date(
        Number(dateParts[0]),
        Number(dateParts[1]) - 1,
        Number(dateParts[2])
      );
  
      if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
        return 0;
      }
  
      if (cellDate < filterLocalDateAtMidnight) {
        return -1;
      }
  
      if (cellDate > filterLocalDateAtMidnight) {
        return 1;
      }
    },
    browserDatePicker: true,
    inRangeInclusive:true,
    minValidYear: 2000,
  };

  let colums = [
      // set filters
      {headerName:'District',field: 'District',filter:'agTextColumnFilter',maxWidth:200},
      {headerName:'Store',field: 'Store', filter: 'agSetColumnFilter',maxWidth:200},
      {headerName:'Activity Date',field: 'Activity_Date', filter: 'agDateColumnFilter',filterParams: filterParams,
          cellRenderer: params => {
          return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
        }
      },
      {headerName:'Master Dealer',field: 'Master_Dealer', filter: 'agSetColumnFilter',maxWidth:150},
      {headerName:'Channel',field: 'Channel', filter: 'agSetColumnFilter'},
      {headerName:'Region',field: 'Region', filter: 'agTextColumnFilter',maxWidth:150},
      {headerName:'Market',field: 'Market', filter: 'agSetColumnFilter'},
      {headerName:'Loc ID',field: 'Loc_ID', filter: 'agSetColumnFilter'},
      {headerName:'Location Name',field: 'Location_Name', filter: 'agSetColumnFilter'},
      {headerName:'SKU Code',field: 'SKU_Code', filter: 'agSetColumnFilter'},
      {headerName:'SKU Description',field: 'SKU_Description', filter: 'agSetColumnFilter'},
      {headerName:'QTY to transfer',field: 'QTY_to_transfer', filter: 'agSetColumnFilter'}
  ]

  if(window.location.href.includes('type=summary')) {
    colums = [
        {headerName:'Loc ID',field: 'Loc_ID', filter: 'agSetColumnFilter',maxWidth:150},
        {headerName:'District',field: 'District',filter:'agSetColumnFilter',maxWidth:200},
        {headerName:'Store',field: 'Store', filter: 'agSetColumnFilter',maxWidth:200},
        {headerName:'Sum of QTY to transfer',field: 'Sum_of_QTY_to_transfer', filter: 'agTextColumnFilter',maxWidth:200}
    ]
  }


  const gridOptions = {
      columnDefs: colums,


      defaultColDef: {
        resizable: true,
        floatingFilter: true,
        sortable:true
      },
    };
    
    // setup the grid after the page has finished loading
      let gridDiv = document.querySelector('#Grid'),
          config = '',
          {href} = window.location,
          {url,role} = window.app;
      new agGrid.Grid(gridDiv, gridOptions);
      if ( href.includes('?') ) config = href.split('?')[1];
      let rep_url = `${url}/${role}/reports/product-note/find/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
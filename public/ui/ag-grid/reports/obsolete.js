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
  let dist = { headerName:'District',field: 'District',filter:'agSetColumnFilter',maxWidth:200 },
      stores = {headerName:'Store',field: 'StoreName', filter: 'agSetColumnFilter',maxWidth:200},
      url = window.location.href;
  if ( url.includes('type=summary') && window.app.role !== 'district-team-leader') {
    dist.rowGroup = true;
  } else {
    if (!url.includes('type=summary')) stores.rowGroup = true;
  }

  const gridOptions = {
      columnDefs: [
        // set filters
        dist,
        {headerName:'Loc ID',field: 'Loc_ID', filter: 'agSetColumnFilter',maxWidth:150},
        stores,
        {headerName:'Location',field: 'Location_Name', filter: 'agSetColumnFilter'},
        {headerName:'SKU',field: 'SKU', filter: 'agTextColumnFilter',maxWidth:150},
        {headerName:'SKU Description',field: 'SKU_Description', filter: 'agSetColumnFilter'},
        { headerName:'On Hand',field: 'On_Hand', filter: 'agTextColumnFilter',maxWidth:130 }
      ],
    
      defaultColDef: {
        flex: 1,
        resizable: true,
        floatingFilter: true,
        sortable:true
      },
      columnTypes: {
        number: {
          valueParser: (params) => {
            return parseInt(params.newValue);
          },
          aggFunc: 'sum',
        },
      },
      groupDisplayType: 'groupRows'
    };
    
    // setup the grid after the page has finished loading
    document.addEventListener('DOMContentLoaded', function () {
      let gridDiv = document.querySelector('#Grid'),
          config = '',
          {href} = window.location,
          {url,role} = window.app;
          
      if ( href.includes('?') ) config = href.split('?')[1];
      let rep_url = `${url}/${role}/reports/obsolete/find/?${config}`;
      new agGrid.Grid(gridDiv, gridOptions);
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });


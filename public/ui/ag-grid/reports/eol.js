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
  let dist = { headerName:'District',field: 'District',filter:'agTextColumnFilter',maxWidth:200},
      imei = {headerName:'IMEI',field: 'IMEI', filter: 'agTextColumnFilter'};
  if ( window.location.href.includes('type=summary') ) {
    dist.rowGroup = true;
  }
  const gridOptions = {
      columnDefs: [
        // set filters
        dist,
        {headerName:'Loc ID',field: 'Loc_ID', filter: 'agSetColumnFilter',maxWidth:150},
        {headerName:'Store Name',field: 'StoreName', filter: 'agSetColumnFilter',maxWidth:200},
        {headerName:'Location Name',field: 'Location_Name', filter: 'agSetColumnFilter'},
        {headerName:'SKU',field: 'SKU', filter: 'agTextColumnFilter',maxWidth:150},
        {headerName:'SKU Description',field: 'SKU_Description', filter: 'agSetColumnFilter'},
        imei
      ],
    
      defaultColDef: {
        flex: 1,
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
      let rep_url = `${url}/${role}/reports/eol/find/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
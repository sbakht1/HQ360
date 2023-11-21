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
  if ( window.location.href.includes('?type=summary') ) {
    dist.rowGroup = true;
  }
  const gridOptions = {
      columnDefs: [
        // set filters
        {headerName:'ID',field: 'id', filter: 'agSetColumnFilter',maxWidth:150},
        {headerName:'Report Date',field: 'date', filter: 'agSetColumnFilter',maxWidth:200, cellRenderer: p => {
          return moment(p.value).format('ll');
        }},
        {headerName:'Uploaded by',field: 'Employee_Name', filter: 'agSetColumnFilter',maxWidth:150},
        {headerName:'Updated On',field: 'updated', filter: 'agTextColumnFilter', cellRenderer: params => {
          return `<span>${moment(params.value).format('lll')}</span>`;
        }},
        {
          headerName:"",          
          sortable:false,
          cellRenderer: params => {
              let cell = '';
              return cell + `<a href="${window.app.url+'/uploads/'+params.data.file}" download="Inv Not Scanned Previous Month Inventory ${params.data.date}" class="btn btn-sm btn-primary">Download</a>`;
          }
        }
      ],
    
      defaultColDef: {
        flex: 1,
        resizable: true,
        floatingFilter: true,
        sortable:true
      },
      columnTypes: {
        
      }
    };
    
    // setup the grid after the page has finished loading
    document.addEventListener('DOMContentLoaded', function () {
      let gridDiv = document.querySelector('#Grid'),
          config = '',
          url = window.location.href;
      new agGrid.Grid(gridDiv, gridOptions);
      if ( url.includes('?') ) config = url.split('?')[1];
      fetch(window.app.url+'/'+window.app.role+'/reports/doors/find/pre-month-inv?'+config)
        .then((response) => response.json())
        .then((data) => gridOptions.api.setRowData(data));
    });


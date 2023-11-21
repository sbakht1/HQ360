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
  const gridOptions = {
      columnDefs: [
        // set filters
        { headerName:'District',field: 'District',filter:'agTextColumnFilter',maxWidth:200},
        {headerName:'OPUS Location Code',field: 'OPUS_Location_Code', filter: 'agSetColumnFilter',maxWidth:150},
        {headerName:'Store',field: 'Store', filter: 'agSetColumnFilter',maxWidth:200},
        {headerName:'Item Number SKU',field: 'Item_Number_SKU', filter: 'agSetColumnFilter'},
        {headerName:'Item Number SKU Description',field: 'Item_Number_SKU_Description', filter: 'agTextColumnFilter',maxWidth:150},
        {headerName:'Serial Number',field: 'Serial_Number', filter: 'agSetColumnFilter'},
        {headerName:'Last Transaction Date',field: 'Last_Transaction_Date', filter: 'agDateColumnFilter',filterParams: filterParams,
            cellRenderer: params => {
            return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
          }
        },
        {headerName:'Aging',field: 'Aging', filter: 'agSetColumnFilter'},
        {headerName:'NEXT Return',field: 'NEXT_Return', filter: 'agSetColumnFilter'},
        {headerName:'STL',field: 'STL', filter: 'agSetColumnFilter'},
        {headerName:'DTL',field: 'DTL', filter: 'agSetColumnFilter'}
      ],
    
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
      let rep_url = `${url}/${role}/reports/non-sellable/find/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
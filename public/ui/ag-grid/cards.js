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
      { headerName:'Employee',field: 'Employee_Name',filter:'agTextColumnFilter'},
      {headerName:'Store',field: 'StoreName', filter: 'agSetColumnFilter'},
      {headerName:'District',field: 'DistrictName', filter: 'agSetColumnFilter'},
      { 
        headerName: 'Updated on', field:'updated',filter:'agDateColumnFilter',filterParams: filterParams,
        cellRenderer: params => {
          return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
        }
      },
      {
        minWidth:250,
        cellRenderer: params => {
            return `
              <a href="${window.app.url+'/'+window.app.role+'/card/manage/'+params.data.id}" class="btn btn-sm btn-warning">Edit</a>
            `;
        }
      }
    ],
  
    defaultColDef: {
      flex: 1,
      resizable: true,
      floatingFilter: true,
      sortable:true
    },
  };
  
  // setup the grid after the page has finished loading
  document.addEventListener('DOMContentLoaded', function () {
    let gridDiv = document.querySelector('#Grid'),
        config = '',
        url = window.location.href;
    new agGrid.Grid(gridDiv, gridOptions);
    if ( url.includes('?') ) config = url.split('?')[1];
    fetch(window.app.url+'/'+window.app.role+'/card/find/?'+config)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
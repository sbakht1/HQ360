let {href} = window.location,
    {role,url} = window.app;

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
      { headerName:'Market',field: 'market',filter:'agSetColumnFilter'},
      { headerName:'Location',field: 'location',filter:'agSetColumnFilter'},
      { headerName:'Employee Name',field: 'name',filter:'agTextColumnFilter',sort: 'asc'},
      { headerName:'AT&T UID',field: 'attuid',filter:'agTextColumnFilter'},
      { headerName:'Courses',field: 'Total',filter:'agTextColumnFilter'},
      {
        minWidth:100,
        cellRenderer: params => {
            let cell = `
              <a href="${href+'/'+params.data.attuid}" class="btn btn-sm btn-primary">View</a>
            `;
            return cell;
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
        api = url+'/'+role+'/compliance/find';
    new agGrid.Grid(gridDiv, gridOptions);
    fetch(api)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
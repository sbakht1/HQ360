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
      { headerName:'Ticket ID',field: 'TicketID',filter:'agTextColumnFilter', maxWidth:150 },
      {headerName:'Department',field: 'assign_to', filter: 'agSetColumnFilter'},
      {headerName:'Store',field: 'StoreName', filter: 'agSetColumnFilter'},

      // number filters
      { headerName: 'District',field: 'DistrictName', filter: 'agSetColumnFilter' },
      { headerName:'Assign To',field: 'assign_emp', filter: 'agSetColumnFilter' },
      { 
        headerName: 'Date', field:'date',filter:'agDateColumnFilter',filterParams: filterParams,
        cellRenderer: params => {
          return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
        }
      },
      {headerName:"Employee",field:"Employee_Name", filter:'agSetColumnFilter'},
      {
        headerName:"Status",
        field:"status", filter: 'agSetColumnFilter',
        cellRenderer: params => {
            let label = '';
            switch (params.value) {
                case 'New': 
                  label = 'primary'; break;
                case 'Open': 
                  label = 'danger'; break;
                case 'Pending': 
                  label = 'warning'; break;
                case 'Waiting for Response': 
                  label = 'info'; break;
                case 'In Progress': 
                  label = 'light'; break;
                case 'Inactive': 
                  label = 'danger active'; break;
                case 'Closed': 
                  label = 'success'; break;
                case 'Re-Open': 
                  label = 'danger'; break;
                default: 
                  label = 'secondary';break;
            }
            
            let status = `<span class="btn btn-sm btn-inverse-${label}">${params.value}</span>`;
            
            return `${status}`;
        },        
      },
      {
        cellRenderer: params => {
            return `
              <a href="${window.app.url+window.ticket.single+params.data.TicketID}" class="btn btn-sm btn-primary">View</a>
            `;
        }
      }
    ],
  
    defaultColDef: {
      resizable: true,
      floatingFilter: true,
      sortable:true
    },
  };
  
  // setup the grid after the page has finished loading
  document.addEventListener('DOMContentLoaded', function () {
    let gridDiv = document.querySelector('#ticketGrid'),
        config = '',
        url = window.location.href;
    new agGrid.Grid(gridDiv, gridOptions);
    if ( url.includes('?') ) config = url.split('?')[1];
    console.log(config);
    fetch(window.app.url+window.ticket.all+'?'+config)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });

  $('#filter_form').on('submit', function (e) {
    let form = $(this),
        to = $(this).find('#to').val(),
        from  = $(this).find('#from').val(),
        to_ms = new Date(to).getTime(),
        fr_ms = new Date(from).getTime(),
        send = (to_ms > fr_ms) ? true : false;
      if (!send) form.append('<span class="text-danger">To must be grater than From</span>');
    return send;
  });
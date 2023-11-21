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
      { headerName:'Title',field: 'title',filter:'agTextColumnFilter'},
      {headerName:'Visibility',field: 'visibility', filter: 'agSetColumnFilter'},
      {headerName:'Created by',field: 'created_employee', filter: 'agSetColumnFilter'},
      {headerName:'Updated by',field: 'updated_employee', filter: 'agSetColumnFilter'},
      { 
        headerName: 'Created on', field:'created',filter:'agDateColumnFilter',filterParams: filterParams,
        cellRenderer: params => {
          return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
        }
      },{ 
        headerName: 'Updated on', field:'updated',filter:'agDateColumnFilter',filterParams: filterParams,
        cellRenderer: params => {
          return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
        }
      },
      {
        headerName:"Status",
        field:"status", filter: 'agSetColumnFilter',
        cellRenderer: params => {
            let label = '';
            switch (params.value) {
                case 'Publish': label = 'success'; break;
                case 'Draft': label = 'danger'; break;
                default: 
                  label = 'secondary';break;
            }
            
            let status = `<span class="btn btn-sm btn-inverse-${label}">${params.value}</span>`;
            
            return `${status}`;
        },        
      },
      {
        minWidth:250,
        pinned: 'right',
        cellRenderer: params => {
            return `
              <a href="${window.app.url+'/'+window.app.role+'/form-builder/m/'+params.data.id}" class="btn btn-sm btn-warning">Edit</a>
              <a target="_blank" href="${window.app.url+'/form/'+params.data.link}" class="btn btn-sm btn-primary">View</a>
              <a href="${window.app.url+'/'+window.app.role+'/form-builder/collection/'+params.data.id}?tool=true" class="btn btn-sm btn-success">Entries</a>
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
    let gridDiv = document.querySelector('#FormGrid'),
        config = '',
        url = window.location.href;
    new agGrid.Grid(gridDiv, gridOptions);
    if ( url.includes('?') ) config = url.split('?')[1];
    console.log(config);
    fetch(window.app.url+'/'+window.app.role+'/form-builder/find?'+config)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
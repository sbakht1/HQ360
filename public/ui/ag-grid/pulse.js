var filterParams = {
  comparator: function (filterLocalDateAtMidnight, cellValue) {
    console.log(cellValue);
    
  },
};
function mood(p) {
    let color = 'text-danger';
    switch(parseInt(p.value)) {
        case 5: color = 'text-success'; break;
        case 4: color = 'text-info'; break;
        case 3: color = 'text-warning'; break;
    }
    return `<span class="${color}"><i class="fa-solid fa-star"></i> ${parseFloat(p.value).toFixed(2)}</span>`;
}
const gridOptions = {
    columnDefs: [
      {headerName: 'District', showRowGroup: 'DistrictName',cellRenderer: 'agGroupCellRenderer', filter: 'agSetColumnFilter'},
      {headerName: 'Store', showRowGroup: 'StoreName',cellRenderer: 'agGroupCellRenderer', filter: 'agSetColumnFilter'},
      {headerName:'Employee',field: 'Employee_Name',filter:'agTextColumnFilter'},
      {headerName:'District',field: 'DistrictName', filter: 'agSetColumnFilter', rowGroup:true,hide: true},
      {headerName:'Store',field: 'StoreName', filter: 'agSetColumnFilter',rowGroup:true,hide:true},
      {headerName:'Feeling',field: 'feeling', filter: 'agSetColumnFilter', cellRenderer: mood, aggFunc:'avg' },
      {headerName:'Happiness',field: 'happiness', filter: 'agSetColumnFilter', cellRenderer: mood, aggFunc:'avg'},
      { 
        headerName: 'Month', field:'date',
        cellRenderer: params => {
          return `<span data-d="${params.value}">${moment($('#month').val()).format('MMM YYYY')}</span>`;
        }
      }
    ],
  
    defaultColDef: {
      flex: 1,
      resizable: true,
      floatingFilter: true,
      sortable:true
    },
    groupDisplayType: 'custom'
  };
  
  // setup the grid after the page has finished loading
  document.addEventListener('DOMContentLoaded', function () {
    $('#month').on('change', function() {
      $('#monthForm').submit();
    });
    let gridDiv = document.querySelector('#Grid'),
        config = '',
        url = window.location.href;
    new agGrid.Grid(gridDiv, gridOptions);
    if ( url.includes('?') ) config = url.split('?')[1];
    fetch(window.app.url+'/'+window.app.role+'/pulse/find?'+config)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
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

let colDefs = [
  {headerName:'District',field: 'DistrictName', filter: 'agSetColumnFilter'},
  {headerName:'Store',field: 'store', filter: 'agSetColumnFilter'},
  {headerName:'Employee',field: 'employee',filter:'agTextColumnFilter'},
  {headerName:'Submitted on',field: 'created',filter:'agTextColumnFilter',cellRenderer: p => {
    return `<span data-d="${p.value}">${moment(p.value).format('ll')}</span>`;
  }},
  {headerName:'Submit by',field: 'submit_by',filter:'agTextColumnFilter'},
  {
    headerName: 'Date', field:'date',
    cellRenderer: p => {
      return `<span data-d="${p.value}">${moment(p.value).format('ll')}</span>`;
    }
  }
  ];
  
  let {role,url} = window.app;
  if(role == 'admin') {
    colDefs.push({
      minWidth:250,
      cellRenderer: params => {
        let output = ``;
        output += `
          <a href="${url+'/'+role+'/connections/'+params.data.id}" class="btn btn-sm btn-primary">Edit</a>
          <a href="${url+'/'+role+'/connections/?del='+params.data.id}" class="btn btn-sm btn-danger">Delete</a>`;
          return output;
        }
      });
  }




const gridOptions = {
    columnDefs: colDefs,
  
    defaultColDef: {
      flex: 1,
      resizable: true,
      floatingFilter: true,
      sortable:true
    },
    getContextMenuItems: getContextMenuItems
  };

  function getContextMenuItems(p) {
    return ['copy'];
  }
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
    fetch(window.app.url+'/'+window.app.role+'/connections/find?'+config)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
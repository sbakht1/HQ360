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
  {headerName:'AT&T Score',field: 'atntScore',filter:'agTextColumnFilter', 
    cellRenderer: p => `<span class="text-${p.data.detail.atntScore[3]}">${p.value}</span>`
  },
  {headerName:'TWE Score',field: 'tweScore',filter:'agTextColumnFilter', 
    cellRenderer: p => `<span class="text-${p.data.detail.tweScore[3]}">${p.value}</span>`
  },
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
  cellRenderer: params => {
    let output = ``;
      output += `
      <a href="${url+'/'+role+'/observations/'+params.data.id}" class="btn btn-sm btn-primary">Edit</a>
      <a href="${url+'/'+role+'/observations/?del='+params.data.id}" class="btn btn-sm btn-danger">Delete</a>
      `;
      return output;
    }
  })
}

const gridOptions = {
    columnDefs: colDefs,
  
    defaultColDef: {
      resizable: true,
      floatingFilter: true,
      sortable:true
    },
    getContextMenuItems: getContextMenuItems
  };

  function getContextMenuItems(p) {
    return ['copy']
  }
  // setup the grid after the page has finished loading
  document.addEventListener('DOMContentLoaded', function () {
    $('#month').on('change', function() {
      $('#monthForm').submit();
    });
    let gridDiv = document.querySelector('#Grid'),
        config = '',
        {url,role} = window.app,
        {href} = window.location;
    new agGrid.Grid(gridDiv, gridOptions);
    if ( href.includes('?') ) config = href.split('?')[1];
    fetch(url+'/'+role+'/observations/find?'+config)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
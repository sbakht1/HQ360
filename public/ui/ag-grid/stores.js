const gridOptions = {
    columnDefs: [
      // set filters
      { headerName:"Store ID",field: 'StoreID',filter:'agTextColumnFilter', maxWidth:150 },
      { headerName:"OPUS ID", field: 'OpusId',filter:'agTextColumnFilter', maxWidth:150 },
      { 
        headerName:'Store',field: 'Store', filter: 'agTextColumnFilter',
        cellRenderer: params =>  `<img class="img-sm rounded-circle mr-2" src="${window.app.url+'/public/uploads/'+params.data.image}"> ${params.value}`
      },
  
      // number filters
      { headerName: 'District',field: 'District', filter: 'agSetColumnFilter' },
      { headerName:'Region',field: 'Region', filter: 'agSetColumnFilter' },
      { headerName: "Store Team Leader", field: 'STL', filter: 'agSetColumnFilter' },
      { headerName: 'District Team Leader', field:'DTL', filter: 'agSetColumnFilter' },
      {
        headerName:"Status",
        field:"Enabled",
        sortable:false,
        cellRenderer: params => {
            let cell = '';
            cell = ( params.value == 'TRUE' ) 
                ? `<span class="btn btn-sm btn-inverse-success">Enabled</span>`
                : `<span class="btn btn-sm btn-inverse-danger">Disabled</span>`;
            
            return cell + ` <a href="${window.app.url+'/'+window.app.role+'/stores/'+params.data.StoreID}" class="btn btn-sm btn-primary">${(window.app.role === 'inventory'||window.app.role === 'it')?"Detail":"Edit"}</a>`;
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
    var gridDiv = document.querySelector('#strGrid'),
        url = window.location.href;
    new agGrid.Grid(gridDiv, gridOptions);

    let status = (url.includes('?status=')) ? url.split('?')[1] : "";
  
    fetch(window.app.url+'/'+window.app.role+'/api/stores/aggrid?'+status)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
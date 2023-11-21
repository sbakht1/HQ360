var columnDefs = [
    // this row shows the row index, doesn't use any data from the row
    {headerName: "ID",
        // it is important to have node.id here, so that when the id changes (which happens
        // when the row is loaded) then the cell is refreshed.
        valueGetter: 'node.id',
        cellRenderer: 'loadingRenderer'
    },
    {
        headerName:"key",field:'id'
    },
    { headerName: 'District',field: 'DistrictName', filter: 'agSetColumnFilter' },
    { headerName:'Scorecard',field: 'scorecard', filter: 'agTextColumnFilter',
      cellRenderer: p => {
        if (p.value == undefined) return ""; 
        let val = parseInt(p.value);
        return `${(val*100)}%`
      }
    },
    { headerName:'Gross Profit',field: 'gp', filter: 'agTextColumnFilter',
      cellRenderer: p => {
        if (p.value == undefined) return ""; 
        let val = parseInt(p.value);
        return val.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})
      }
    },
    { 
      headerName: 'Month', field:'month',
      cellRenderer: params => {
          if (params.value == undefined) return ""; 
          return `<span data-d="${params.value}">${moment(params.value).format('MMM YYYY')}</span>`;
      }
    },
    {
      cellRenderer: params => {
        if (params.value == undefined) return "";
        let user = window.app.employee.Title.toLocaleLowerCase().split(' ').join('-');
        if (user === 'administrator') user = 'admin';
          return `
            <a data-toggle="modal" href="#scorecard" data-src="" class="btn btn-sm btn-primary sc-btn">View</a>
          `;
      }
    }
];

var gridOptions = {
    components:{
        loadingRenderer: function(params) {
            if (params.value !== undefined) {
                return params.value;
            } else {
                return '<i class="fas fa-sync fa-spin"></i> Loading...'
            }
        }

    },
    enableColResize: true,
    rowBuffer: 0,
    rowSelection: 'multiple',
    rowDeselection: true,
    columnDefs: columnDefs,
    // tell grid we want virtual row model type
    rowModelType: 'infinite',
    // how big each page in our page cache will be, default is 100
    paginationPageSize: 0,
    // how many extra blank rows to display to the user at the end of the dataset,
    // which sets the vertical scroll and then allows the grid to request viewing more rows of data.
    // default is 1, ie show 1 row.
    cacheOverflowSize: 1,
    // how many server side requests to send at a time. if user is scrolling lots, then the requests
    // are throttled down
    maxConcurrentDatasourceRequests: 1,
    // how many rows to initially show in the grid. having 1 shows a blank row, so it looks like
    // the grid is loading from the users perspective (as we have a spinner in the first col)
    infiniteInitialRowCount: 1,
    // how many pages to store in cache. default is undefined, which allows an infinite sized cache,
    // pages are never purged. this should be set for large data to stop your browser from getting
    // full of data
    maxBlocksInCache: 0
};

// setup the grid after the page has finished loading
document.addEventListener('DOMContentLoaded', function() {
    var gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);

    var dataSource = {
        getRows: function (params) {
            let url = window.app.url + window.app.score + "&";
            let {startRow, endRow, filterModel, sortModel} = params;
            console.log(startRow,endRow,filterModel,sortModel);
            // Pagination
            url += `start=${startRow}&end=${endRow}`;
            fetch(url)
                .then((response) => response.json())
                .then((data) => params.successCallback(data));
        }
    };
    gridOptions.api.setDatasource(dataSource);
});
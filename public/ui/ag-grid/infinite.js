let url = window.app.url + window.app.score + "&";
const gridOptions = {
    columnDefs: [
      { field: 'id', minWidth: 220 },
      { field: 'Employee_Name', minWidth: 200 },
      { field: 'Title' },
      { field: 'DistrictName', minWidth: 200 },
      { field: 'type' },
      { field: 'gp' },
      { field: 'scorecard' },
    ],
  
    defaultColDef: {
      flex: 1,
      minWidth: 100,
    },
  
    // use the server-side row model instead of the default 'client-side'
    rowModelType: 'infinite',
  };
  
  // setup the grid after the page has finished loading
  document.addEventListener('DOMContentLoaded', function () {
    let gridDiv = document.querySelector('#myGrid');
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
              .then((data) => {
                if (data.length > 0) {
                    console.log(params);
                    params.successCallback(data);
                  } else {
                    params.fail();
                  }
                // params.successCallback(data)
              });
      }
  };

    // register the datasource with the grid
    gridOptions.api.setDatasource(dataSource);
  });

  
  function createServerSideDatasource(server) {
    return {
      getRows: (params) => {
        console.log('test', params);
        
  
        // get data for request from our fake server
        const response = server.getData(params.request);
  
        // simulating real server call with a 500ms delay
        setTimeout(function () {
          if (response.success) {
            // supply rows for requested block to grid
            params.success({ rowData: response.rows });
          } else {
            params.fail();
          }
        }, 500);
      },
    };
  }
  
  function createFakeServer() {
    return {
      getData: (request) => {
        
        
  
        
      },
    };
  }
document.addEventListener('DOMContentLoaded', function () {
    let config = '',
        page = window.location.href;
    if ( page.includes('?') ) config = page.split('?')[1]+'&';
    let url = window.app.url+'/'+window.app.role+'/reports/bi/find/expanded-course-detail?'+config;

    $.get(url+'total=1').done(function(res) {
       let total = res.total;
    
    let location = p => (p.value != undefined) ? p.value.split('-')[1] : '';
    let cellRend = p => (p.value != undefined) ? `<span>${moment(p.value).format('ll')}</span>`: '';
    let loader = p => (p.value == undefined) ? '<i class="fas fa-sync fa-spin"></i> Loading...': p.value;

    const gridOptions = {
          columnDefs: [
            {headerName:'Name',field: 'Name', filter: 'agSetColumnFilter',cellRenderer:loader},
            {headerName:'ATTUID',field: 'ATTUID', filter: 'agSetColumnFilter'},
            {headerName:'Job Role',field: 'Job_Role', filter: 'agSetColumnFilter'},
            {headerName:'Hire Date',field: 'Hire_Date', filter: 'agSetColumnFilter',cellRenderer:cellRend},
            {headerName:'Location',field: 'Location', filter: 'agSetColumnFilter',cellRenderer: location,filterParams:{valueFormatter:location}},
            {headerName:'Dealer Code',field: 'Dealer_Code', filter: 'agSetColumnFilter'},
            {headerName:'Master_Dealer',field: 'Master_Dealer', filter: 'agSetColumnFilter'},
            {headerName:'Region',field: 'Region', filter: 'agSetColumnFilter'},
            {headerName:'Market',field: 'Market', filter: 'agSetColumnFilter'},
            {headerName:'Training Section',field: 'TRAINING_SECTION', filter: 'agSetColumnFilter'},
            {headerName:'Course Code',field: 'COURSE_CODE', filter: 'agSetColumnFilter'},
            {headerName:'Course tatus',field: 'Course_Status', filter: 'agSetColumnFilter'}
          ],
        
          defaultColDef: {
            resizable: true,
            floatingFilter: true,
            sortable:true
          },
        };

        gridOptions.rowModelType = 'infinite';
        gridOptions.datasource = {
            getRows(params) {
              const { startRow, endRow, filterModel, sortModel } = params;
              let url = window.app.url+'/'+window.app.role+'/reports/bi/find/expanded-course-detail?'+config;
              
              //Sorting
              if (sortModel.length) {
                const { colId, sort } = sortModel[0];
                url += `_sort=${colId}&_order=${sort}&`;
                console.log(sortModel);
              }
              //Filtering
              const filterKeys = Object.keys(filterModel)
              filterKeys.forEach(filter => {
                url += `${filter}=${filterModel[filter].filter}&`
              })
              //Pagination
              url += `_start=${startRow}&_end=${endRow}`
              fetch(url)
                .then(httpResponse => httpResponse.json())
                .then(response => {
                  params.successCallback(response, total);
                })
                .catch(error => {
                  console.error(error);
                  params.failCallback();
                })
            }
          };
        
        // setup the grid after the page has finished loading
        
            let gridDiv = document.querySelector('#Grid');
            new agGrid.Grid(gridDiv, gridOptions);
        })
});
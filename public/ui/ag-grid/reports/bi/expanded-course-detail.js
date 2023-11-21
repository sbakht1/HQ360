document.addEventListener('DOMContentLoaded', function () {
    let location = p => p.value.split('-')[1];
    let cellRend = p => `<span>${moment(p.value).format('ll')}</span>`;
    let loader = p => (p.value == undefined) ? '<i class="fas fa-sync fa-spin"></i> Loading...': p.value;

    const gridOptions = {
          columnDefs: [
            {headerName:'Name',field: 'Name', filter: 'agSetColumnFilter'},
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
        
        // setup the grid after the page has finished loading
        let gridDiv = document.querySelector('#Grid'),
          config = '',
          {href} = window.location,
          {url,role} = window.app;
      new agGrid.Grid(gridDiv, gridOptions);
      if ( href.includes('?') ) config = href.split('?')[1];
      let rep_url = `${url}/${role}/reports/bi/find/expanded-course-detail/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
document.addEventListener('DOMContentLoaded', function () {
  let cellRend = p => moment(p.value).format('ll');
  let loader = p => (p.value == undefined) ? '<i class="fas fa-sync fa-spin"></i> Loading...': p.value;
  const gridOptions = {
    columnDefs: [
      {headerName:'Level',field: 'Level', filter: 'agSetColumnFilter',cellRenderer:loader},
      {headerName:'Level ID',field: 'Level_ID', filter: 'agSetColumnFilter'},
      {headerName:'Date',field: 'Date', filter: 'agSetColumnFilter',cellRenderer:cellRend},
      {headerName:'NextUp Installment Plan Mix',field: 'NextUp_Installment_Plan_Mix', filter: 'agTextColumnFilter'},
      {headerName:'Overall CSAT',field: 'Overall_CSAT', filter: 'agSetColumnFilter'}
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
      let rep_url = `${url}/${role}/reports/bi/find/1674-1801-reps/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) {
            $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          }
          gridOptions.api.setRowData(data)
        })
    });
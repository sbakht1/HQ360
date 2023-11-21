document.addEventListener('DOMContentLoaded', function () {
    let make_col = (arr) => {
      let col = {headerName:arr[0].split('_').join(' '),field: arr[1], filter: 'agSetColumnFilter'};
      if (arr[2] != undefined) col.cellRenderer=arr[2];
      if(arr[3] != undefined) col.filterParams = {valueFormatter:arr[3]}
      return col;
    }
    let cellRend = p => moment(p.value).format('ll');
    let loader = p => (p.value == undefined) ? '<i class="fas fa-sync fa-spin"></i> Loading...': p.value;
    let cols = ["Date","District","Store_ID","Store_Name","Employee_ID","Employee_Name","Total_Customer_Count"];
    
    let defs  = [];
    for (c of cols) {
      let conf = [c,c];
      if(c.toLowerCase().includes('date')) {
          conf.push(cellRend);
          conf.push(cellRend);
      }
      defs.push(make_col(conf));
    };
    const gridOptions = {
      columnDefs: defs,
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
      let rep_url = `${url}/${role}/reports/surveillance/find/traffic-count/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
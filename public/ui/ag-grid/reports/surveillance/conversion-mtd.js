document.addEventListener('DOMContentLoaded', function () {
    let {href} = window.location;
    let make_col = (arr) => {
      let col = {headerName:arr[0].split('_').join(' '),field: arr[1], filter: 'agSetColumnFilter'};
      if (arr[2] != undefined) col.cellRenderer=arr[2];
      if(arr[3] != undefined) col.filterParams = {valueFormatter:arr[3]}
      return col;
    }
    let cellRend = p => moment(p.value).format('ll');
    let loader = p => (p.value == undefined) ? '<i class="fas fa-sync fa-spin"></i> Loading...': p.value;
    let cols = ["District","Employee_Name","Store_Name","Total_Customer_Count","Total_Opps","Net_Conversion","Activation","Activation_Closing_Rate","Upgrade","SPs","Gross_Profit","Accessories_Profit","APO"];
    
    if (href.includes('get=store')) {
        cols = ["District","Store_Name","Total_Customer_Count","Total_Opps","Net_Conversion","Activation","Activation_Closing_Rate","Upgrades","SPs","Gross_Profit","Accessories_Profit","APO","10:00_AM_11:00_AM","11:00_AM_12:00_PM","12:00_PM_01:00_PM","01:00_PM_02:00_PM","02:00_PM_03:00_PM","03:00_PM_04:00_PM","04:00_PM_05:00_PM","05:00_PM_06:00_PM","06:00_PM_07:00_PM","07:00_PM_08:00_PM","08:00_PM_09:00_PM"];
    }
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
          {url,role} = window.app;
      new agGrid.Grid(gridDiv, gridOptions);
      if ( href.includes('?') ) config = href.split('?')[1];
      let rep_url = `${url}/${role}/reports/surveillance/find/conversion-mtd/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
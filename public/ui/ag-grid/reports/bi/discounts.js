document.addEventListener('DOMContentLoaded', function () {
  let make_col = (arr) => {
    let col = {headerName:arr[0],field: arr[1], filter: 'agSetColumnFilter'};
    if (arr[2] != undefined) col.cellRenderer=arr[2];
    if(arr[3] != undefined) col.filterParams = {valueFormatter:arr[3]}
    return col;
  }
  let cellRend = p => moment(p.value).format('ll');
  let loader = p => (p.value == undefined) ? '<i class="fas fa-sync fa-spin"></i> Loading...': p.value;
  let cols = ["MasterDealerName","Region","Market","DOS","ARSM","DiscountApprover","ApproverJobTitle","TransactionDate","Location","CompassID","DiscountCode","InvoiceID","ItemCategory","ItemLongDescription","ItemNumber","ItemSubcategory","MobileNumber","RepATTUID","RepName","RepJobTitle","SerialNumber","Sum_of_Per_Unit_Price","Sum_of_Amount_Not_Collected","InvalidReason","CoachingTemplateComments","AuditorComments"];
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
      let rep_url = `${url}/${role}/reports/bi/find/discounts/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
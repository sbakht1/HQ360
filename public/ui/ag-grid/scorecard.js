var filterParams = {
    comparator: function (filterLocalDateAtMidnight, cellValue) {
      var dateAsString = cellValue;
      if (dateAsString == null) return -1;
      var dateParts = dateAsString.split('-');
      var cellDate = new Date(
        Number(dateParts[0]),
        Number(dateParts[1]) - 1,
        Number(dateParts[2])
      );
  
      if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
        return 0;
      }
  
      if (cellDate < filterLocalDateAtMidnight) {
        return -1;
      }
  
      if (cellDate > filterLocalDateAtMidnight) {
        return 1;
      }
    },
    browserDatePicker: true,
    inRangeInclusive:true,
    minValidYear: 2000,
  };
  const store = window.location.href.includes('type=store');
  let cols=[
    { headerName:'Store',field: 'StoreName',filter:'agSetColumnFilter'},
  ];
  if (!store) {
    cols.push({headerName:'Employee',field: 'Employee_Name', filter: 'agSetColumnFilter'},
    {headerName:'Title',field: 'Title', filter: 'agSetColumnFilter'})
  }
  cols.push(
    { headerName: 'District',field: 'DistrictName', filter: 'agSetColumnFilter' },
    { headerName:'Scorecard',field: 'scorecard', filter: 'agTextColumnFilter',
      cellRenderer: p => `${(parseFloat(p.value)*100).toFixed(0)}%`
    },
    { headerName:'Gross Profit',field: 'gp', filter: 'agTextColumnFilter',
      cellRenderer: p => parseInt(p.value).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})
    },
    { 
      headerName: 'Month', field:'yyyymm',
      cellRenderer: params => {
        return `<span data-d="${params.value}">${moment(params.value).format('MMM YYYY')}</span>`;
      }
    },
    {
      cellRenderer: params => {
        let user = window.app.employee.Title.toLocaleLowerCase().split(' ').join('-');
        if (user === 'administrator') user = 'admin';
          return `
            <a data-toggle="modal" href="#scorecard" data-src="${window.app.url+'/'+user+'/scorecards/card/'+params.data.id}" class="btn btn-sm btn-primary sc-btn">View</a>
          `;
      }
    });
  
  const gridOptions = {
      columnDefs: cols,
    
      defaultColDef: {
        resizable: true,
        floatingFilter: true,
        sortable:true
      },
    };
    
    // setup the grid after the page has finished loading
    document.addEventListener('DOMContentLoaded', function () {
      let gridDiv = document.querySelector('#scoreGrid');
      new agGrid.Grid(gridDiv, gridOptions);

      fetch(window.app.url+window.app.score)
        .then((response) => response.json())
        .then((data) => gridOptions.api.setRowData(data))
        .then(() => window.app.aggrid = 'loaded');
    });
  
    $('#filter_form').on('submit', function (e) {
      let form = $(this),
          to = form.find('#to').val(),
          from  = form.find('#from').val(),
          to_ms = new Date(to).getTime(),
          fr_ms = new Date(from).getTime(),
          send = (to_ms > fr_ms) ? true : false;
        if (!send) form.append('<span class="text-danger">To must be grater than From</span>');
      return send;
    });
document.addEventListener('DOMContentLoaded', function () {
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
    
      let colums = [
          // set filters
          {headerName:'District',field: 'District',filter:'agTextColumnFilter'},
          {headerName:'Store ID',field: 'Store ID',filter:'agTextColumnFilter'},
          {headerName:'ClosingChecklist Id',field: 'ClosingChecklist_Id', filter: 'agSetColumnFilter'},
          {headerName:'Location',field: 'Location', filter: 'agSetColumnFilter'},
          {headerName:'Location code',field: 'Location code', filter: 'agSetColumnFilter'},
          {headerName:'Date Of Deposit',field: 'DateOfDeposit', filter: 'agDateColumnFilter',filterParams: filterParams,
              cellRenderer: params => {
                return (params.value == "1970-01-01 00:00:00") ? "" : `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
            }
          },
          {headerName:'AT&T Expected Cash Amount',field: 'AT&T Expected Cash Amount', filter: 'agSetColumnFilter',
            cellRenderer: params => {
              return (params.value < 0) ? `<span class="text-danger">($${Math.abs(params.value)})</span>`: `$${params.value}`;
            }
          },
          {headerName:'Logbook image amount',field: 'Logbook image amount', filter: 'agSetColumnFilter',
          cellRenderer: params => {
            return (params.value < 0) ? `<span class="text-danger">($${Math.abs(params.value)})</span>`: `$${params.value}`;
          }},
          {headerName:'Variance',field: 'Variance', filter: 'agSetColumnFilter',maxWidth:150,
            cellRenderer: params => {
              return (params.value < 0) ? `<span class="text-danger">($${Math.abs(params.value)})</span>`: `$${params.value}`;
            }
          },
          {headerName:'Final Status',field: 'Final Status', filter: 'agSetColumnFilter'}
      ];
      const gridOptions = {
          columnDefs: colums,
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
      let rep_url = `${url}/${role}/reports/reconciliation/find/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
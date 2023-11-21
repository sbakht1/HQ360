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
          {headerName:'District',field: 'district',filter:'agTextColumnFilter',maxWidth:200},
          {headerName:'ClosingChecklist Id',field: 'closingchecklist_id', filter: 'agSetColumnFilter',maxWidth:200},
          {headerName:'Location',field: 'location', filter: 'agSetColumnFilter',maxWidth:200},
          {headerName:'Location code',field: 'location_code', filter: 'agSetColumnFilter',maxWidth:200},
          {headerName:'DateOfDeposit',field: 'dateofdeposit', filter: 'agDateColumnFilter',filterParams: filterParams,
              cellRenderer: params => {
                return (params.value == "1970-01-01 00:00:00") ? "" : `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
            }
          },
          {headerName:'AT&T Expected Cash Amount',field: 'att_expected_cash_amount', filter: 'agSetColumnFilter',
            cellRenderer: params => {
              return (params.value < 0) ? `<span class="text-danger">($${Math.abs(params.value)})</span>`: `$${params.value}`;
            }
          },
          {headerName:'Logbook image amount',field: 'logbook_image_amount', filter: 'agSetColumnFilter',
          cellRenderer: params => {
            return (params.value < 0) ? `<span class="text-danger">($${Math.abs(params.value)})</span>`: `$${params.value}`;
          }},
          {headerName:'Variance',field: 'variance', filter: 'agSetColumnFilter',maxWidth:150,
            cellRenderer: params => {
              return (params.value < 0) ? `<span class="text-danger">($${Math.abs(params.value)})</span>`: `$${params.value}`;
            }
          },
          {headerName:'Signature Validated',field: 'signature_validated', filter: 'agDateColumnFilter',filterParams: filterParams,
              cellRenderer: params => {
              return (params.value == "") ? "<i>N/A</i>" : `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
            }
          },
          {headerName:'Final Status',field: 'final_status', filter: 'agSetColumnFilter'},
          {headerName:'Explanation for Variance',field: 'Explanation_for_Variance', filter: 'agSetColumnFilter'},
          {headerName:'Pickup Status',field: 'pickup_status', filter: 'agSetColumnFilter'},
          {headerName:'Reconciliation_Status',field: 'reconciliation_status', filter: 'agSetColumnFilter'}          
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
      let name = href.split('name=')[1].split('&')[0];
          rep_url = `${url}/${role}/reports/cash-deposits/find/${name}/?${config}`,
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
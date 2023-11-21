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
          {headerName:'District',field: 'District',filter:'agTextColumnFilter',maxWidth:200},
          {headerName:'Store',field: 'Store_ID', filter: 'agSetColumnFilter',maxWidth:200},
          {headerName:'ClosingChecklist Id',field: 'ClosingChecklist_Id', filter: 'agSetColumnFilter',maxWidth:200},
          {headerName:'Location',field: 'Location', filter: 'agSetColumnFilter',maxWidth:200},
          {headerName:'Location code',field: 'Location_code', filter: 'agSetColumnFilter',maxWidth:200},
          {headerName:'DateOfDeposit',field: 'DateOfDeposit', filter: 'agDateColumnFilter',filterParams: filterParams,
              cellRenderer: params => {
                return (params.value == "1970-01-01 00:00:00") ? "" : `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
            }
          },
          {headerName:'Entry Date Submitted',field: 'Entry_DateSubmitted', filter: 'agDateColumnFilter',filterParams: filterParams,
              cellRenderer: params => {
                return (params.value == "1970-01-01 00:00:00") ? "" : `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
            }
          },
          {headerName:'Deposit Amount',field: 'DepositAmount', filter: 'agSetColumnFilter',maxWidth:150},
          {headerName:'AT&T Expected Cash Amount',field: 'ATT_Expected_Cash_Amount', filter: 'agSetColumnFilter'},
          {headerName:'Logbook image amount',field: 'Logbook_image_amount', filter: 'agSetColumnFilter'},
          {headerName:'Variance',field: 'Variance', filter: 'agTextColumnFilter',maxWidth:150},
          {headerName:'Pick up Days',field: 'Pick_up_Days', filter: 'agTextColumnFilter',maxWidth:150},
          {headerName:'Signature Validated',field: 'Signature_Validated', filter: 'agDateColumnFilter',filterParams: filterParams,
              cellRenderer: params => {
              return (params.value == "1970-01-01 00:00:00" || params.value == "") 
                  ? "N/A" 
                  : `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
            }
          },
          {headerName:'Form Status',field: 'Form_Status', filter: 'agSetColumnFilter'},
          {headerName:'Final Status',field: 'Final_Status', filter: 'agSetColumnFilter'},
          {headerName:'Explanation for Variance',field: 'Explanation_for_Variance', filter: 'agSetColumnFilter'},
          {headerName:'Email Status',field: 'Email_Status', filter: 'agSetColumnFilter'},
          {headerName:'AT&T CashOut Image',field: 'QTY_to_transfer', filter: 'agSetColumnFilter'},
          {headerName:'Reconciled Variance',field: 'Reconciled_Variance', filter: 'agSetColumnFilter'},
          {headerName:'Pickup Status',field: 'Pickup_Status', filter: 'agSetColumnFilter'},
          {headerName:'Reconciliation_Status',field: 'Reconciliation_Status', filter: 'agSetColumnFilter'},
          {headerName:'Variance Inquiry Sent',field: 'Variance_Inquiry_Sent', filter: 'agSetColumnFilter'},
          {headerName:'Missing Entry Inquiry_Sent',field: 'Missing_Entry_Inquiry_Sent', filter: 'agSetColumnFilter'},
          {headerName:'2nd Attempt Inquiry Sent',field: '2nd_Attempt_Inquiry_Sent', filter: 'agSetColumnFilter'},
          {headerName:'Response Received',field: 'Response_Received', filter: 'agSetColumnFilter'},
          {headerName:'Status',field: 'Status', filter: 'agSetColumnFilter'},
          {headerName:'Signature Missing',field: 'Signature_Missing', filter: 'agSetColumnFilter'}
      ]
    
      if(window.location.href.includes('type=summary')) {
        colums = [
            {headerName:'Loc ID',field: 'Loc_ID', filter: 'agSetColumnFilter',maxWidth:150},
            {headerName:'District',field: 'District',filter:'agSetColumnFilter',maxWidth:200},
            {headerName:'Store',field: 'Store', filter: 'agSetColumnFilter',maxWidth:200},
            {headerName:'Sum of QTY to transfer',field: 'Sum_of_QTY_to_transfer', filter: 'agTextColumnFilter',maxWidth:200}
        ]
      }
    
    
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
      let rep_url = `${url}/${role}/reports/cash-deposits/find/main/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
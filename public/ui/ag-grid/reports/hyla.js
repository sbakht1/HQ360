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
      {headerName:'Company',field: 'Company',filter:'agTextColumnFilter'},
      {headerName:'Store',field: 'StoreName', filter: 'agSetColumnFilter',maxWidth:200},
      {headerName:'District',field: 'DistrictName', filter: 'agSetColumnFilter',maxWidth:200},
      {headerName:'Awaiting Pickup Trades',field: 'Awaiting_Pickup_Trades', filter: 'agTextColumnFilter'},
      {headerName:'Oldest Trade Date',field: 'Oldest_Trade_Date', filter: 'agDateColumnFilter',filterParams: filterParams,
          cellRenderer: params => {
          return ( params.value == "1970-01-01") 
            ? "N/A"
            :`<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
          // return params.value;
        }
      },
      {headerName:'30 Day Discrepancy Charge',field: '30_Day_Discrepancy_Charge', filter: 'agTextColumnFilter',filterParams: filterParams,
          cellRenderer: params => {
          let v = params.value;
          let value = v.match(/(\d+)/g);
          value = (value != null) ? parseFloat(value.join('.')): 0;
          return (value < 0 || v.includes('(')) ? `<span class="text-danger">($${Math.abs(value)})</span>` : `$${value}`;
        }
      }
  ]

  if(window.location.href.includes('type=discrepancy')) {
    colums = [
        {headerName:'Company',field: 'Company', filter: 'agSetColumnFilter'},        
        {headerName:'Item #',field: 'Item_#', filter: 'agSetColumnFilter'},        
        {headerName:'Invoice #',field: 'Invoice_#', filter: 'agSetColumnFilter'},        
        {headerName:'Trade In Date',field: 'Trade_In_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Processed Date',field: 'Processed_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Manufacturer',field: 'Manufacturer', filter: 'agSetColumnFilter'},        
        {headerName:'Model',field: 'Model', filter: 'agSetColumnFilter'},        
        {headerName:'Trade in Value',field: 'Trade_in_Value', filter: 'agSetColumnFilter'},        
        {headerName:'Post Inspection Value',field: 'Post_Inspection_Value', filter: 'agSetColumnFilter'},        
        {headerName:'Trade Type',field: 'Trade_Type', filter: 'agSetColumnFilter'},        
        {headerName:'Discrepancy Reason',field: 'Discrepancy_Reason', filter: 'agSetColumnFilter'},        
        {headerName:'User Name',field: 'User_Name', filter: 'agSetColumnFilter'},        
        {headerName:'API Sales Rep',field: 'API_Sales_Rep', filter: 'agSetColumnFilter'},        
        {headerName:'Discrepancy Total',field: 'Discrepancy_Total', filter: 'agSetColumnFilter'},        
        {headerName:'Discrepancy Adjustment Amount',field: 'Discrepancy_Adjustment_Amount', filter: 'agSetColumnFilter'},        
        {headerName:'Discrepancy Adjustment Reason',field: 'Discrepancy_Adjustment_Reason', filter: 'agSetColumnFilter'},        
        {headerName:'Base Amount Used',field: 'Base_Amount_Used', filter: 'agSetColumnFilter'},        
        {headerName:'Promotion Amount Used',field: 'Promotion_Amount_Used', filter: 'agSetColumnFilter'},        
    ]
  }


  if(window.location.href.includes('type=trade-in')) {
    colums = [
        {headerName:'Company',field: 'Company', filter: 'agSetColumnFilter'},        
        {headerName:'Parent Company',field: 'Parent_Company', filter: 'agSetColumnFilter'},        
        {headerName:'Payment Company',field: 'Payment_Company', filter: 'agSetColumnFilter'},        
        {headerName:'Item #',field: 'Item_#', filter: 'agSetColumnFilter'},        
        {headerName:'Invoice #',field: 'Invoice_#', filter: 'agSetColumnFilter'},        
        {headerName:'IMEI',field: 'IMEI', filter: 'agSetColumnFilter'},        
        {headerName:'Promotion Card',field: 'Promotion_Card', filter: 'agSetColumnFilter'},        
        {headerName:'Model',field: 'Model', filter: 'agSetColumnFilter'},        
        {headerName:'Product',field: 'Product', filter: 'agSetColumnFilter'},        
        {headerName:'Promo Code',field: 'Promo_Code', filter: 'agSetColumnFilter'},        
        {headerName:'Promo Alias',field: 'Promo_Alias', filter: 'agSetColumnFilter'},        
        {headerName:'Bonus Code',field: 'Bonus_Code', filter: 'agSetColumnFilter'},        
        {headerName:'Pre Inspection Trade in Value',field: 'Pre_Inspection_Trade_in_Value', filter: 'agSetColumnFilter'},        
        {headerName:'Promo TIV',field: 'Promo_TIV', filter: 'agSetColumnFilter'},        
        {headerName:'Bonus TIV',field: 'Bonus_TIV', filter: 'agSetColumnFilter'},        
        {headerName:'Post Processed Value',field: 'Post_Processed_Value', filter: 'agSetColumnFilter'},        
        {headerName:'Promo PIV',field: 'Promo_PIV', filter: 'agSetColumnFilter'},        
        {headerName:'Bonus PIV',field: 'Bonus_PIV', filter: 'agSetColumnFilter'},        
        {headerName:'Discrepancy Adjustment Amount',field: 'Discrepancy_Adjustment_Amount', filter: 'agSetColumnFilter'},        
        {headerName:'Discrepancy Adjustment Reason',field: 'Discrepancy_Adjustment_Reason', filter: 'agSetColumnFilter'},        
        {headerName:'Adjustment Reason',field: 'Adjustment_Reason', filter: 'agSetColumnFilter'},        
        {headerName:'Location Identifier',field: 'Location_Identifier', filter: 'agSetColumnFilter'},        
        {headerName:'Location Nickname',field: 'Location_Nickname', filter: 'agSetColumnFilter'},        
        {headerName:'User Name',field: 'User_Name', filter: 'agSetColumnFilter'},        
        {headerName:'Full Name',field: 'Full_Name', filter: 'agSetColumnFilter'},        
        {headerName:'API Sales Rep',field: 'API_Sales_Rep', filter: 'agSetColumnFilter'},        
        {headerName:'New IMEI/ESN',field: 'New_IMEI/ESN', filter: 'agSetColumnFilter'},        
        {headerName:'Reference Number',field: 'Reference_Number', filter: 'agSetColumnFilter'},        
        {headerName:'Trade In Date',field: 'Trade_In_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Shipped Date',field: 'Shipped_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Receipt Date',field: 'Receipt_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Processed Date',field: 'Processed_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Payment Date',field: 'Payment_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Pickup Date',field: 'Pickup_Date', filter: 'agSetColumnFilter'},        
        {headerName:'Shipping Provider',field: 'Shipping_Provider', filter: 'agSetColumnFilter'},        
        {headerName:'Shipment Type',field: 'Shipment_Type', filter: 'agSetColumnFilter'},        
        {headerName:'Inbound Kit Tracking #',field: 'Inbound_Kit_Tracking_#', filter: 'agSetColumnFilter'},        
        {headerName:"Base Amount Used",field:"Base_Amount_Used",filter:'agSetColumnFilter'},
        {headerName:"Promotion Amount Used",field:"Promotion_Amount_Used",filter:'agSetColumnFilter'},
        {headerName:"Outbound Shipper",field:"Outbound_Shipper",filter:'agSetColumnFilter'},
        {headerName:"Outbound Tracking #",field:"Outbound_Tracking_#",filter:'agSetColumnFilter'},
        {headerName:"Inbound Shipper",field:"Inbound_Shipper",filter:'agSetColumnFilter'},
        {headerName:"Original Invoice Type",field:"Original_Invoice_Type",filter:'agSetColumnFilter'},
        {headerName:"Original Invoice #",field:"Original_Invoice_#",filter:'agSetColumnFilter'},
    ]
  }

  const gridOptions = {
      columnDefs: colums,
      defaultColDef: {
        width: 200,
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
      let rep_url = `${url}/${role}/reports/hyla/find/?${config}`;
      fetch(rep_url)
        .then((response) => response.json())
        .then((data) => {
          $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
          gridOptions.api.setRowData(data)
        })
    });
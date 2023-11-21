document.addEventListener('DOMContentLoaded', function () {
      let cellRend = p => moment(p.value).format('ll');
      let location = p => p.value.split('-')[1];
      const gridOptions = {
          columnDefs: [
            {headerName:'Source',field: 'Source', filter: 'agSetColumnFilter',},
            {
              headerName:'Activity Date',field: 'Activity_Date', filter: 'agSetColumnFilter',cellRenderer:cellRend,
              valueFormatter: cellRend, filterParams: {valueFormatter: cellRend},
            },
            {headerName:'Master Dealer Name',field: 'Master_Dealer_Name', filter: 'agSetColumnFilter'},
            {headerName:'Region',field: 'Region', filter: 'agSetColumnFilter'},
            {headerName:'Market Group',field: 'Market_Group', filter: 'agSetColumnFilter'},
            {headerName:'Location Name',field: 'Location_Name', filter: 'agSetColumnFilter', cellRenderer: location,filterParams:{valueFormatter:location}},
            {headerName:'Location ID',field: 'Location_Id', filter: 'agSetColumnFilter'},
            {headerName:'Dealer 1 CD',field: 'Dealer_1_Cd', filter: 'agSetColumnFilter'},
            {headerName:'Agent',field: 'Agent', filter: 'agSetColumnFilter'},
            {headerName:'Agent UID',field: 'Agent_UID', filter: 'agSetColumnFilter'},
            {headerName:'Dealer 2 Cd',field: 'Dealer_2_Cd', filter: 'agSetColumnFilter'},
            {headerName:'Liability',field: 'Liability', filter: 'agSetColumnFilter'},
            {headerName:'Account Number',field: 'Account_Number', filter: 'agSetColumnFilter'},
            {headerName:'CTN',field: 'CTN', filter: 'agSetColumnFilter'},
            {headerName:'Device Type',field: 'Device_Type', filter: 'agSetColumnFilter'},
            {headerName:'Order ID',field: 'Order_ID', filter: 'agSetColumnFilter'},
            {headerName:'SOC Code',field: 'SOC_Code', filter: 'agSetColumnFilter'},
            {headerName:'SDG SOC Code',field: 'SDG_SOC_Code', filter: 'agSetColumnFilter'},
            {headerName:'Sum of Mobility Gross Add Prepaid Cnt',field: 'Sum_of_Mobility_Gross_Add_Prepaid_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of Mobility Gross Add Postpaid New Cnt',field: 'Sum_of_Mobility_Gross_Add_Postpaid_New_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of Mobility Gross Add Postpaid Add a Line Cnt',field: 'Sum_of_Mobility_Gross_Add_Postpaid_Add_a_Line_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of Mobility Upgrade Cnt',field: 'Sum_of_Mobility_Upgrade_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of Protection Cnt',field: 'Sum_of_Protection_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of Protection Rev',field: 'Sum_of_Protection_Rev', filter: 'agSetColumnFilter'},
            {headerName:'Sum of Accessory Cnt',field: 'Sum_of_Accessory_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of DTV Posted Cnt',field: 'Sum_of_DTV_Posted_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of ATT TV Posted Cnt',field: 'Sum_of_ATT_TV_Posted_Cnt', filter: 'agSetColumnFilter'},
            {headerName:'Sum of IPBB Posted Cnt',field: 'Sum_of_IPBB_Posted_Cnt', filter: 'agSetColumnFilter'}
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
          let rep_url = `${url}/${role}/reports/bi/find/digital-sales/?${config}`;
          fetch(rep_url)
            .then((response) => response.json())
            .then((data) => {
              if(data.length > 0) $('.actions').append(`<a href="${rep_url}&export=true" class="btn btn-success">Export</a>`);
              gridOptions.api.setRowData(data)
            })
        });
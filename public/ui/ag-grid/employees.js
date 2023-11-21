// setup the grid after the page has finished loading
window.onload = function () {
    let status = '',
        url = window.location.href;
    if ( url.includes('?status=')) status = url.split('?')[1];
    $.get(window.app.url+window.employee.url+'?'+status)
     .done(function (data) {
        make(data);
    })
}

function make(data) {
    let gridOptions = {};
        gridOptions.columnDefs = [
            {headerName: "AT&T UID", field: "UID", filter:'agTextColumnFilter'},
            {headerName: "Store", field: "StoreName",filter: 'agSetColumnFilter'},
            {headerName: "District", field: "DistrictName",filter: 'agSetColumnFilter'},
            {
                headerName: "Employee Name", field: "Employee_Name", filter:'agTextColumnFilter',
                sort: 'asc',
                cellRenderer: p => {
                    let img = `<img src="${window.app.url+'/public/uploads/'+p.data.image}" alt="${p.data.Employee_Name}" class="img-sm rounded-circle mr-2">`;
                    return img + p.value;
                }
            },
            {headerName: "Email Address", field: "Email", filter:'agTextColumnFilter'},
            {headerName: "Title", field: "Title",filter: 'agSetColumnFilter'},
            {
                headerName: "Account Status", 
                field: "Account_Disabled",
                cellRenderer: params => {
                    let cell = '';
                    if ( params.value == 'FALSE' ) {
                        cell = `<span class="BoxStyle-success">Enabled</span>`;
                    } else {
                        cell = `<span  class="BoxStyle-danger">Disabled</span>`;
                    }
                    return `${cell} <a href="${window.app.url + window.employee.single}${params.data.id}" class="btn btn-sm btn-primary mb-1" style="height:30px !important">${(window.app.role === 'inventory' || window.app.role === 'it')?"Detail":"Edit"}</a>`
                }
            }
    ];
    gridOptions.defaultColDef = {
        flex: 1,
        minWidth: 200,
        resizable: true,
        floatingFilter: true,
        sortable: true
    }
    // let the grid know which columns and what data to use
    gridOptions.rowData = data;
    var gridDiv = document.querySelector('#EmpGrid');
    new agGrid.Grid(gridDiv, gridOptions);
}
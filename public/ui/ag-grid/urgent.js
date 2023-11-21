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
const gridOptions = {
    columnDefs: [
      // set filters
      { headerName:'Title',field: 'title',filter:'agTextColumnFilter'},
      {headerName:'Author',field: 'author', filter: 'agSetColumnFilter'},
      {headerName:'Type',field: 'type', filter: 'agSetColumnFilter'},
      {headerName:'Updated by',field: 'updated_by', filter: 'agSetColumnFilter'},
      { 
        headerName: 'Created at', field:'created',filter:'agDateColumnFilter',filterParams: filterParams,
        cellRenderer: params => {
          return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
        }
      },{ 
        headerName: 'Updated at', field:'updated',filter:'agDateColumnFilter',filterParams: filterParams,
        cellRenderer: params => {
          return `<span data-d="${params.value}">${moment(params.value).format('ll')}</span>`;
        }
      },
      {
        headerName:"Status",
        field:"status", filter: 'agSetColumnFilter',
        cellRenderer: params => {
            let label = '';
            switch (params.value) {
                case 'Publish': label = 'success'; break;
                case 'Draft': label = 'danger'; break;
                default: 
                  label = 'secondary';break;
            }
            
            let status = `<span class="btn btn-sm btn-inverse-${label}">${params.value}</span>`;
            
            return `${status}`;
        },        
      },
      {
        minWidth:300,
        cellRenderer: params => {
            return `
              <a href="${window.app.url+'/'+window.app.role+'/urgent/view/'+params.data.id}" class="btn btn-sm btn-warning">Edit</a>
              <button data-id="${params.data.id}" data-title="${params.data.title}" data-toggle="modal" data-target="#employee_ack" class="btn btn-sm btn-success btn-ack">Acknowledged Employees</button>
            `;
        }
      }
    ],
  
    defaultColDef: {
      resizable: true,
      floatingFilter: true,
      sortable:true
    },
  };
  
  // setup the grid after the page has finished loading
  document.addEventListener('DOMContentLoaded', function () {

    setInterval(function() {
      $('.btn-ack').unbind();
      $('.btn-ack').on('click', function() {
        let title = $(this).data('title'),
            {role,url} = window.app,
            id = $(this).data('id'),
            find = url+'/'+role+'/urgent/seen/'+id,
            btn = `<a href="${find}?export=true" target="_blank" class="btn btn-success btn-sm float-right d-none">Export</a>`;
          $('#msg_title').html(title+btn);
          $('#emp').html('<tr><td><i class="fas fa-sync fa-spin"></i> Loading...</td></tr>');
          $.get(find,function(res){
            $('#emp').html('');
            if(res.length == 0) {
              $('#emp').html('<tr><td>No one Acknowledged this message.</td></tr>');
            } else {
              $('#employee_ack .btn.d-none').removeClass('d-none');
              $('#emp').html('<tr><th>Name</th><th>Title</th><th>Store</th><th>District</th><th>Acknowledged on</th></tr>');
            }
            res.map(function(item,i) {
              $('#emp').append(`<tr>
              <td>
                <a class="d-flex align-items-center" href="${url}/${role}/employees/${item.EmployeeID}">
                    <div class="img">
                        <img src="${url}/public/uploads/${item.image}" alt="Store" class="img-sm rounded-circle mr-2">
                    </div>
                    <div class="text-black">
                        <strong class="title">${item.Employee_Name}</strong>
                    </div>
                </a>
              </td>
              <td>${item.Title}</td>
              <td>${item.StoreName}</td>
              <td>${item.DistrictName}</td>
              <td>${window.app.localTime(item.acknowledged,'lll')}</td>
          </tr>`)
            })
          })
      })
    },1000)



    let gridDiv = document.querySelector('#UrgGrid'),
        config = '',
        url = window.location.href;
    new agGrid.Grid(gridDiv, gridOptions);
    if ( url.includes('?') ) config = url.split('?')[1];
    fetch(window.app.url+'/'+window.app.role+'/api/urgents/?'+config)
      .then((response) => response.json())
      .then((data) => gridOptions.api.setRowData(data));
  });
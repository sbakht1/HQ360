let {href} = window.location,
    {role,url} = window.app;
$.get(window.app.url+'/api/store/list').done(function(res) {
  window.store_list = res;
});
$.get(window.app.url+'/api/employee/list').done(function(res) {
  window.employee_list = res;
});

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
  inRangeInclusive:true
};
function render(p) {
    if ( p.value.includes('/stores') ) {
      let find = p.value.split('-');
      return `${find[0].split('/stores')[0]+' - '+window.store_list[$.trim(find[1])]}`;
    } 
    if ( p.value.includes('/employees') ) {
      let find = p.value.split('-');
      return `${find[0].split('/employees')[0]+' - '+window.employee_list[$.trim(find[1])]}`;
    } 

    return p.value;
}
const gridOptions = {
    minWidth:50,
    columnDefs: [],
    defaultColDef: {
      resizable: true,
      floatingFilter: true,
      sortable:true
    },
  };
  
  // setup the grid after the page has finished loading
  document.addEventListener('DOMContentLoaded', function () {
    let gridDiv = document.querySelector('#CollectionGrid'),
        config = '',
        api = '';
    new agGrid.Grid(gridDiv, gridOptions);
    if(role != 'admin') {
      api = href.split('?')[0]+"/collect";
    } else {
      if ( href.includes('collection/') ) config = href.split('collection/')[1];
      api = url+'/'+role+'/form-builder/collect/'+config;

    }
    fetch(api)
      .then((response) => response.json())
      .then( function(data) {
        dynamicallyConfigureColumnsFromObject(data[0]);
        gridOptions.api.setRowData(data);
        })
      .then(function() {
        window.lightGallery();
      });

      function cellRend(p) {
        let colName = p.colDef.field,
            usd_con = colName.toLowerCase().includes('amount') || colName.toLowerCase().includes('variance');
        return (usd_con) ? '$'+p.value : p.value;
      }
    
      function dynamicallyConfigureColumnsFromObject(anObject){
        const colDefs = gridOptions.api.getColumnDefs();
        colDefs.length=0;
        const keys = Object.keys(anObject)
        // keys.forEach(key => colDefs.push({field : key}));
        keys.map(function(key,i) {
          let field = {field : key,cellRenderer: cellRend};
          if(key !== 'submitted_date' && key !== 'Form_title' && !key.includes('- image')) colDefs.push(field);
        });
        keys.map(function(key,i) {
          if(key.includes('- image')) {
            colDefs.push({
              field: key,
              cellRenderer: p => `<a target="_blank" class="light-item" data-src="${p.value}" href="${p.value}"><img src="${p.value}" height="50" /></a>`
            })
          }
        })
        colDefs.push({ 
          headerName: 'Submitted on', field:'submitted_date',filter:'agDateColumnFilter',filterParams: filterParams,
          cellRenderer: params => {
            return `<span data-d="${params.value}">${moment(params.value).format('lll')}</span>`;
          }
        });
        colDefs.push({
          pinned: 'right',
          cellRenderer: params => {
              let view = (role == 'admin') ? url+'/'+role+'/form-builder/view' : href.split('?')[0],
                  cell = `
                <a data-toggle="modal" data-target="#entry" href="${view+'/'+params.data.id}" class="entry btn btn-sm btn-primary">View</a>
              `;
              cell += (role =='admin') ? `<a href="${url+'/'+role+'/form-builder/trash/'+params.data.id}?to=${href}" class="btn btn-sm btn-danger">Trash</a>`:"";
              return cell;
          }
        });
        gridOptions.api.setColumnDefs(colDefs);
    }
    });
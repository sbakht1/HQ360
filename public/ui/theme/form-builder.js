$(document).ready(function () {

	window.onload = function () {
		let type = window.form.type;
		update_type(type);
		switch (type) {
			case 'Title Base Employees': 
				$('#title').val(window.form.meta);
				$('#title').select2();
			break;
			case 'Select Individual Employees':
				let check = setInterval(function () {
					if ( $('#employees').next().hasClass('select2') ) {
						clearInterval(check);
						$('#employees').removeAttr('class').attr('class','emps').val(window.form.meta);
						window.app.employees();
					}
				},10);
			break;
		}
		$('.dropify').dropify();
		$('.dropify').on('change', function (e) {
			var formData = new FormData(),
				date = new Date(),
				name = date.getTime();
				// file = $(this).data('file');
			formData.append('image',e.target.files[0]);
			formData.append('name', name);
			$.ajax({      
				type: 'POST',
				url: window.app.url+'/upload',
				data: formData, 
				success: function (data) { 
					form.data[window.file].url = window.app.public+'/'+data.path;
				},
				cache: false,
				contentType: false,
				processData: false
			})
		})
	}

	var elements = $('.elements'),
		setting = $('.element-setting'),
        f=0,
		formTitle = $('#form_title');
		formTitle.attr('contenteditable',true);
	setting.hide();
	elements.hide();

	
	$('[name="type"]').on('change', function () {
		update_type($(this).val());
	});
	$('[name="status"]').on('change', function () {
		window.form.status = $(this).val();
	});

	function update_type(val) {
		let type = val,
			id = type.toLowerCase().split(' ').join('_');
		form.type = type;
		$('.hidden-set').addClass('d-none');
		if ($(`#${id}`).length > 0) $(`#${id}`).removeClass('d-none');
	}

	$('[name="title"],[name="employees"]').on('change', function () {
		let field = $(this).attr('name');

		if (field == 'title') {
			$('#employees').val('');
			$('#employees + .select2 ul').html('');
		}
		if (field == 'employees') {
			$('#title').val('');
			$('#title + .select2 ul').html('');
		}
		
		let meta = $(this).val();
		form.meta = meta;
	})

	$('.form').on('mouseenter', function () { $(this).find('.trigger').slideDown();})
	$('.form').on('mouseleave', function () { $(this).find('.trigger').slideUp();})


	var form = window.form;
	formTitle.html(form.title);
	generate_form(form['data']);
	function generate_form(form) {
		$('.layout').html('');
		for ( i in form ) make_element(form[i],i);
		$('.layout .selected').removeClass('selected');
		$('.layout').append('<button class="btn btn-primary btn-lg mt-4 save-form-btn">Save Form</button>');
		for ( i in form ) if( form[i].type === 'sign' ) sign_init(`#f${i}`);
		add_row();
		form_element();
		form_input();
		blur_input();
		element_handle();
		drag_drop();
		saveForm();	
		window.app.employees();
		window.app.stores();
	}

	formTitle.on('blur', function (e) { form.title = $(this).text(); })

	function element_handle() {
		$('.form-input, .form-row').each(function () {
			$(this).prepend(`<div class="input-action">
				<i class="fa-solid fa-trash"></i>
			</div>`)
		});
		$('.input-action i').on('click', function () {

			var item = $(this).parent().parent(),
				i = item.data('i'),
				del = [];
			if (typeof form['data'][i] !== 'string') {
				let remItem = form['data'][i];
				form['data'][i] = {col: remItem.col,type:'blank'};	
			} else {
				del.push(i);
				var x = i+1;
				do {
					if (typeof form['data'][x] == 'undefined') break;
					del.push(x);
					x++;
				} while ( form['data'][x] !== 'row' );
			}
			del = del.reverse();
			for ( d in del ) form['data'].splice(del[d],1);
			setting.hide();
			generate_form(form['data']);
		})
	}
	
	function make_element(item,i) {
		var content = '';
		if ( item === 'row' ) {
			$('.layout .selected').removeClass('selected');
			content = '<div class="row form-row selected" data-item="row" data-i="'+i+'"></div>';
			$('.layout').append(content);
		} else {
			switch (item.type) {
				case 'input-text': 	content = input(item,i);break;
				case 'input-email': content = input(item,i);break;
				case 'input-tel': 	content = input(item,i);break;
				case 'input-date': 	content = input(item,i);break;
				case 'input-price':	content = input(item,i);break;

				case 'textarea': 	content = textarea(item,i);break;
				case 'select': 		content = options(item,i);break;
				case 'stores': 		content = stores(item,i);break;
				case 'employees': 	content = employees(item,i);break;
				case 'checkbox': 	content = options(item,i);break;
				case 'radio': 		content = options(item,i);break;

				case 'file': 		content = file(item,i);break;
				case 'sign': 		content = sign(item,i);break;
				case 'image': 		content = image(item,i);break;
				case 'brief': 		content = brief(item,i);break;

				case 'blank': 		content = blank(item,i);break;
			}
			$('.layout .selected').append(content);
		}
	}


	function blur_input() {
		$('.layout .form-control').on('focus', function () { $(this).blur(); })
	}

	function form_element() {
		$('.form-element').unbind();
		$('.form-element').on('click', function () {
			$('.form-element').removeClass('selected');
			$(this).addClass('selected');
			elements.show();
			setting.hide();	
			add_to_form();
		});
	}
	function form_input() {
		$('.form-input').unbind();
		$('.form-input').on('click', function () { en_setting($(this).data('i')); })
	}

	function en_setting(i) {
		elements.hide();
		console.log(form.data[i]);
		$('.form-input').removeClass('active');
		$(`.form-input[data-i="${i}"]`).addClass('active');
		setting.find('#lab').val(form['data'][i].label);
		setting.find('#req').parent().show();

		if ( typeof form['data'][i].required !=='undefined' ) {
			setting.find('#req')[0].checked = form['data'][i].required;
		} else {
			setting.find('#req').parent().hide();
		}

		$('#textarea').parent().hide();
		$('#req').show();
		$('#brief').val('');
		$('#brief').parent().hide();

		if (form['data'][i].type === 'brief') {
			$('#req').parent().hide();
			$('#brief').parent().show();
			$('#brief').val(form['data'][i].brief);
			$('#brief').on('change', function () {
				form['data'][i].brief = $(this).val();
			})
		}

		if ( form['data'][i].type === "image") $('#req').parent().hide();

		$('#image').unbind();
		setting.find('#image').hide();
		if (form['data'][i].type === 'image') {
			$('.dropify-clear').trigger('click');
			window.file = i;
			let file = form.data[i].url.split(window.app.public+'/')[1];
			var img = $('#image');
			img.attr('src', form['data'][i].url);
			console.log(form.data[i]);
			img.show();
			$('.dropify').attr({
				'data-file-id':i,
				'data-file':file
			});
		}

		if ( form['data'][i].type === 'textarea' ) {
			$('#textarea').parent().show();
			$('#textarea').val(form['data'][i].rows);
			$('#textarea').unbind();
			$('#textarea').on('change', function () { form['data'][i].rows = $(this).val(); })
		}

		var check = $('#checkType');
		check.hide();
		check.unbind();
		if ( 
			form['data'][i].type === 'checkbox' || 
			form['data'][i].type === 'radio'
		) {
			check.show();
			check.find(`input[value="${form['data'][i].type}"]`).attr('checked', 'checked');
			check.find('input').on('change', function () { form['data'][i].type = $(this).val();})
		}

		setting.find('.options').html('');
		setting.find('.add-opt').hide();

		if ( typeof form['data'][i].options !== 'undefined' ) {
			setting.find('.add-opt').show();
			for ( o in form['data'][i].options ) {
				setting.find('.options').append(`
					<div class="opt" data-i="${o}">
						<i class="fa-solid fa-trash del"></i>
						<input class="form-control" value="${form['data'][i].options[o]}">
					</div>
				`);
			}
		}
		$('#req').parent().unbind();
		$('#lab').unbind();
		$('.options i').unbind();		
		$('.save-btn').unbind();
		$('.add-opt').unbind();
		$('.options i').on('click',function () {
			var del = parseInt($(this).parent().data('i'));
			form['data'][i].options.splice(del,1);
			$(this).parent().remove();
		})
		$('.add-opt').on('click', function (e) {
			e.preventDefault();
			var newItem = `Item ${form['data'][i].options.length+1}`;
			form['data'][i].options.push(newItem);	
			setting.find('.options').append(`
				<div class="opt" data-i="${form['data'][i].options.length-1}">
					<i class="fa-solid fa-trash del"></i>
					<input class="form-control" value="${newItem}">
				</div>
			`);
			update_options();
		})
		$('#req').on('change', function (e) { form['data'][i].required = e.target.checked; });
		$('#lab').on('change', function () { form['data'][i].label = $(this).val(); });
		update_options();

		$('.save-btn').on('click', function () {
			update_item(i,form['data'][i]);
			generate_form(form.data);
			return false;
		})
		setting.show();
	}

	function update_options() {
		setting.find('.options input').on('change', function () { 
			var updated_value = $(this).val(),
				no = $(this).parent().data('i'),
				i = $('.form-input.active').data('i');
			form['data'][i].options[no] = updated_value;
			console.log(updated_value,no);
		})
	}

	function update_item(i,item) {
		console.log(i,item);
		i = parseInt(i);
		form.data[i] = item;
		generate_form(form.data);
		en_setting(i);
	}

	
	function add_to_form() {
		$('a', elements).unbind();
		$('a', elements).on('click', function(e) {
			e.preventDefault();
			var input = $(this).data('item'),
				index = $('.layout .form-element.selected').parent().data('i'),
				field = {label:'Label', required:false,type:input,col:form['data'][index].col};
				
			form['data'][index] = field;
			elements.hide();
			generate_form(form['data']);
			en_setting(index);
		})
	}

	function add_row() {
		$('.trigger .addrow').unbind();
		$('.trigger .addrow').on('click', function () {
			var no = parseInt($('.trigger .cols').val());
			form['data'].push('row');

			switch (no) {
				case 2: 
					form['data'].push({col:6,type:'blank'});
					form['data'].push({col:6,type:'blank'});
					break;
				case 3: 
					form['data'].push({col:4,type:'blank'});
					form['data'].push({col:4,type:'blank'});
					form['data'].push({col:4,type:'blank'});
					break;
				case 4: 
					form['data'].push({col:3,type:'blank'});
					form['data'].push({col:3,type:'blank'});
					form['data'].push({col:3,type:'blank'});
					form['data'].push({col:3,type:'blank'});
					break;
				default: form['data'].push({col:12,type:'blank'});break;
			}			
			generate_form(form['data']);
			return false;
		});
	}

	function drag_drop() {
		$('.layout').attr('id','draggables');
		$('#draggables').sortable({
			revert: true,
			stop: function() {
				let data = [];
				$('#draggables [data-item]').each(function (i) {
					let item = ($(this).data('item') !== 'row') 
						? JSON.parse(atob($(this).data('item')))
						: $(this).data('item');
					if (typeof item.label == 'undefined') item.type = 'blank';
					data.push(item);
				});
				console.log(data,form.data);
				form.data = data;
				generate_form(form.data);
			}
		});
		$('.form-input').draggable({
			contentment:'#content',
			stack: '#draggables .form-input',
			cursor: 'move',
			revert: true
		})
		$('.empty').droppable({
			accept:'#draggables .form-input',
			hoverClass: 'hovered',
			drop: function (e,ui) {
				let drop = e.target.dataset.i,
					drag = ui.draggable.data('i'),
					dropper = form.data[drag],
					dragger = form.data[drop],
					drop_col = dropper.col,
					drag_col = dragger.col;

				form.data[drag] = dragger;
				form.data[drop] = dropper;
				form.data[drag].col = drop_col;
				form.data[drop].col = drag_col;
				ui.draggable.position({of:$(this),my:'left top',at:'left top'});
				ui.draggable.draggable('option','revert',false);
				generate_form(form.data);
			}
		})
	}
	
	function blank(item,i) {
		var fe = '<a href="#" class="form-element">+</a>';
		return `<div class="col-${item.col} empty" data-i="${i}" data-item="${btoa('{"col":'+item.col+'}')}">${fe}</div>`;
	}
	function stores(item,i) {
		var required = (item.required) ? '<span class="text-danger">*</span>':'';
			dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input drag" data-i="${i}" data-item="${dataItem}">
			<div class="form-group">
				<label for="f${i}">${item.label} ${required}</label>
				<div class="${item.type}">
					<select class="form-control stores" data-selected="" id="f${i}" name="f${i}"></select>
				</div>
			</div>
		</div>`;
	}
	function employees(item,i) {
		var required = (item.required) ? '<span class="text-danger">*</span>':'';
			dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input drag" data-i="${i}" data-item="${dataItem}">
			<div class="form-group">
				<label for="f${i}">${item.label} ${required}</label>
				<div class="${item.type}">
					<select class="form-control emps" data-selected="" id="f${i}" name="f${i}"></select>
				</div>
			</div>
		</div>`;
	}
	function input(item,i) {
		var type = item.type.split('-'),
			required = (item.required) ? '<span class="text-danger">*</span>':'';
			dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input drag" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<label for="f${i}">${item.label} ${required}</label>
					<input id="f${i}" type="${type[1]}" class="form-control">
				</div>
			</div>`;
	}
	function textarea(item,i) {
		var required = (item.required) ? '<span class="text-danger">*</span>':'',
			dataItem = btoa(JSON.stringify(item));
		if (typeof item.rows === 'undefined') item.rows = 3;
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<label for="f${i}">${item.label} ${required}</label>
					<textarea rows="${item.rows}" class="form-control"></textarea>
				</div>
			</div>`;
	}
	function options(item,i) {
		var required = (item.required) ? '<span class="text-danger">*</span>':'',
			dataItem = btoa(JSON.stringify(item)),
			formGrp = `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<label for="f${i}">${item.label} ${required}</label>`;
			item.options = (typeof item.options === 'undefined') ? ['one','two']:item.options;
		if (item.type != 'select' ) {
			for (o in item.options) {
				formGrp += `<div class="custom-control custom-${item.type} mb-3">
			      <input type="${item.type}" class="custom-control-input" id="cc${i+o}" name="f${i}">
			      <label class="custom-control-label" for="cc${i+o}">${item.options[o]}</label>
			    </div>`;
			}
		} else {
			formGrp += `<select class="form-control" id="f${i}" name="f${i}">`;

			for ( o in item.options ) 
				formGrp += `<option value="${item.options[o]}">${item.options[o]}</option>`;

			formGrp += `</select>`;
		}

		formGrp += '</div></div>';
		return formGrp;
	}
	function file(item,i) {
		var required = (item.required) ? '<span class="text-danger">*</span>':'',
			dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<div class="file-upload">
						<input data-label="${item.label}" type="file" class="custom-file-input" id="f${i}" name="f${i}" accept="image/*">
						<label class="d-flex align-items-center">
							<div class="mr-2"><img src="${window.app.public}/icons/upload.png" alt="Upload Icon" /></div>
							<div>
								<span>Upload ${item.label} ${required}</span>
								<div class="_file_info"></div>
							</div>
						</label>
					</div>
				</div>
			</div>`;
	}
	function sign(item,i) {
		var dataItem = btoa(JSON.stringify(item)),
			required = (item.required) ? '<span class="text-danger">*</span>':'';
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
			<div class="form-group">
				<label for="f${i}">${item.label} ${required}</label>
				<div class="${item.type}">
					<div id="f${i}"><span class="clear">Clear</span></div>
				</div><textarea id="f${i}_exp" style="display:none;"></textarea></div>
			</div>`;
	}
	function image(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		if (typeof item.url == 'undefined') item.url = window.app.url+'/public/uploads/icons/upload.png';
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
			<div class="form-group">
				<label>${item.label}</label>
				<div class="${item.type}"><img src="${item.url}" class="img-fluid" /></div>
			</div>				
			</div>`
	}
	function brief(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		if (typeof item.brief == 'undefined') item.brief = '';
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
				<div class="form-group">
					<label>${item.label}</label>
					<div class="${item.type}">${item.brief}</div>
				</div>
			</div>`;
	}
	function sign_init(id) {
		$(id).signature(); 
 		$(id + ' .clear').click(function() { $(id).signature('clear'); });
 		$(id).signature({syncField: `${id}_exp`,syncFormat: 'JSON'});
	}

	function saveForm() {
		$('.save-form-btn').on('click', function() {
			let btn = $(this),
				form_url = window.app.url + '/'+window.app.role+'/form-builder/m/';
			btn.attr('disabled','disabled');
			$.post(form_url+form.id, form)
			 .done(function (res) {
				if ( form.id == 0 ) window.open(form_url+res.form_id, '_self');
				if (res.success) {
					window.app.flash('success',res.message);
					btn.removeAttr('disabled');
				} else {
					window.app.flash('error', 'Something went wrong!');
				}
			 })
		})
	}
	
})
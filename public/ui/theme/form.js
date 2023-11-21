$(document).ready(function () {

	var elements = $('.elements'),
		setting = $('.element-setting');
	setting.hide();
	elements.hide();

    window.onload = function () {
        $('select.form-control').select2();
    }
	
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

	$('.form').on('mouseenter', function () { $(this).find('.trigger').slideDown();})
	$('.form').on('mouseleave', function () { $(this).find('.trigger').slideUp();})

	var form = window.form;
	generate_form(form['data']);
	function generate_form(form) {
		$('.layout').html('');
		for ( i in form ) make_element(form[i],i);
		$('.layout .selected').removeClass('selected');
		$('.layout').append('<button class="btn btn-primary btn-lg mt-4 save-form-btn">Submit</button>');
		for ( i in form ) if( form[i].type === 'sign' ) sign_init(`#f${i}`);
		saveForm();	
		file_uploder();
		window.app.stores();
		window.app.employees();
	}

	function file_uploder() {
		$('input[type="file"]').on('change', function() {
			let _file = this.files[0];
			console.log(this.files.length);
			let info = 'No file selected';
			if (this.files.length > 0) {
				info = `${_file.name} | ${(_file.size / 1024).toFixed(2)} KB`;
			}
			$(this).prev('label').find('._file_info').html(info);
		})
	}

	function make_element(item,i) {
		var content = '';
		(item.type == 'image') ? delete item.required : '';
		if ( item === 'row' ) {
			$('.layout .selected').removeClass('selected');
			content = `<div class="row form-row selected" data-item="row" data-i="${i}"></div>`;
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
			if (item.required === 'true') content = content.split('form-group').join('form-group required');

			if ( item.required === 'true' && item.type !== 'file') 
				content = content.split('</label>').join('<span class="text-danger">*</span></label>');
			
				if (item.required === 'true' && item.type === 'file')
				content = content.split('</span>').join('<span class="text-danger">*</span></span>');

			$('.layout .selected').append(content);
		}
	}
	
	function en_setting(i) {
		elements.hide();
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

		$('#image').unbind();
		setting.find('#image').hide();
		if (form['data'][i].type === 'image') {
			var img = $('#image');
			img.attr('src', form['data'][i].url);
			img.show();

			img.on('click', function () {
				let imgURL = prompt("Please enter Image URL", "");
				if ( imgURL != null ) img.attr('src', imgURL);
				form['data'][i].url = imgURL;
			})
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
		})
	}

	function update_item(i,item) {
		i = parseInt(i);
		form.data[i] = item;
		console.log(form.data,i,item);
		generate_form(form.data);
		en_setting(i);
	}

	function stores(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input drag" data-i="${i}" data-item="${dataItem}">
			<div class="form-group">
				<label for="f${i}">${item.label}</label>
				<div class="${item.type}-container">
					<select data-label="${item.label}/stores" class="stores" data-selected="" id="f${i}" name="f${i}"></select>
				</div>
			</div>
		</div>`;
	}
	function employees(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input drag" data-i="${i}" data-item="${dataItem}">
			<div class="form-group">
				<label for="f${i}">${item.label}</label>
				<div class="${item.type}">
					<select data-label="${item.label}/employees" class="emps" data-selected="${window.app.employee.id}" id="f${i}" name="f${i}"></select>
				</div>
			</div>
		</div>`;
	}

	function blank(item,i) {
		return `<div class="col-${item.col} empty" data-i="${i}" data-item="${btoa('{"col":'+item.col+'}')}"></div>`;
	}
	function input(item,i) {
		var type = item.type.split('-'),
			dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input drag" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<label for="f${i}">${item.label}</label>
					<input data-label="${item.label}" id="f${i}" type="${type[1]}" name="f${i}" class="form-control">
				</div>
			</div>`;
	}
	function textarea(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		if (typeof item.rows === 'undefined') item.rows = 3;
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<label for="f${i}">${item.label}</label>
					<textarea rows="${item.rows}" data-label="${item.label}" name="f${i}" id="f${i}" class="form-control"></textarea>
				</div>
			</div>`;
	}
	function options(item,i) {
		var dataItem = btoa(JSON.stringify(item)),
			formGrp = `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<label for="f${i}">${item.label}</label>`;
			item.options = (typeof item.options === 'undefined') ? ['one','two']:item.options;
		if (item.type != 'select' ) {
			for (o in item.options) {
				formGrp += `<div class="custom-control custom-${item.type} mb-3">
			      <input type="${item.type}" class="custom-control-input" id="cc${i+o}" name="f${i}">
			      <label class="custom-control-label" for="cc${i+o}">${item.options[o]}</label>
			    </div>`;
			}
		} else {
			formGrp += `<select data-label="${item.label}" class="form-control" id="f${i}" name="f${i}">`;
			for ( o in item.options ) formGrp += `<option value="${item.options[o]}">${item.options[o]}</option>`;
			formGrp += `</select>`;
		}

		formGrp += '</div></div>';
		return formGrp;
	}
	function file(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
				<div class="form-group ${item.type}">
					<div class="file-upload">
					    <label for="f${i}" class="d-flex align-items-center">
							<div class="mr-2"><img src="${window.app.public}/icons/upload.png" alt="Upload Icon" /></div>
							<div>
								<span>Upload ${item.label}</span>
								<div class="_file_info">No file selected</div>
							</div>
						</label>
						<input data-label="${item.label}" type="file" class="custom-file-input" id="f${i}" name="f${i}" accept="image/*">
					</div>
				</div>
			</div>`;
	}
	function sign(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		return `<div class="col-${item.col} form-input" data-i="${i}" data-item="${dataItem}">
			<div class="form-group">
				<label for="f${i}">${item.label}</label>
				<div class="${item.type}">
					<div id="f${i}"><span class="clear">Clear</span></div>
				</div><textarea id="f${i}_exp" data-label="${item.label}" name="f${i}_exp" style="display:none;"></textarea></div>
			</div>`;
	}
	function image(item,i) {
		var dataItem = btoa(JSON.stringify(item));
		if (typeof item.url == 'undefined') item.url = 'https://via.placeholder.com/100x100';
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
 		$(id).signature({syncField: `${id}_exp`,syncFormat: 'PNG'});
	}

	function saveForm() {
		$('#form').submit(function(e) {
            e.preventDefault();            
            let formData = new FormData(),
				form = $(this).serializeArray(),
				files = $('#form [type="file"]'),
				info = {},
				btn = $('.save-form-btn'),
				emp = $('.emps');

				btn.attr('disabled','disabled').after('<div class="mt-2 form-flash-msg"><span><i class="fas fa-spin fa-sync"></i> Sending please wait...</span></div>');

				if(emp.length > 0) form.push({name:"employee",value:emp[0].value})

				files.each(function () {
					let label = $(this).data('label'),
					name = $(this).attr('name'),
					file = this.files[0];
					info[name] = label;
					form.push({name:name,value:file});
					formData.append(name,file);
			});

			form.map(function(item,i) {
				let label = $('#'+item.name).data('label');
				info[item.name] = label;
				formData.append(item.name,item.value);
			});			
			formData.append('__info',JSON.stringify(info));
			if ( validate() ) {
				$.ajax({      
					type: 'POST',
					url: window.location.href,
					data: formData, 
					success: function (data) { 
						if (data.success) {
							window.app.flash(data.type, data.msg);
							generate_form(window.form.data);
							setTimeout(function() { 
								let {href} = window.location;
								if(href.includes('?src=')) {
									let redURL = atob(href.split('?src=')[1]);
									window.location.href = redURL;
								} else {
									window.location.reload(); 
								}
							},1000)
						}
					},
					error: function(err) {
						console.log(formData);
					},
					cache: false,
					contentType: false,
					processData: false
				});
			} else {
				btn.removeAttr('disabled').next().remove();
			}
		})

		function validate() {
			let validation = true;
			$('.tmp-msg').remove();
			$('.required').each(function() {
				let input = $(this).find('[name]');
				if ( input.val() == "" || input.val() == '') {
					$(`#${input.attr('id')}`).after('<span class="tmp-msg text-danger">This Field is required</span>');
					validation = false;
				}
			});
			return validation;
		}
	}
	
})
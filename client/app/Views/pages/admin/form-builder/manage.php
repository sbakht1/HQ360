<link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.css">
<style type="text/css">
	.card {border-radius: 20px;}
	.elements {display: flex;flex-wrap:wrap;align-items: center;}
	.elements a {flex:calc(50% - 20px);padding:10px;background:#eee;margin:10px;border-radius:10px;color:#333;padding:15px 15px;}
	.elements i {display: inline-block;padding-right: 10px;}
	.trigger input {text-align:center;border:0;margin:0 10px}
	.trigger,.form-element {display: block;color: #333;background: #eee;padding: 10px;font-size: 24px;margin: 15px 15px;text-align: center;border-radius: 10px;}
	.trigger a:hover,.form-element:hover {text-decoration: none;color: #444;}
	.trigger {display: none;}
	.form-group {border:1px dashed transparent;padding:10px}
	.col.selected .form-group {border-color: #ccc}
	.kbw-signature {display:block;min-height:300px;position:relative}
	.kbw-signature .clear {position:absolute;bottom:5px;right:10px;cursor: pointer;}
	.ui-droppable-hover {background-color: #eee;}
	/*.layout div[class*="col"]:not(.active) {border: 1px solid #eee;}*/
	.layout .active {border:1px solid red;}
	.form {height:calc(100vh - 100px);overflow:scroll;}
	.form::-webkit-scrollbar{width:5px;transform:translateX(-10px)}
	.form::-webkit-scrollbar-thumb {background:#ddd}
	.opt {display:flex;align-items:center;margin-bottom: 10px;}
	.opt i {padding:0 10px;cursor:pointer;}
	.form-group.input-price {position:relative;}
	.input-price:after {content:"\24";font-family: "Font Awesome 6 Free";font-weight: 900;position: absolute;left: 25px;bottom: 25px;color: #333;}
	.input-price input {padding-left: 26px;}
	textarea.form-control {resize: none;}
	.element-setting ul {list-style: none;padding: 0;}
	.form-row {position: relative;border: 1px dashed transparent;}
	.input-action,.form-input label {transition: .5s ease 0s;}
	.input-action {opacity: 0;z-index: 999999; cursor: pointer;}
	.input-action {position: absolute;height: 20px}
	.form-row .input-action {right: 0;}
	.form-input .input-action {left: 0px;}
	.form-row .input-action {top: -15px;}
	.form-input .input-action {top: 10px;}
	.form-input:hover label:not(.custom-control label,.custom-file label) {margin-left: 30px;}
	.form-input:hover .input-action,
	.form-row:hover > .input-action {opacity: 1;}
	.form-input:hover .input-action {left: 20px;}
	.form-row:hover .input-action {right: 20px;}
	.form-row:hover {border-color: #ccc;}
	.input-action i {background-color: var(--danger);color: #fff;display: inline-block;width: 24px;line-height: 24px;border-radius: 50%;text-align: center;font-size: 12px;}
	#form_title {padding-left: 1px;}
	#form_title:focus {border-bottom: 2px solid red;outline: none;padding-right: 5px;}
	#form_title:after {content:"\f304";font-family:"Font Awesome 6 Free";font-weight:900;font-size:20px;padding-left:20px}
	#form_title:focus:after {display:none;}
	.form-row {position:relative;}
	.form-row:after {content:'\f0b2';font-family:'fontawesome';top: 10px;position:absolute;left: -7.5px;transform: rotate(45deg);opacity: 0;}
	.form-row:hover::after {opacity:1;z-index:9999;}
	#urgent_message {display:none;}
	.page-header {margin-bottom:0px;}
	.form-subs {margin-bottom: 20px;}

	</style>

<script>
window.form = <?= json_encode($form);?>
</script>
<div class="form-subs">
	<?php if(user_data('Title')[1] == 'admin' && $form['id'] != 0): ?>
		<a href="<?= base_url('admin/form-builder/collection/'.$form['id']);?>" class="btn btn-primary">Form Collections</a>
	<?php endif;?>
</div>
<section class="mt-2">
<div class="row">
	<div class="col-md-9">
		<div class="card shadow form">
			<div class="card-body">
				<h2><span id="form_title"></span></h2>
				<div class="layout"></div>
				<div class="trigger">
					Add
					<input type="number" name="cols" class="cols" min="1" max="4" value="1"> column
					<a href="#" class="addrow">in Form</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="top-fixed">
			<div class="card">
				<div class="elements card-body">
					<a href="#stores" data-item="stores"><i class="fa-solidfa-store fa-font"></i> Stores</a>
					<a href="#employees" data-item="employees"><i class="fa-solid fa-user fa-font"></i> Employees</a>
					<a href="#input-text" data-item="input-text"><i class="fa-solid fa-font"></i> Single Line Text</a>
					<a href="#textarea" data-item="textarea"><i class="fa-solid fa-align-left"></i> Paragraph Text</a>
					<a href="#select" data-item="select"><i class="fa-solid fa-list"></i> Dropdown List</a>
					<a href="#checkbox" data-item="checkbox"><i class="fa-solid fa-list-check"></i> Multiple Choice</a>
					<a href="#input-phone" data-item="input-tel"><i class="fa-solid fa-phone"></i> Phone Number</a>
					<a href="#input-date" data-item="input-date"><i class="fa-regular fa-calendar"></i> Date Field</a>
					<a href="#email-add" data-item="input-email"><i class="fa-regular fa-envelope"></i> Email Address</a>
					<a href="#input-price" data-item="input-price"><i class="fa-regular fa-dollar-sign"></i> Price Field</a>
					<a href="#input-file" data-item="file"><i class="fa-solid fa-arrow-up-from-bracket"></i> File Upload</a>
					<a href="#sign-pad" data-item="sign"><i class="fa-solid fa-signature"></i> Signature</a>
					<a href="#image" data-item="image"><i class="fa-solid fa-image"></i> Add Image</a>
					<a href="#desc" data-item="brief"><i class="fa-solid fa-newspaper"></i> Description</a>
				</div>
				
				<div class="element-setting card-body">
					<div class="form-group">
						<label for="lab">Label</label>
						<input type="text" name="element-label" class="form-control" id="lab">
					</div>
					<div class="form-group">
						<div class="form-check form-check-primary">
							<label class="form-check-label" for="req">
								<input type="checkbox" class="form-check-input" id="req" name="required">Required
								<i class="input-helper"></i>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="brief">Brief</label>
						<textarea class="form-control" rows="5" id="brief"></textarea>
					</div>
					<div class="form-group">
						<label for="textarea">Rows</label>
						<input class="form-control" onfocus="$(this).blur()" id="textarea" value="" min="3" max="15" type="number">
					</div>
					<div class="form-group" id="image">
						<h4 class="card-title">Upload Image</h4>
						<input data-name="<?= time(); ?>" type="file" class="dropify" data-allowed-file-extensions="png jpg jpeg gif webp" />
					</div>
					<div class="form-group" id="checkType">
						<label>Choice Type</label>
						<ul>
							<li>
								<div class="form-check form-check-primary">
									<label class="form-check-label" for="type1">
										<input type="radio" class="form-check-input" id="type1" name="type" value="checkbox">
										Multiple Selection
										<i class="input-helper"></i></label>
									</div>
							</li>
							<li>
								<div class="form-check form-check-primary">
									<label class="form-check-label" for="type2">
										<input type="radio" class="form-check-input" id="type2" name="type" value="radio">
										Single Selection
										<i class="input-helper"></i></label>
									</div>
							</li>
						</ul>
					</div>
					<div class="options"></div>
					<div class="form-actions clearfix">
						<a href="#" class="btn btn-light add-opt"><i class="fa-solid fa-plus"></i> Add option</a>
						<a href="#" class="btn btn-primary float-right save-btn"><i class="fa-solid fa-save"></i> Save</a>
					</div>
				</div>

				
			</div>
			<div class="form-setting mt-4">
				<?= card('start');?>
				<h3>Form Setting</h3>
				<?= select2(['type','Visibility',['Public','Logged In Employees','Title Base Employees','Select Individual Employees'],$form['type']]); ?>
				<div id="title_base_employees" class="d-none hidden-set">
					<?= select2(['title','Select Titles',ROLES,''],'multiple'); ?>
				</div>
				<div id="select_individual_employees" class="d-none hidden-set">
					<div class="form-group">
						<label for="employees">Select Employees</label>
						<select name="employees" id="employees" class="emps" multiple></select>
					</div>
				</div>
				<?= select2(['status','Status',['Draft','Publish'],$form['status']]); ?>
				<?= card('end');?>
			</div>
		</div>
	</div>
</div>
</section>
<script defer="defer" src="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.js"></script>
<script defer="defer" type="text/javascript" src="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.min.js"></script>
<script defer="defer" type="text/javascript" src="<?= base_url(UI['main']);?>/theme/form-builder.js"></script>
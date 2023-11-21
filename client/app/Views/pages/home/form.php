<?php
	$show_form = true;
	$ses = session('user_data');
	
	if (!$form || $form['status'] !== 'Publish') $show_form = false;

	if (empty($ses) && $form['type'] !== "Public") $show_form = false;
	
	if (@$form['meta'] && !empty($ses)) {
		if ($form['type'] == 'Logged In Employees') $show_form = false;

		if ( $form['type'] == 'Select Individual Employees' && !in_array($ses['EmployeeID'], $form['meta'])) 
			$show_form = false;

		if ( $form['type'] == 'Title Base Employees' && !in_array($ses['Title'][0],$form['meta'])) 
			$show_form = false;
	}
?>

 <link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.css">
<style type="text/css">
    main { min-height:100vh;display:flex;align-items:center;}
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
	.layout .active {border:1px solid red;}
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
	.input-action i {background-color: var(--danger);color: #fff;display: inline-block;width: 24px;line-height: 24px;border-radius: 50%;text-align: center;font-size: 12px;}
	.form-row {position:relative;}
    .form-input label {font-weight: 600;}
	#urgent_message {display:none;}
	</style>

<script>
    window.form = <?= json_encode($form);?>
</script>

<main class="bg-primary">
<section class="container py-5">
<div class="row justify-content-center">
	<div class="col-md-9">
        <div class="card shadow form">
            <div class="card-body">
				<?php if (!$show_form): ?>
					<h2 class="text-center py-5">Form Not Found!</h2>
				<?php else : ?>
					<h2><span id="form_title"><?= $form['title'];?></span></h2>
					<hr>
					<form class="layout" id="form"></form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
</section>
</main>
<script defer="defer" src="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.js"></script>
<script defer="defer" type="text/javascript" src="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.min.js"></script>
<script defer="defer" type="text/javascript" src="<?= base_url(UI['main']);?>/theme/form.js"></script>
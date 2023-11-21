<style>
#pulse {background-color:#183d79;}
#pulse .modal-content {background-color:#e67336;border:0;color:#fff;border-radius:0;}
#pulse .modal-dialog {margin:auto;display:flex;align-items:center;min-height:100vh;}
#pulse .modal-content [data-dismiss="modal"] {display:none;}
#pulse .pulse-logo {background-color:#fff; margin-top:-100px;margin-bottom:20px;text-align:center;padding: 20px 0;border-radius:30px}
#pulse .pulse-logo img {max-width:250px;}
#pulse .rate + .br-widget a:nth-child(1) {display:none;}
</style>
<?= modal(['pulse']); ?>
<div class="pulse-logo"><img src="<?=base_url(UI['main']);?>/images/logo-twe.png" alt="logo"/></div>
<h2>Daily Pulse</h2>
<hr>
<form action="#" id="mood">
<label>Rate your happiness with your job</label>
<select class="rate" id="feeling" name="feeling" autocomplete="off">
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
</select>
<label>Rate your Overall Happiness</label>
<select class="rate" id="happiness" name="happiness" autocomplete="off">
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
</select>
<button class="btn btn-primary mt-3">Submit</button>
</form>
<?= modal();?>
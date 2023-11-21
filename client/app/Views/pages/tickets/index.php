<?php 
    $from = (@$_GET['from']) ? $_GET['from'] : date('Y-m-d', strtotime('-1 month'));
    $to = (@$_GET['to']) ? $_GET['to'] : date('Y-m-d');
    $role = user_data('Title')[1];

    // debug($_SERVER);
?>
<script>
    window.ticketAPI = '/tickets/find/'
    window.ticket = {
        all: '/tickets/find',
        single:'/tickets/view/'
    }
</script>
<div class="actions">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="collapse" data-target="#filters">Filter</button>
    <?php if($role !== 'admin') : ?>
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Open New Ticket</button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="<?= base_url('/tickets/new');?>">Inventory</a>
        <a class="dropdown-item" href="<?= base_url('/tickets/new?department=it');?>">IT</a>
        <a class="dropdown-item" href="<?= base_url('/tickets/new?department=hr');?>">HR</a>
    </div>
    <?php else: ?>
        <a href="<?= base_url('/tickets/new')."?".$_SERVER['QUERY_STRING'];?>" class="btn btn-outline-primary">Open New Ticket</a>
    <?php endif;?>
</div>

<div class="filters collapse" id="filters">
    <div class="row justify-content-end mb-4">
        <div class="col-md-6">
            <?= card('start');?>
            <form id="filter_form">
                <input type="hidden" name="department" value="<?= @$_GET['department'];?>">
                <div class="row">
                    <div class="col-md-3"><?= form_input(['from','From','date',$from]);?></div>
                    <div class="col-md-3"><?= form_input(['to','To','date',$to]);?></div>
                    <div class="col-md-3"><?= select2(['status','Status',array_merge(['All'],TICKET_STATUS),@$_GET['status']]);?></div>
                    <div class="col-md-3 d-flex align-items-center"><div><button class="btn btn-primary">Filter</button></div></div>
                </div>
            </form>
            <?= card('end');?>
        </div>
    </div>
</div>

<?= card('start');?>
<div id="ticketGrid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>

<script defer="" src="<?= base_url(UI['main']);?>/ag-grid/tickets.js"></script>

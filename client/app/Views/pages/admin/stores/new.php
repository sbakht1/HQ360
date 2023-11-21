<form action="" method="post" id="new_store">
<div class="row">
    <div class="col-md-6">
        <?= card('start');?>
        <div class="row">
            <div class="col-md-6"><?= form_input(['StoreName','Store Name*','text','']);?></div>
            <div class="col-md-6"><?= form_input(['Abbreviation','Abbreviation*','text','']);?></div>
            <div class="col-md-8"><?= form_input(['LongName','Long Name','text','']);?></div>
            <div class="col-md-4"><?= form_input(['State','State*','text','']);?></div>
            <div class="col-md-4"><?= form_input(['City','City*','text','']);?></div>
            <div class="col-md-4"><?= form_input(['Zip','Zip*','text','']);?></div>
            <div class="col-md-4"><?= form_input(['LocationCode','Location Code','text','']);?></div>
            <div class="col-md-4"><?= form_input(['DistrictName','District Name','text','']);?></div>
            <div class="col-md-4"><?= form_input(['RegionName','Region Name','text','']);?></div>
            <div class="col-md-4"><?= form_input(['PlazaName','Plaza Name','text','']);?></div>
            <div class="col-md-12"><?= form_input(['Address','Address*','text','']);?></div>
        </div>
        <?= card('end');?>
    </div>
    
    <div class="col-md-6">
        <?= card('start');?>
        <div class="row">
            <div class="col-md-4"><?= selection(['ManagerID','Manager*','emps','']);?></div>
            <div class="col-md-4"><?= selection(['DMID','District Manager*','emps','']);?></div>
            <div class="col-md-4"><?= selection(['RMID','Regional Manager*','emps','']);?></div>
            <div class="col-md-6"><?= form_input(['SystemNotificationPhoneNumber','Notification Phone #','tel','']);?></div>
            <div class="col-md-6"><?= form_input(['MainPhoneNumber','Main Phone #','tel','']);?></div>
            <div class="col-md-6"><?= form_input(['ShoppertrakID','Shopper trak ID','text','']);?></div>
            <div class="col-md-6"><?= form_input(['IPAddress','IP Address','text','']);?></div>
            <div class="col-md-6"><?= form_input(['QBClass','QB Class','text','']);?></div>
            <div class="col-md-6"><?= form_input(['OpusId','Opus ID','text','']);?></div>
           
        </div>
        <?= card('end');?>
    </div>
</div>
<button class="btn btn-lg btn-primary mt-4">Save Store</button>
</form>

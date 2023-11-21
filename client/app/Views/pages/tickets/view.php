<style>
    .ticket-info strong {display:block;}
    .title {font-size:16px;}
    .img-md {height:70px;width:70px;}
    .bg-img-md {min-height:200px;display:block;box-shadow:inset 0 0 10px 0px #000;background-repeat: no-repeat;}
    .img-contain {background-size:contain;background-position:center;}
    .caps {text-transform:uppercase;}

    .chat-box {height: 400px;overflow-y:scroll;padding:0 10px;}
    #msg {width:100%;background-color:#eee;border:none;border-radius:10px;display:block;padding:20px;}
    .msg-box {position:relative;background-color:#eeeeee;border-radius:10px;}
    /* .msg-box .btn {position:absolute;right:10px;bottom:10px;} */

    .single-msg {margin-bottom:15px}
    .msg {display:inline-block;background-color:#ddd;padding:10px 20px;border-radius:0 20px 20px 20px}
    .sender,.time {font-size:12px;display:block;}
    .time {opacity:.3;display:block;transition:.5s ease;}
    .single-msg:hover .time {opacity:1;}

    .single-msg.not-you {text-align:right;}
    .chat-box::-webkit-scrollbar {width: 5px;}
    .chat-box::-webkit-scrollbar-track {background: transparent; }
    .chat-box::-webkit-scrollbar-thumb {background: #ed772d; }
    .chat-box::-webkit-scrollbar-thumb:hover {background: #555; }
    #status_form .btn {margin-top: 27px;line-height: 25px;}
    
    .not-you .msg {background-color:#0f3c7a;color:#fff;border-radius:20px 0 20px 20px;}
    .not-you .time {text-align:right;}
    a.d-flex:hover {text-decoration:none;}

    .form-actions:after {content:'';clear:both;display:block;}
    .form-actions .left {float:left;margin-right:15px;}
    .form-actions .right {float:right;margin-right:15px;}

    .attachments-sections,
    .attachments-sections:hover {color:#333;text-decoration:none;display:flex;padding:10px;align-items:center;background-color:#ddd;margin-bottom:1px;border-radius:10px;max-width:250px;}
    .thumb {font-size:36px;margin-right:15px;}
    .details .file-name {margin:0;}
    .single-msg.not-you .attachments-sections {margin-left: auto;background: #0f3c7a;color: #fff;text-align: left;}
    span.selected_file {display: inline-block;margin: 7px 7px 7px -10px;color: red;}
</style>
<script>
    window.ticket = <?= json_encode($ticket);?>;
</script>
<div class="row">
    <div class="col-md-4 ticket-info">
        <?= card('start');?>
        <table class="table">
            <tr>
                <td colspan="2">
                    <a class="d-flex align-items-center" href="<?= base_url('admin/stores/'.$ticket['store']['StoreID']);?>">
                        <div class="img">
                            <img src="<?= base_url(UI['upload'].'/'.$ticket['store']['image']);?>" alt="Store" class="img-sm rounded-circle mr-2">
                        </div>
                        <div class="text-black">
                            <small>Store</small>
                            <strong class="title"><?=$ticket['store']['StoreName'];?></strong>
                            <span><?=$ticket['store']['Address'];?></span>
                        </div>
                    </a>
                </td>
            </tr>
            <tr>
            <td colspan="2">
                <a class="d-flex align-items-center" href="<?= base_url('admin/employees/'.$ticket['submit_by']['id']);?>">
                    <div class="img">
                        <img src="<?= base_url(UI['upload'].'/'.$ticket['submit_by']['image']);?>" alt="Store" class="img-sm rounded-circle mr-2">
                    </div>
                    <div class="text-black">
                        <small>Employee</small>
                        <strong class="title"><?=$ticket['submit_by']['Employee_Name'];?></strong>
                        <span><?= $ticket['submit_by']['Title'];?></span>
                    </div>
                </a>
            </td>
            </tr>
            <tr>
                <th>TICKET ID</th>
                <td><?= $ticket['TicketID'];?></td>
            </tr>
            <tr>
                <th>STATUS</th>
                <td><?= $ticket['status'];?></td>
            </tr>
            <tr>
                <th><span class="caps">Department</span></th>
                <td><?= $ticket['assign_to'];?></td>
            </tr>
            <tr>
                <th><span class="caps">Last Updated</span></th>
                <td><span class="user_time" data-time="<?= $ticket['updated'];?>" data-form="lll"></span></td>
            </tr>
            <tr>
                <th><span class="caps">Created</span></th>
                <td><span class="user_time" data-time="<?= $ticket['created'];?>" data-form="lll"></span></td>
            </tr>
            <?php foreach($ticket['data'] as $k=>$v) : $name = str_replace(['-','_'],' ',$k);?>
            <?php if ( $k != 'upload-image' && $k != 'upload-an-image-or-pdf'):?>
                <tr class="<?= $k;?>">
                    <th class="caps"><?= $name;?></th>
                    <td><?= $v;?></td>
                </tr>
            <?php endif;?>
            <?php endforeach;?>
        </table>
        
        <div class="row mt-5">
            <?php if (@$ticket['data']['upload-image']) : ?>
            <div class="col-6">
                <span class="name">Uploaded Image</span>
                <div class="mt-3"></div>
                <a href="<?= base_url(UI['upload']) .'/'. $ticket['data']['upload-image'];?>" style="background-image:url(<?=base_url(UI['upload']) .'/'. $ticket['data']['upload-image']?>)" class="bg-img-md img-contain"></a>
            </div>
            <?php endif;?>
            <?php if (@$ticket['data']['upload-an-image-or-pdf']) : ?>
            <div class="col-6">
                <span class="name">UPLOAD AN IMAGE OR PDF</span>
                <div class="mt-3"></div>
                <a href="<?= base_url(UI['upload']) .'/'. $ticket['data']['upload-an-image-or-pdf'];?>" style="background-image:url(<?=base_url(UI['upload']) .'/'. $ticket['data']['upload-an-image-or-pdf']?>)" class="bg-img-md img-contain"></a>
            </div>
            <?php endif;?>
        </div>
        <?= card('end');?>
    </div>

    <div class="col-md-8">
        <?= card('start');?>
            <h4>Comments</h4>
            <hr>
            <div class="chat-box">
            <?= loader('Loading comments...');?>
            </div>
            <form class="msg-box" id="msgForm">
                <input type="hidden" name="ticket" value="<?= $ticket['TicketID']; ?>">
                <textarea name="msg" id="msg" rows="3" placeholder="Type your message here..."></textarea>
                <div class="form-actions">
                    <input type="file" accept="image/*,video/*" name="file" class="d-none" id="file">
                    <label for="file" class="btn left"><i class="fas fa-paperclip"></i> Upload</label>
                    <button class="btn btn-inverse-success btn-sm right send-btn">SEND</button>
                </div>
            </form>

            <div id="status_form">
                <input type="hidden" name="ticket" value="<?= $ticket['TicketID'];?>">
                <div class="row mt-4">
                    <div class="col-md">
                        <?= select2(['status','Status',TICKET_STATUS,$ticket['status']]);?>
                    </div>
                    <?php if($ticket['department'] == 'IT'):?>
                    <div class="col-md-2">
                        <?= select2(['level','Level',["Select","Level 1","Level 2","Level 3","Level 4"],@$ticket['level']]);?>
                    </div>
                    <?php endif;?>
                    <div class="col-md-2">
                        <?= select2(['assign_to','Assigned',["Inventory","IT","HR"],$ticket['assign_to']]);?>
                    </div>
                    <div class="col-md">
                        <label style="margin-bottom:7px;" for="assign_emp">Assigned Employee</label>
                        <select name="assign_emp" id="assign_emp" class="emps" data-selected="<?=$ticket['assign_emp'];?>"></select>
                    </div>
                    <div class="col-md-2">
                        <button class="mt-4 btn btn-block btn-primary">Update</button>
                    </div>
                </div>
            </div>
        <?= card('end');?>
    </div>

                
        
</div>
<script defer="defer" src="<?= base_url(UI['main']);?>/theme/tickets.js"></script>
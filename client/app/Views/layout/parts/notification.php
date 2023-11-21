<?php 

    $colors = ["danger","primary","warning","success","info"];
    $icons  = [
        "employee"         => "fas fa-wrench",
        "ticket"           => "fas fa-ticket-simple",
        "news"             => "fas fa-newspaper",
        "hub"              => "fas fa-address-card",
        "article"          => "fas fa-book-open-reader",
        "observations"     => "fas fa-suitcase",
        "connection"       => "fas fa-suitcase",
        "Form Submission"  => "fas fa-file-pen",
        "ticket/Inventory" => "fas fa-ticket-simple",
        "ticket/IT"        => "fas fa-ticket-simple",
        "ticket/HR"        => "fas fa-ticket-simple"
      ];
  

    // real data
    $notes = get_notification_by_user();
    $read_notes = get_readed_notes();

    $count = 0;
    foreach($notes as $i => $n):
     if(profile('Title') == 'Administrator'):
        $count++;
      elseif(profile('EmployeeID') !== $n['usr_from']):
        $count++;
      endif;
    endforeach;

  $count_readed = count($read_notes);
  $total = $count-$count_readed;
  
?>

<li class="nav-item dropdown">
    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
        <i class="fas fa-bell mx-0"></i>
        <?php if(!empty($notes)) : ?>
            <span class="count" id="counter"> 
                  <?php   if(!empty($notes)): echo $count; else: echo "0"; endif;?>  
            </span>
        <?php endif;?>
      </a>
     
   <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" style="overflow-x:hidden  !important;overflow-y:scroll !important;">
        <a class="dropdown-item" href="<?=base_url() . '/notification'?>">
            <p class="mb-0 font-weight-normal float-left">You have <span class="count"><?php if(!empty($notes)): echo $count; else: echo "0"; endif; ?></span> new notifications</p>
            <span class="badge badge-pill badge-warning float-right" id="viewAll1" style="cursor:pointer !important">View all</span>
        </a>
           <form class="notes_form" id="notes-save">
            <?php 
            //debug($notes);
            if(!empty($notes)): foreach($notes as $i => $n): 
                  if ($i > 4) $i = 0; $cname = $n['category']; 
             ?>
            <?php if(profile('Title') == 'Administrator'): ?>
            <div class="dropdown-divider"></div>
            <a 
            <?php if($cname == "Form Submission"): ?> 
                  href="<?=base_url("/".user_data('Title')[1]).$n['description']?>"
            <?php endif;?>
            <?php if(strpos($cname,'ticket') !== false): $cname = 'ticket'; ?> 
                  href="<?=base_url()?>/tickets/view/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'observations'): ?>
                  href="<?=base_url()?>/<?php if(profile('Title') == 'Administrator'): echo "/admin/"; elseif(profile('Title') == 'District Team Leader'): echo "/district-team-leader"; elseif(profile('Title') == 'Store Team Leader'): echo "/store-team-leader"; elseif(profile('Title') == 'Human Resource'): echo "/human-resource"; elseif(profile('Title') == 'Inventory'): echo "/inventory"; elseif(profile('Title') == 'IT'): echo "/it"; elseif(profile('Title') == 'Salespeople'): echo "/salespeople";   endif; ?>/observations/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'connection'): ?>
                  href="<?=base_url()?>/<?php if(profile('Title') == 'Administrator'): echo "/admin/"; elseif(profile('Title') == 'District Team Leader'): echo "/district-team-leader"; elseif(profile('Title') == 'Store Team Leader'): echo "/store-team-leader"; elseif(profile('Title') == 'Human Resource'): echo "/human-resource"; elseif(profile('Title') == 'Inventory'): echo "/inventory"; elseif(profile('Title') == 'IT'): echo "/it"; elseif(profile('Title') == 'Salespeople'): echo "/salespeople";  endif; ?>/connections/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'employee'): ?>
                  href="<?=base_url()?>/<?php if(profile('Title') == 'Administrator'): echo "/admin/"; elseif(profile('Title') == 'District Team Leader'): echo "/district-team-leader"; elseif(profile('Title') == 'Store Team Leader'): echo "/store-team-leader"; elseif(profile('Title') == 'Human Resource'): echo "/human-resource"; elseif(profile('Title') == 'Inventory'): echo "/inventory"; elseif(profile('Title') == 'IT'): echo "/it"; elseif(profile('Title') == 'Salespeople'): echo "/salespeople";  endif; ?>/employees/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'article' ): ?>
                  href="<?=base_url()?>/articles/<?php echo $n['url_id']; ?>"
            <?php elseif($cname == 'news'): ?>
                  href="<?=base_url()?>/news/<?php //echo $n['url_id']; ?>"
            <?php elseif($cname == 'hub'): ?>
                  href="<?=base_url()?>/hubs?category=1/<?php //echo $n['url_id']; ?>"
            <?php endif; ?>
            class="dropdown-item preview-item" onclick="updateNotificationStatus(<?=$n['id'];?>)">
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-<?= $colors[$i]?>"><i class="<?=$icons[$cname];?> mx-0"></i>
                 </div>
                </div>
                <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-medium"><?= $n['detail'];?></h6>
                    <p class="font-weight-light small-text"><span class="user_time" data-time="<?=$n['created'];?>" data-form="now"></span></p>
                  
                </div>
                <div style="text-align:right;float: right;display: block;width: 100%;">
                        <input type="checkbox"  id="chk_<?=$n['id'];?>" >
                </div>
            </a>
            <input type="hidden" id="nid" name="nid[]" value="<?=$n['id'];?>">
         <?php elseif(profile('EmployeeID') !== $n['usr_from']): ?>
            <div class="dropdown-divider"></div>
            <a 
            <?php if($cname == 'ticket/HR' OR $cname == 'ticket/IT' OR $cname == 'ticket/Inventory'): ?> 
                  href="<?=base_url()?>/tickets/view/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'observations'): ?>
                  href="<?=base_url()?>/<?php if(profile('Title') == 'Administrator'): echo "/admin/"; elseif(profile('Title') == 'District Team Leader'): echo "/district-team-leader"; elseif(profile('Title') == 'Store Team Leader'): echo "/store-team-leader"; elseif(profile('Title') == 'Human Resource'): echo "/human-resource"; elseif(profile('Title') == 'Inventory'): echo "/inventory"; elseif(profile('Title') == 'IT'): echo "/it"; elseif(profile('Title') == 'Salespeople'): echo "/salespeople";   endif; ?>/observations/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'connection'): ?>
                  href="<?=base_url()?>/<?php if(profile('Title') == 'Administrator'): echo "/admin/"; elseif(profile('Title') == 'District Team Leader'): echo "/district-team-leader"; elseif(profile('Title') == 'Store Team Leader'): echo "/store-team-leader"; elseif(profile('Title') == 'Human Resource'): echo "/human-resource"; elseif(profile('Title') == 'Inventory'): echo "/inventory"; elseif(profile('Title') == 'IT'): echo "/it"; elseif(profile('Title') == 'Salespeople'): echo "/salespeople";  endif; ?>/connections/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'employee'): ?>
                  href="<?=base_url()?>/<?php if(profile('Title') == 'Administrator'): echo "/admin/"; elseif(profile('Title') == 'District Team Leader'): echo "/district-team-leader"; elseif(profile('Title') == 'Store Team Leader'): echo "/store-team-leader"; elseif(profile('Title') == 'Human Resource'): echo "/human-resource"; elseif(profile('Title') == 'Inventory'): echo "/inventory"; elseif(profile('Title') == 'IT'): echo "/it"; elseif(profile('Title') == 'Salespeople'): echo "/salespeople";  endif; ?>/employees/<?php echo $n['url_id'];?>"
            <?php elseif($cname == 'article' ): ?>
                  href="<?=base_url()?>/articles/<?php echo $n['url_id']; ?>"
            <?php elseif($cname == 'news'): ?>
                  href="<?=base_url()?>/news/<?php //echo $n['url_id']; ?>"
            <?php elseif($cname == 'hub'): ?>
                  href="<?=base_url()?>/hubs?category=1/<?php //echo $n['url_id']; ?>"
            <?php endif; ?>
            class="dropdown-item preview-item">
                
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-<?= $colors[$i]?>"><i class="<?=$icons[$cname];?> mx-0"></i></div>
                </div>
                <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-medium"><?= $n['detail'];?></h6>
                    <p class="font-weight-light small-text"><span class="user_time" data-time="<?=$n['created'];?>" data-form="now"></span></p>
                   
                </div>
            </a> 
            <input type="hidden" id="nid" name="nid[]" value="<?=$n['id'];?>">
        <?php endif; endforeach;  endif;?>
        </form>
    </div>
</li>
<script>




function updateNotificationStatus(nid){
     
      $.ajax({
            type:"POST",
            url:window.app.url+"/notification/updatenotifications",
            data:{"nid":nid,"last name": "lanme"},
            success: function (tekst) {
                  //Note: Please check JS call, it returns Error
                  //$('.count').text(tekst);
                  var counter = parseInt($("#counter").text());   
                  counter = counter-1;
                  $("#counter").text(counter);

                  $("#chk_"+nid).attr('disabled', true);
            },
            error:function (request, error) {
            console.log ("ERROR:" + error);
            }
      });
}

window.addEventListener ? 
    window.addEventListener("load",script,false) : 
    window.attachEvent && window.attachEvent("onload",script);

function script() {
      $(document).ready(function(){
            $('#viewAll').click(function(){
                  const nid = $('input[name="nid[]"]').map(function(){ return this.value; }).get();
                  $.ajax({
                        type:"POST",
                        url:window.app.url+"/notification/updateallnotifications",
                        data:{"nid":nid,"last name": "lanme"},
                        success: function (tekst) {
                              window.location.href=window.app.url  + '/notification';
                        },
                        error:function (request, error) {
                        console.log ("ERROR:" + error);
                        }
                  });
            });

            $('#notificationDropdown').click(function(){
                  const nid = $('input[name="nid[]"]').map(function(){ return this.value; }).get();
                  $.ajax({
                        type:"POST",
                        url:window.app.url+"/notification/read",
                        data:{"nid":nid,"last name": "lanme"},
                        success: function (tekst) {
                              //Note: Please check JS call, it returns Error
                              //$('.count').text(tekst);
                              console.log (tekst);
                        },
                        error:function (request, error) {
                        console.log ("ERROR:" + error);
                        }
                  });   
            });
      });
}
</script>


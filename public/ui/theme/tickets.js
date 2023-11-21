$(document).ready(function() {
    let chat = $('.chat-box'),
        status = '';
    setInterval(function() {
        if (navigator.onLine) load_message();
    }, 1000 * 30);
    load_message();

    $('#msgForm #file').on('change',function(e) {
        let name = e.target.files[0].name;
        $('#msgForm .selected_file').remove();
        $('.send-btn').before('<span class="selected_file">'+name+'</span>');
    })

    $('#msgForm').submit(function(e) {
        e.preventDefault();
        let form = new FormData(this),
            btn = $('.send-btn'),
            file = $('#msgForm #file')[0].files[0],
            msg = $.trim($('#msg').val());
        if(msg !== "" || typeof file !== "undefined") {
            btn.attr('disabled','disabled');
            $.ajax({
                type:'POST',
                url:window.app.url+'/tickets/conversation',
                data: form,
                cache:false,
                contentType:false,
                processData:false,
                success: function(res) {
                    chat.append(message(res));
                    btn.removeAttr('disabled');
                    $('#msgForm')[0].reset();
                    $('#msgForm .selected_file').remove();
                    setTimeout(function() {
                        $('.chat-box').scrollTop(this.innerHeight);
                    },500);
                },
                fail: function(err) {
                    console.log(err);
                    window.app.flash('error','Error please try later')
                }
            })
        }
    })

    
    function load_message() {
        let reload = {ticket:window.ticket.TicketID};

        if ( status != "") reload.status = status;

        $.get(window.app.url+'/tickets/conversation',reload,function (res) {
            if (typeof reload.status == 'undefined') {
                status = (res.length !== 0) ? res.reverse()[0].time: "";
                chat.html('');
                for ( m of res.reverse() ) chat.append(message(m));
                setTimeout(function() {
                    $('.chat-box').scrollTop(this.innerHeight);
                },500);
            } else {
                if (res.msg !== 'same') {
                    status = '';
                    load_message();
                }
            }
        })
    }

    function message(info) {
        let msg = isJSON(info.message),
            file = "";
        if(msg !== false) {
            info.message = msg[0];
            file = file_container(msg[1]);
        }
        let time = window.app.time(info.time,'lll'),
            y = new Date().getFullYear();
            same = info.EmployeeID !== window.app.employee.EmployeeID;
        time = time.split(', '+y).join(' - ');
        return `<div class="single-msg${(same)?' not-you':''}">
        <div class="msg-container">
            <span class="sender">${(!same)?'You':info.employee}</span>
            ${file}
            ${(info.message !== "") ? `<div class="msg">${info.message}</div>` : '' }
            <span class="time">${time}</span>
        </div>
        </div>`;
    }

    function file_container(file) {
        let name = file[1],
            str;
        if(name.length > 20) {
            str = name.substr(0,10);
            name = name.slice(10);
            str += (name.length > 10) ? "..."+name.slice(-10) : name;
        } else {
            str = name;
        }
        return `
        <a href="${window.app.public}/${file[0]}" target="_black" class="attachments-sections">
            <span class="thumb"><i class="fa fa-file"></i></span>
                <span class="details">
                    <p class="file-name" title="${file[1]}">${str}</p>
                    <span class="buttons">
                        <span class="view">View</span>
                    </span>
                </span>
            </span>
        </a>
        `;
    }

    function isJSON(str) {
        try {
            return JSON.parse(str);
        } catch (e) {
            return false;
        }
    }

    $('#status_form .btn').on('click',function (e) {
        e.preventDefault();
        let btn = $(this);
        btn.attr('disabled','disabled');
        var data = {
            ticket:$('[name="ticket"]').val(),
            status:$('[name="status"]').val(),
            level: $('[name="level"]').val(),
            assign_to: $('[name="assign_to"]').val(),
            assign_emp: $('[name="assign_emp"]').val()
        };
        $.post(window.app.url+'/tickets/status',data,function(res){
            if ( res.success === 'true') window.app.flash('success','Successfully Updated');
            btn.removeAttr('disabled');
        });

    })


    let getStore = $('.your-store'),
        getEmp = $('.your-manager');
    if ( getStore.length > 0 ) {
        getStore.each(function(i) {
            let sel = $(this),
                id = sel.find('td').text(),
                url = window.app.url + '/api/store/' +id;
            $.get(url).then(function(res) {
                $(sel).find('td').html(res.StoreName);
            });
        })
    }

    if ( getEmp.length > 0 ) {
        getEmp.each(function(i) {
            let sel = $(this),
                id = sel.find('td').text(),
                url = window.app.url + '/api/employee/' +id;
            $.get(url).then(function(res) {
                $(sel).find('td').html(res.Employee_Name);
            });
        })
    }
})
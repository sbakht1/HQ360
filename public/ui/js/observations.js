$(document).ready(function() {
    
    // Questions
    let observations = [],
        detail = $('#detail').val();
    if (detail == "") {
        $.get(`${window.app.url}/${window.app.role}/api/question/observation`).done(observations_presentation);
    } else {
        observations_presentation(JSON.parse(detail));
    }

     function observations_presentation(res) {
        // console.log(res);
        window.obs_form = res;
        observations = res;
        present_question(res.behavior,'behavior');
        present_question(res.sales,'sales');
        present_question(res.twe_way,'twe_way');
        updateValue(res.behavior,'behavior');
        updateValue(res.sales,'sales');
        updateValue(res.twe_way,'twe_way');
        update_data(res);
        triggers();
     }

     function update_data(res) {
        
        show_result([...res.behavior,...res.sales],'atntScore');
        show_result(res.twe_way,'tweScore');

        $('#detail').val(JSON.stringify(res));
     }

     function show_result(data,id) {
        var marks = find_value(data);
        score(id,marks[0],marks[1]);
     }


     function updateValue(cat, select) { for ( i in cat ) apply(`${select}--${i}`,cat[i].value[0]);}

     function present_question(data,selector) {
        
        sel = $('#'+selector);
        sel.append('<ol></ol>');
        var i = 0;
        for(let item of data) {
            var name = `${selector}--${i}`;
            sel.find('ol').append(`
                <li>
                    <div class="q-container" data-index="${i}">
                        <div class="ques">${item.question}</div>
                        <div class="opts">${options(item.options,name)}</div>
                    </div>
                </li>`);
            i++;
        }
     }

     function options(opt,name) {
        var html = '',
            x = 0,
            keys = Object.keys(opt),
            cls = (keys.length == 3) ? ['success','warning','danger'] : ['success','danger'];
            for (o in opt) {
            html += radio([cls[x],name,keys[x],opt[o],'']);
            x++;
        }
        return html;
     }

    function radio(config) {
        $radioInput = `<div class="form-check form-check-${config[0]}">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="${config[1]}" id="${config[1]}" value="${config[3]}" ${config[4]}>
          ${config[2]}
        <i class="input-helper"></i></label>
      </div>`;
      return $radioInput;
    }

    function apply(name,val) {
        $(`[name="${name}"][value="${val}"]`).attr('checked','');
    }

    function score(id,val,total) {
        let marks = remarks(total,val);
        observations[id] = [val,total,...marks];
        $(`#${id} .score`).html(`<span class="text-${marks[1]}">${val} out of ${total}</span>`);
        $(`#${id} .remarks`).html(`<span class="text-dark">${marks[0]}</span>`);
    }


    function remarks(total,val) {
        var percent = parseInt((val/total*100).toFixed(0));
        var marks = ['Need Improvement','danger'];
        if (percent > 49) marks = ["Meet expectations","warning"];
        if (percent > 79) marks = ['Exceed expectations','success'];
        return marks;
    }

    function find_value(cat) {
        let num = 0,
            tot = 0;
        for (let item of cat) {
            num += parseInt(item.value[0]);
            tot += parseInt(item.value[1]);
        }
        return [num,tot];
    }

    function triggers() {
        $('.observation .form-check-input').on('change', function() {
            let inp = $(this).attr('name').split('--'),
            val = parseInt($(this).val());
            inp[1] = parseInt(inp[1]);
            inp.push(val);
            observations[inp[0]][inp[1]].value[0] = val;
            update_data(observations);
        })

        $('.inputs input, .inputs textarea').on('change', function() {
            let i = parseInt($(this).attr('name').split('-')[1]),
                val = $(this).val();
            observations['inputs'][i][2] = val;
            update_data(observations);
        })
    }

})
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function onAjaxMod() {
    var reg = new RegExp("\\?");
    var reg_on = new RegExp("a_mode_on");
    $('a').each(function(i, el) {
        
            if (!reg_on.test($(el).attr('class'))) {
            
            $(el).click(function() {
                
                var url = $(el).attr('href');
                var advanced_parametr = (reg.test(url) ? '&' : '?')+'print_only_content=1';
                $.ajax({
                type: "GET",
                cache: false,
                url: url+advanced_parametr,
                dataType: 'json'
                }).done(function(data) {
                    loadContent(data);
                });

                return false;
            });
            $(el).attr('class', $(el).attr('class') + ' a_mode_on');
            }
    });
    
    $('form').each(function(i, el) {
        var action = $(el).attr('action');
        
        if (!reg_on.test($(el).attr('class'))) {
            
        $(el).find('input[type="submit"]').click(function() {

            $.ajax({
                type: "POST",
                cache: false,
                dataType: 'json',
                url: action+'&print_only_content=1',
                data: $(el).serialize()
            }).done(function(data) {
                loadContent(data);
            });

            return false;
        });
        }
        $(el).attr('class', $(el).attr('class') + ' a_mode_on');
    });
    
    //$('#content').html();
    //alert($('#login_form').attr('class'));
    return true;
}

function loadContent(data) {
var control = function(i, data) {
        $('#'+i).fadeOut("slow", function() {
            $('#'+i).html(data[i]);
            onAjaxMod();
            $('#'+i).fadeIn("slow");
        });
}
    for(var i in data) {
        control(i, data);
    }
}

/**
 * @todo каким то образом множится, это не есть хорошо
 * наверное из за того, что селектор повторно срабатывает
 * надо вопервых сделать так, что бы селектились все формы и ссылки
 * у которых нету специального класса или параметра
 * и после того как мы прошлись селектором добавлять этот класс
 */
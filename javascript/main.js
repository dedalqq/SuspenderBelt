/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function onAjaxMod() {
    var reg = new RegExp("\\?");
    $('a').each(function(i, el) {
            
            $(el).click(function() {
                $('#content').fadeOut("slow", function() {
                    var url = $(el).attr('href');
                    var advanced_parametr = (reg.test(url) ? '&' : '?')+'print_only_content=1';
                    $.get(url+advanced_parametr, function(data) {
                        $('#content').html(data);
                        onAjaxMod();
                        $('#content').fadeIn("slow");
                    });
                });
                return false;
            });
    });
    
    $('form').each(function(i, el) {
        var action = $(el).attr('action');
        $(el).find('input[type="submit"]').click(function() {
            $('#content').fadeOut("slow", function() {
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: action+'&print_only_content=1',
                    data: $(el).serialize()
                }).done(function(data) {
                    $('#content').html(data);
                    onAjaxMod();
                    $('#content').fadeIn("slow");
                });
            });
            return false;
        });
    });
    
    //$('#content').html();
    
    return true;
}

$(document).ready(function(){
    $('#notification_close').click(function(e){
        e.preventDefault();

        $('#notification').remove();
    });

    $('#test_rule_button').click(function(){
        $.ajax({
            type: 'get',
            url: 'ajax/test_rule.php',
            data: {feed: $('#rule_feed').val(), rule_title: $('#rule_title').val(), rule_link: $('#rule_link').val(), rule_category: $('#rule_category').val()}
        }).done(function(data){
            $('#test_rule_result .content').html(data);
        });;
    });
});
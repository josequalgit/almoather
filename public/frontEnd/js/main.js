$(document).ready(function(){

    $(document).on('click', '.Advertiser', function(){
        $('input[name="user_type"]:not(checked)').closest('.Advertiser').removeClass('active');
        $(this).addClass('active');
        $('#register').attr('href', $(this).find('input[name="user_type"]').val());
    })

})
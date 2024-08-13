$(document).ready(function () {
    $("ul.listing li").live("mouseover", function(){
			$(this).addClass('click_hover');
    });
    $("ul.listing li").live("mouseout", function(){
			$(this).removeClass('click_hover');
    });
        
    $('.mask').click(function () {
        $('.mask').toggle();
     });
     
      
    $('a#off_light').click(function(e){ 
        e.preventDefault();
        $('.mask').toggle();
    }); 
    
    $('a#click_comment').click(function(e) {
        e.preventDefault();
        $('html,body').animate({scrollTop: $('.comment').offset().top}, 1200);	
    });
    
    $('#menu-header-menu li:not(.user)').each(function () {
        var href = $(this).find('a').attr('href');
        var current_url = window.location.protocol + '//' + window.location.hostname + window.location.pathname;
        if(current_url === href){
            $('#menu-header-menu li').removeClass('active');
            $(this).addClass('active');
        }
    });
    
    $('.navbar-toggle').click(function(e) {
        e.preventDefault();
        $("#menu-header-menu").toggle();
    });
    
});
function loadDing(str){
    document.getElementById(str).innerHTML = "<img src='" + base_url + "/img/load/ajax-loader_1.gif' />";
}
function freload() {
    location.reload(true);
}
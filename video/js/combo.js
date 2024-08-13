$(document).ready(function () {
    var id = -1;
    $("#search-form #keyword").keyup(function (e) {
        var keyword = $(this).val();
        var keyword_replace = $('#keyword_search_replace').val();
        if (keyword_replace != keyword) {
            preload(keyword, id);
            $('#keyword_search_replace').val('');
            $("#key_pres").val('');
        }
    });
    $("#search-form #keyword").focus(function (e) {
        var keyword = $(this).val();
        preload(keyword, id);
    });
    $("#search-form #keyword").blur(function () {
        if ($("#header_search_autocomplete").is(':hover') === true) {
        } else {
            var keyword = '';
            preload(keyword, id);
        }
    });
    $("#search-form #keyword").keydown(function (e) {
        var keyword = $(this).val();
        var key_pres = $("#key_pres").val();
        if (e.keyCode == 13) {
            e.preventDefault();
            if (key_pres != '') {
                var alias = $('#link_alias').val();
                window.location.href = base_url + '/series/' + alias;
            } else {
                window.location.href = base_url + 'search.html?keyword=' + keyword;
            }
        }
        if ($('#header_search_autocomplete_body:visible').length > 0) {
            var items = $('#header_search_autocomplete_body').children();
            var nextElement = null;
            var current_index = -1;
            event_id = $("#key_pres").val();
            if (event_id != '') {
                if (event_id.substring(0, 'header_search_autocomplete_item_'.length) == 'header_search_autocomplete_item_') {
                    current_index = parseInt(event_id.replace('header_search_autocomplete_item_', ''));
                    $('#header_search_autocomplete_body div').removeClass('focused');
                }
            }
            if (e.keyCode == 38) {
                e.preventDefault();
                current_index = Math.max(0, current_index - 1);
                nextElement = $('#header_search_autocomplete_item_' + current_index);
            } else if (e.keyCode == 40) {
                e.preventDefault();
                current_index = Math.min(items.length - 1, current_index + 1);
                nextElement = $('#header_search_autocomplete_item_' + current_index);
            }
            if (nextElement) {
                nextElement.stop(true, true);
                $('#header_search_autocomplete_item_' + current_index).focus();
                $('#header_search_autocomplete_item_' + current_index).stop(true, true).addClass('focused');
                $("#key_pres").val('header_search_autocomplete_item_' + current_index);
                var link_alias = $('#header_search_autocomplete_item_' + current_index + ' a').attr('rel');
                $("#link_alias").val(link_alias);
                $("#keyword_search_replace").val(keyword);
                id = current_index;
            }
        }
    });
});
function preload(keyword, id) {
    if(keyword.length >= 2) {
        $(".load.search").show();
        //$("#header_search_autocomplete .load").html(keyword);
    }
    $.ajax({
        type: "get",
        url: base_url + "ajax-search.html",
        dataType: 'json',
        data: {keyword: keyword, id: id},
        success: function (data, response) {
            $(".load.search").hide();
            $("#header_search_autocomplete").html(data.content);
        }
    });
}
function do_search() {
    var keyword = $("#search-form.lap #keyword").val();
    keyword = keyword.replace(/\s+/g, '-');
    if(keyword.length >= 2) {
        window.location.href = base_url + 'search.html?keyword=' + keyword;
    }else{
        //$("#search-form #keyword").focus();
    }
    
    return false;
}
function do_searchM() {
    var keyword = $("#search-form.mobi #keyword").val();
    keyword = keyword.replace(/\s+/g, '-');
    if(keyword.length >= 2) {
        window.location.href = base_url + 'search.html?keyword=' + keyword;
    }else{
        //$("#search-form #keyword").focus();
    }
    
    return false;
}
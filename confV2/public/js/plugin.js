/*jslint browser: true*/
/*global document, $*/
$(document).ready(function () {
    'use strict';

    //SHOW NAVBAR IN MOBILE DEVICES
    $('.sideNavbar .showBar').click(function () {
        if ($('.sideNavbar').hasClass('showNavbar')) {
            $(".categories").removeClass('showCategory');
            $('.sideNavbar').removeClass('showNavbar');
        } else {
            $('.sideNavbar').addClass('showNavbar');
        }
    });
    
    //ADD CLASS ACTIVE LINK IN THE CLICK EVENT
        //== FOR NAVBAR LINKS
    $('.addOnClick').click(function (e) {
        e.preventDefault();
        $(this).children('li').addClass('activeLi');
        $(this).siblings('a').children('li').removeClass('activeLi');
    });
    
    
    //SHOW CATEGORY AND HIDE IT
    $('.sideNavbar .navbar a li').eq(1).click(function () {
        if ($(".categories").hasClass('showCategory')) {
            $(".categories").removeClass('showCategory');
            $('.sideNavbar .navbar a h6').fadeIn();
        } else {
            $(".categories").addClass('showCategory');
            $('.sideNavbar .navbar a li h6').fadeOut();
        }
    });
    $('.categories .closeCat i').click(function () {
        $(".categories").removeClass('showCategory');
    });
    
    //SEARCH BUTTON
    $('.search .searchForm form > i').click(function () {
        if ($('.search .searchForm form > i').hasClass('la la-close')) {
            $('.search .searchForm form > i').attr('class', 'la la-search');
            $('.search .searchForm form > i').removeClass("searchIconClicked");
            $('.search .searchForm input[type="text"]').val('').removeClass("submitShow");

        } else {
            $('.search .searchForm form > i').attr('class', 'la la-close');
            $('.search .searchForm form > i').addClass("searchIconClicked");
            $('.search .searchForm input[type="text"]').addClass("submitShow");
            $('.search .searchForm input[type="text"]').focus();
        }
    });
    
    //SHOW AND HIDE ADD POST
    $('.sideNavbar .addPostBtn, .addPost .form .la-close').click(function () {
        $(".addPost").fadeToggle(500);
        $('.addPost .form').toggleClass('showAddPost');
    });

    
    //HIDE FULL POST
    $('.fullPost .la-close').click(function () {
        $('.fullPost').fadeOut(500, function () {
            $('.fullPost .theFull').removeClass('showFullPost');
            $('.fullPost .theFull .post *').remove();
        });
        
    });


    $('.sharePage a').eq(0).click(function (e) {
        e.preventDefault();
        $('.sharePage').fadeOut(500);
    });

    //Share Button
    $('.la-share').click(function () {
        var postId = $(this).closest('.post').data('idpost');
        $('.sharePage a').each(function (i) {
            var url = $('.sharePage a').eq(i).data('url') + location.href + 'share/' + postId;
            $('.sharePage a').eq(i).attr('href', url);
            console.log(url);
        });
        $('.sharePage').fadeIn(500);
    });

});

$(window).on('load', function () {
    $('.lds-ripple').fadeOut(1000, function () {
        $('.loader').fadeOut(1000);
        $('body').css('overflow', 'visible');
        setTimeout(function () {
            $('.loader').remove();
        }, 1000);
    });
});
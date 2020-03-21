$(document).ready(function () {

	'use strict';



    function myIntervalError(status){

        var interval = null,

            allItemsOpacity = 1;



        while (allItemsOpacity == 1) {

            allItemsOpacity = 0;

            $('.error > div').each(function (i) {



                interval = setInterval(function () {



                    if ($('.error > div').eq(i).css('opacity') == 0) {

                        $('.error > div').eq(i).remove();

                        allItemsOpacity = 1;

                    }

                

                }, 1000);



            });

        }



        if (allItemsOpacity == 0) {

            clearInterval(interval);

        }

    }



    var myCsrf = $('#_token').val();

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN' : myCsrf

        }

    });





	//Ajax Function

	function myAjax(theUrl, theData = {}, myFunction = '', isLoaing = '', someStyle = ''){

        if (isLoaing != '') {

            $(isLoaing).append('<section style="z-index: 9999;display:none; '+ someStyle +';" class="loader"><div class="lds-ripple"><div></div><div></div></div></section>');

        }



        $('.loader').fadeIn(500);

		$.ajax({

			method: 'POST',

			url: theUrl,

			data: theData,

			success: function (data) {

				if (myFunction != '') {

					myFunction(data);

				}



                if (isLoaing != '') {

                    $('.loader').fadeOut(1000, function () {

                        $('.loader').remove();

                    });

                }

			}, error : function (error, exception) {



                Object.keys(error.responseJSON.errors).forEach(function (k) {

                    $('.error').append('<div><div class="errorMSG">' + error.responseJSON.errors[k][0] + '</div></div>');

                    myIntervalError();

                });

            }

		});

	}





    //Load Posts on Scroll

    var sendAjax = true,

        skip = 18,

        cat = '';

    $(window).scroll(function () {

        if (sendAjax && ($(document).height() - 200 <= $(window).height() + $(window).scrollTop())) {

            sendAjax = false;

            var url =  'getPost/' + skip;



            if ($('.categories .allCategories > div').hasClass('activeCat')) {

                url = cat + '/' + skip;

            } else if ($('.search .searchForm input[type="text"]').val() != '') {

                url = 'search/' + $('.search .searchForm input[type="text"]').val() + '/' + skip;

            } else if ($('.addOnClick').eq(1).children('li').hasClass('activeLi')) {



                url = 'most/' + skip;



            }



            myAjax(url, {}, function (data) {

                if (data.length > 0) {



                    $('.allPosts').append(data);

                    

                    sendAjax = true;

                    skip += 18;



                }

            });

        }

    });







    //show Most Viewed Posts

    $('.addOnClick').eq(1).click(function () {

        skip = 18;

        sendAjax = true;

        var myUrl = $(this).attr('href');



        $('.categories .allCategories > div').removeClass('activeCat');

        $('.search .searchForm input[type="text"]').val('');

        myAjax(myUrl, {}, function (data) {

            $('.allPosts').html(data);

        }, 'body');



    });





	//SHOW FULL POST

    $(document).on('click', '.allPosts .post .textPost, .allPosts .post .la-comment' ,function () {

        var thisPost = $(this).closest('.post'),

            postId = thisPost.data('idpost');





        myAjax('getFullPost/' + postId, {},function (data) {

        	$('.fullPost .theFull').html(data);

            $('.fullPost').fadeIn(500);

            $('.fullPost .theFull').addClass('showFullPost');

        }, 'body', 'z-index: 999999999999');

    });





    //Like Or Dislike

    $(document).on('click', '.allPosts .post .btnPost .la-heart-o, .fullPost .theFull .post .btnPost .la-heart-o', function () {

    	var postId = $(this).closest('.post').data('idpost'),

    		url = 'like/' + postId + '/';



        if ($(this).hasClass('isLiked')) {

    	   url += 'dislike';

           $('.post[data-idpost="' + postId + '"] .la-heart-o').removeClass('isLiked').text(parseInt($(this).text()) - 1);

        } else {

            url += 'like';

            $('.post[data-idpost="' + postId + '"] .la-heart-o').addClass('isLiked').text(parseInt($(this).text()) + 1);

        }

    	myAjax(url);

    });





    //Add Comment

    $(document).on('submit', '.fullPost .theComments .addComment form', function (e) {

        e.preventDefault();

        var theComment = $(this).children('textarea'),

            postId = $(this).parents('.theComments').siblings('.post').data('idpost');



        if (theComment.val().length != 0) {



        var countComment = parseInt($('.fullPost').find('.la-comment').text());

        $('.post[data-idpost="' + postId + '"]').find('.la-comment').text(countComment + 1);



            $('.fullPost .allComment').prepend('<h6 class="commentAnimate">' + theComment.val() + '</h6>');

            myAjax('addComment/' + postId, {'comment': theComment.val() });

            theComment.val('');



        }



    });





    //Add Post

    $('.addPost form').submit(function (e) {

        e.preventDefault();



        if ($(this).find('select').val() == '') {

            $('.error').append('<div><div class="errorMSG">من فضلك اختر تصنيفا محددا</div></div>');

            myIntervalError();

        } else if ($(this).find('textarea').val() == '' || $(this).find('textarea').val().length < 150) {

            $('.error').append('<div><div class="errorMSG">الاعتراف يجب ان يحتوي على 150 حرف على الأقل</div></div>');

            myIntervalError();

        } else {



            var form = $(this).serialize();



            myAjax('posts/addPost', form, function(data) {



                $('.error').append('<div><div>شكرا لك لمشاركة مشاعرك</div></div>');



                setTimeout(function() {

                    location.reload();

                }, 3000);



                $('.addPost form')[0].reset();

                

            }, 'body', 'z-index:999999999;opacity:0.7');

        }



    });





    //ADD ACTIVE LINKS IN CATEGORY

    $('.categories .allCategories a').click(function (e) {

        e.preventDefault();

        sendAjax = true,

        skip = 18;

        cat = $(this).attr('href');



        $(this).parent('div').addClass('activeCat').siblings('div').removeClass('activeCat');



        $('.categories').removeClass('showCategory');



        var url = $(this).attr('href');

        setTimeout(function () {



            myAjax(url, {}, function (data) {

                $(window).scrollTop(0);

                $('.allPosts').html(data);

            }, 'body');

            

        }, 100);

    });





    //Search

    $('.search .searchForm input[type="text"]').keyup(function () {

            

        var url = 'search/' + $(this).val();

        sendAjax = true,

        skip = 18;

        

        if ($(this).val() == '') {

            url = 'getPost/0';

        }



        if ($(this).val() != '') {

            $('.categories .allCategories > div').removeClass('activeCat');

            $('.addOnClick').eq(1).children('li').removeClass('activeLi');

        }



        myAjax(url, {}, function(data) {

            $('.allPosts').html(data);

        }, 'body', 'margin-top:' + $('.search').outerHeight() + 'px;');

    });



    $('.search .searchForm form > i').click(function () {

        var url = 'getPost/0';

        sendAjax = true,

        skip = 18;

        if ($(this).hasClass('la-close')) {

            myAjax(url, {}, function(data) {

                $('.allPosts').html(data);

            }, 'body', 'margin-top:' + $('.search').outerHeight() + 'px;');

        }

    });





    //Send Message

    $('.sideNavbar .navbar a:last-child').click(function () {

        $('.contactAside').toggleClass('showMySideBar');

    });



    $('.sideBarStyle .back i').click(function () {

        $('.contactAside').removeClass('showMySideBar');

        $('.sideNavbar .navbar ul a:last-child li').removeClass('activeLi');

    });

});
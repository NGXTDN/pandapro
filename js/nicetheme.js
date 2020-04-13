/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-06 15:27:44
 * @Last Modified by: suxing
 * @Last Modified time: 2019-08-18 01:00:17
*/
window.$ = jQuery;
var isApollo = $("meta[name=apollo-enabled]").attr("content") === '1';

function toggleCommentAuthorInfo() {
    var changeMsg = '[编辑资料]';
    var closeMsg = '[我写好了]';
    
    $('.comment-form-info').slideToggle('slow', function(){
        if ( $('.comment-form-info').css('display') == 'none' ) {
            $('#toggle-comment-author-info').html(changeMsg);
        } else {
            $('#toggle-comment-author-info').html(closeMsg);
        }
    });
};

function toggleDarkMode() {
    $('body').toggleClass('nice-dark-mode')
    if (!$('body').hasClass('nice-dark-mode')) {
        $('.logo-dark').removeClass('d-inline-block')
        $('.logo-dark').addClass('d-none')

        $('.logo-light').removeClass('d-none')
        $('.logo-light').addClass('d-inline-block')
    } else {
        $('.logo-dark').removeClass('d-none')
        $('.logo-dark').addClass('d-inline-block')
        $('.logo-light').removeClass('d-inline-block')
        $('.logo-light').addClass('d-none')
    }
}
// mobile Sidebar
function toggleSidebar() {
    $('.sidebar-close, .mobile-overlay').on('click', function () {
        $('body').removeClass('modal-open');
        $('.mobile-sidebar').removeClass('active');
        $('.mobile-overlay').removeClass('active');
    });
    $('#sidebarCollapse').on('click', function () {
        $('body').addClass('modal-open');
        $('.mobile-sidebar').addClass('active');
        $('.mobile-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
}
jQuery(document).ready(function($)  {
    toggleSidebar();

    $(window).scroll(function() {
        var $window = $(window),
            $window_width = $window.width();

        if ($(this).scrollTop() > 200 && $window_width >= 1024) {
            $('#scroll_to_top').filter(':hidden').fadeIn('fast');
        } else {
            $('#scroll_to_top').filter(':visible').fadeOut('fast');
        }
    });
    $('#scroll_to_top').on('click',
    function() {
        $('html, body').animate({
            scrollTop: 0
        },
        'slow');
        return false;
    });

    // Smooth scrolling using jQuery easing
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                scrollTop: (target.offset().top - 60)
                }, 1000, "easeInOutExpo");
            return false;
            }
        }
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="tooltip"]').on('shown.bs.tooltip', function () {
        $('.tooltip').addClass('animated fadeIn');
    })

    // theiaStickySidebar
    $('.sidebar').theiaStickySidebar({
        additionalMarginTop: 20,
        additionalMarginBottom: 20
    });
    // theiaStickySidebar
    $('.sidebar-author').theiaStickySidebar({
        additionalMarginTop: 100,
        additionalMarginBottom: 20
    });
    if ($(".main-menu li").hasClass("menu-item-has-children")) {
        $('.main-menu .menu-item-has-children').prepend('<span class="icon-sub-menu"><i class="iconfont icon-arrow-down-s-line"></i></span>')
    };
    $('.mobile-sidebar-menu .menu-item-has-children > a').append('<div class="dropdown-sub-menu"><span class="iconfont icon-arrow-drop-down-fill"></span></div>'),
    $('.dropdown-sub-menu').on("click",
    function() {
        $(this).parents('li').children('.sub-menu').slideToggle(),
        $(this).parents('li').children('.dropdown-sub-menu').toggleClass('current')
    });


    // carousel
    var owl = $('.list-banner .owl-carousel');
    if (owl.length > 0) {
        owl.owlCarousel({
            items:1,
            loop:true,
            margin:10,
            smartSpeed:1000,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            responsiveClass:true,
			responsive:{
				0:{
					items:1,
                    margin:10,
                    nav: false,
				},
				768:{
					nav: true,
                    navText:['<i class="iconfont icon-left"></i>','<i class="iconfont icon-right"></i>'],
				},
				992:{
					nav: true,
                    navText:['<i class="iconfont icon-left"></i>','<i class="iconfont icon-right"></i>'],
				}
			}
        });
    }

    $(document).on('click', '.list-ajax-nav button', function(event) {
        event.preventDefault();
        var t = $(this);
        if( !t.hasClass('current') ){
            $('.list-ajax-nav button').attr('class', 'btn btn-sm btn-link');
            t.removeClass('btn-link');
            t.addClass('btn-primary current');
    
            var cid = t.data('cid');
            if( cid ){
                $('.dposts-ajax-load').data('tabcid', cid);
            }else{
                $('.dposts-ajax-load').removeData('tabcid');
            }
            $('.dposts-ajax-load').data('paged', 1);
            $('.' + $('.dposts-ajax-load').data().append).html('');
            // disable button when loading
            $('.dposts-ajax-load').addClass('loading').text(__.load_more);
            $('.list-ajax-nav button').attr('disabled', true)
            ajax_load_posts($('.dposts-ajax-load').data(), function() {
                $('.list-ajax-nav button').removeAttr('disabled')
            });
        }
    });
    
    

    function ajax_load_comments( data ){
        var buttonDOM = $('#comments-next-button');
        buttonDOM.hide();

        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: data,
        })
        .done(function( response ) {
            if( response ){
                if( data.commentspage == 'newest' ){
                    buttonDOM.data( 'paged', data.paged*1-1);
                }else{
                    buttonDOM.data( 'paged', data.paged*1+1);
                }
                $('.'+data.append).append(response);
                buttonDOM.show();
            } else {
                buttonDOM.hide();
            }

        })
    }

    $(document).on('click', '#comments-next-button', function(event) {
        event.preventDefault();
        ajax_load_comments($('#comments-next-button').data());
    });

    $(document).on("click", '.btn-like[data-action="like"]', function() {
        event.preventDefault();
        var $this = $('.btn-like');
        var id = $(this).data("id");
    
        if( $this.hasClass('requesting') ){
            return false;
        }
    
        $this.addClass('requesting');
        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: { action: 'pandapro_like', id, like_action: 'like'},
        })
        .done(function( data ) {
            $this.addClass('current');
            $this.attr('data-action', 'unlike');
            ncPopupTips(1, __.thank_you)
            $('.like-count').html(data.trim());
            isApollo && apolloAjaxPostLikeSection(id);
        })
        .always(function() {
            $this.removeClass('requesting');
        });
        return false;
    });


    $(document).on("click", '.btn-like[data-action="unlike"]', function() {
        event.preventDefault();
        var $this = $('.btn-like');
        var id = $(this).data("id");

        if( $this.hasClass('requesting') ){
            return false;
        }

        $this.addClass('requesting');

        $this.removeClass('current');

        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: { action: 'pandapro_like', id, like_action: 'unlike'},
        })
        .done(function( data ) {
            $this.removeClass('current');
            $this.attr('data-action', 'like');
            ncPopupTips(0, __.cancelled)
            $('.like-count').html(data.trim());
            isApollo && apolloAjaxPostLikeSection(id);
        })
        .always(function() {
            $this.removeClass('requesting');
        });
        return false;
    });

    function apolloAjaxPostLikeSection(id) {
        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: {
                action: 'ajax_apollo_userlike_section',
                id: id
            },
        })
        .done(function(response) {
            $('#apollo-postlike-section').length > 0 && $('#apollo-postlike-section').remove();
            if (response.trim()) {
                $('#post-share-section').after(response)
            }
        })
    }

    $(document).on('click', '.single-popup', function(event) {
        event.preventDefault();
        var img = $(this).data("img");
        var title = $(this).data("title");
        var desc = $(this).data("desc");
        var html = '<div class="text-center"><h6 class="py-1">' + title + '</h6>\
                    <div class="text-muted text-sm mb-2" > '+ desc +' </div>\
                    <img src="' + img + '" alt="' + title + '" style="width:100%;height:auto;">\
                    </div>'
        ncPopup('small', html)
    });
    $(document).on('click', '.plus-power-popup', function (event) {
        event.preventDefault();
        var $this = $('#plus-power-popup-wrap');
        ncPopup('no-padding', $this.html())
    });
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document. documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document. documentElement.clientWidth)
        );
    }
    function givenElementInViewport (el, fn) {
        return function () {
            if (isElementInViewport(el)) {
                fn.call();
            }
        }
    }
    function addViewportEvent (el, fn) {
        if (window.addEventListener) {
            addEventListener('DOMContentLoaded', givenElementInViewport(el, fn), false);
            addEventListener('load', givenElementInViewport(el, fn), false);
            addEventListener('scroll', givenElementInViewport(el, fn), false);
            addEventListener('resize', givenElementInViewport(el, fn), false);
        } else if (window.attachEvent)  {
            attachEvent('DOMContentLoaded', givenElementInViewport(el, fn));
            attachEvent('load', givenElementInViewport(el, fn));
            attachEvent('scroll', givenElementInViewport(el, fn));
            attachEvent('resize', givenElementInViewport(el, fn));
        }
    }

    if( $('.list-ajax-load').length > 0 ) {
        addViewportEvent( document.querySelector('.list-ajax-load') ,function(){
            if( $('.dposts-ajax-load').data('comments') == 'comments' ){
                return false;
            }

            if( $('.list-ajax-load').hasClass('loading') === false ){
                var data = $('.dposts-ajax-load').data();
                if( $('.dposts-ajax-load').data('paged') <= 3 ){
                    $('.list-ajax-load').addClass('loading');
                    ajax_load_posts($('.dposts-ajax-load').data());
                }

            }

        });
    }

    $(document).on('click', '.refresh-random-post', function(event) {
        event.preventDefault();
        var $this = jQuery(this)

        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: {
                action: 'ajax_refresh_random_post',
                id: $this.data().id
            },
        })
        .done(function(response) {
            if (response.trim()) {
                $this.parents('.Single_Post_Card').html(response.trim())
            }
        })
    });

    $(document).on('click', '.nav-switch-dark-mode', function(event) {
        event.preventDefault();
        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: {
                toggle_action: $('body').hasClass('nice-dark-mode') === true ? 'off' : 'on',
                action: 'pandapro_toggle_dark_mode'
            },
        })
        .done(function(response) {
            toggleDarkMode()
        })
    });

    $(document).on('click', '.link-post-share', function (event) {
        event.preventDefault();
        $(this).parent().toggleClass('show');
        $('body').toggleClass('modal-open');
        $('.mobile-overlay').addClass('active');
    });
    if ($('.content-share').hasClass('show') === false) {
        $(document).on('click', '.nice-dropdown .weixin, .mobile-overlay', function (event) {
            event.preventDefault();
            $('.content-share').removeClass('show');
            $('body').removeClass('modal-open');
            $('.mobile-overlay').removeClass('active');
        });
    }
    $(document).on('click', '.dposts-ajax-load', function(event) {
        event.preventDefault();
        var $this = jQuery(this)
        if( $('.list-ajax-load').hasClass('loading') === false ){
            $('.list-ajax-load').addClass('loading');
            ajax_load_posts($this.data());
        }
    });

    function ajax_load_posts( data, callback = function() {} ) {
        $('.ajax-loading').show();

        var loadButton = $('.dposts-ajax-load')
        var listAjaxLoad = $('.list-ajax-load')
        loadButton.hide();

        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: data,
        })
        .done(function(response) {
            callback();
            loadButton.removeAttr('disabled');
            if (response.trim()) {
                loadButton.data( 'paged', data.paged * 1 + 1)
                $('.' + data.append).append(response);
                listAjaxLoad.removeClass('loading').show();
            } else {
                loadButton.attr('disabled', 'disabled');
                loadButton.addClass('btn-nostyle')
                loadButton.text(__.reached_the_end).show();
            }
        })
        .fail(function() {
            $('.ajax-loading').hide();
        })
        .always(function() {
            $('.ajax-loading').hide();
            loadButton.show();
        });
    }


});// End of use strict
console.log('\n' + ' %c PandaPRO Designed by nicetheme® %c https://www.nicetheme.cn ' + '\n', 'color: #fadfa3; background: #030307; padding:5px 0; font-size:12px;', 'background: #fadfa3; padding:5px 0; font-size:12px;');

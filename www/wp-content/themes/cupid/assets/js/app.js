(function($) {
    "use strict";
    var Core = {
        initialized: false,
		timeOut_search: null,

        initialize: function() {

            if (this.initialized) return;
            this.initialized = true;

            this.build();
            Core.events();
        },
        build : function() {
            Core.owlCarousel();
            Core.processWord();
			Core.iframe_height_in_widget_area();
            Core.page_animsition();
            Core.process_product();
        },

        events : function() {
            if (!(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1)) {
                Core.smoothPageScroll();
            }
			Core.window_scroll();
			Core.window_resize();
			Core.goTop();
            Core.classes_switcher();
            Core.classes_load_more();
            Core.classes_search_event();
            Core.page404_search();
			// Anchors Position
			$("a[data-hash]").on("click", function(e) {
				e.preventDefault();
				Core.anchorsPosition(this);
				return false;
			});
            Core.process_Blog();
			Core.login_link_event();
			Core.mega_menu_process(true);
			Core.search_popup_process();
			Core.widget_default_process();

            $('.wpb_map_wraper,.cupid-text-widget').on('click', Core.onMapClickHandler);

		},
		anchorsPosition : function(obj,time) {
			var target = jQuery(obj).attr("href");
			if ($(target).length > 0 ) {
				var _scrollTop = $(target).offset().top;
				if ($('#wpadminbar').length > 0) {
					_scrollTop -= $('#wpadminbar').outerHeight();
				}
				$("html,body").animate({scrollTop: _scrollTop}, time,'swing',function(){});
			}
		},
		window_scroll: function() {
            $(window).on('scroll',function(event){
                if ($(window).scrollTop() > $(window).height()/2){
                    $('.gotop').fadeIn();
                }
                else{
                    $('.gotop').fadeOut();
                }
            });
		},
		goTop : function() {
			$('.gotop').click(function(){
				$('html,body').animate({scrollTop: '0px'}, 800);
				return false;
			});
		},
		window_resize: function() {
			$(window).resize(function(){
				if($('#wpadminbar').length > 0) {
					$('body').attr('data-offset', $('#wpadminbar').outerHeight() + 1);
				}
				if($('#wpadminbar').length > 0) {
					$('body').attr('data-offset', $('#wpadminbar').outerHeight() + 1);
				}
				Core.iframe_height_in_widget_area();
                Core.processWidthAudioPlayer();
				Core.mega_menu_process(false);
			});
		},
        smoothPageScroll : function() {
            //return;
            var $window = $(window);		//Window object
            var scrollTime = 0.6;			//Scroll time
            var scrollDistance = 400;		//Distance. Use smaller value for shorter scroll and greater value for longer scroll

            $window.on("mousewheel DOMMouseScroll", function (event) {
                if (jQuery(event.target).closest(".navbar-collapse").length === 1) {
                    return;
                }

                if (jQuery(event.target).closest(".chosen-results").length === 1) {
                    return;
                }

                if (jQuery(event.target).closest("#ryl-modal-blog-article").length === 1) {
                    return;
                }

                if (jQuery(event.target).closest(".select2-results").length === 1) {
                    return;
                }





                event.preventDefault();

                var delta = event.originalEvent.wheelDelta / 120 || -event.originalEvent.detail / 3;
                var scrollTop = $window.scrollTop();
                var finalScroll = scrollTop - parseInt(delta * scrollDistance);

                TweenLite.to($window, scrollTime, {
                    scrollTo: {
                        y: finalScroll, autoKill: !0
                    },
                    ease: Power1.easeOut,
                    autoKill: !0,
                    overwrite: 5
                });

            });

        },

        owlCarousel : function() {
            $('div.owl-carousel:not(.manual)').each(function(){
                var slider = $(this);

                var defaults = {
                    // Most important owl features
                    items : 5,
                    itemsCustom : false,
                    itemsDesktop : [1199,4],
                    itemsDesktopSmall : [980,3],
                    itemsTablet: [768,2],
                    itemsTabletSmall: false,
                    itemsMobile : [479,1],
                    singleItem : false,
                    itemsScaleUp : false,

                    //Basic Speeds
                    slideSpeed : 200,
                    paginationSpeed : 800,
                    rewindSpeed : 1000,

                    //Autoplay
                    autoPlay : false,
                    stopOnHover : false,

                    // Navigation
                    navigation : false,
                    navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                    rewindNav : true,
                    scrollPerPage : false,

                    //Pagination
                    pagination : true,
                    paginationNumbers: false,

                    // Responsive
                    responsive: true,
                    responsiveRefreshRate : 200,
                    responsiveBaseWidth: window,

                    // CSS Styles
                    baseClass : "owl-carousel",
                    theme : "owl-theme",

                    //Lazy load
                    lazyLoad : false,
                    lazyFollow : true,
                    lazyEffect : "fade",

                    //Auto height
                    autoHeight : false,

                    //JSON
                    jsonPath : false,
                    jsonSuccess : false,

                    //Mouse Events
                    dragBeforeAnimFinish : true,
                    mouseDrag : true,
                    touchDrag : true,

                    //Transitions
                    transitionStyle : false,

                    // Other
                    addClassActive : false,

                    //Callbacks
                    beforeUpdate : false,
                    afterUpdate : false,
                    beforeInit: false,
                    afterInit: false,
                    beforeMove: false,
                    afterMove: false,
                    afterAction: false,
                    startDragging : false,
                    afterLazyLoad : false
                };

                var config = $.extend({}, defaults, slider.data("plugin-options"));
                var fucStr_afterInit = config.afterInit;
                var fuc_afterInit = function(){
                    eval(fucStr_afterInit);
                };
                if (config.afterInit != false) {
                    config.afterInit = fuc_afterInit;
                }

                var fucStr_afterMove = config.afterMove;

                var fuc_afterMove = function(){
                    eval(fucStr_afterMove);
                };
                if (config.afterMove != false) {
                    config.afterMove = fuc_afterMove;
                }



                // Initialize Slider


                slider.owlCarousel(config);
            });

            $('.ryl-text-carousel').each(function() {
                var $this = $(this);

                $this.owlCarousel({
                    singleItem : true,
                    items: 1,
                    pagination: true,
                    navigation: $this.hasClass('has-nav'),
                    slideSpeed: 300,
                    mouseDrag: false,
                    transitionStyle : "ryl-text",
                    afterAction: updateSliderIndex,
                    afterMove: false,
                    beforeMove : false,
                    autoHeight : true
                });

                function updateSliderIndex() {
                    var items = $this.children().find('.owl-pagination .owl-page').length;
                    var index = $this.children().find('.owl-pagination .owl-page.active').index() + 1;
                    $this.attr('data-index', (index + "/" + items));
                }
            });
        },

        // Disable scroll zooming and bind back the click event
        onMapMouseleaveHandler : function (event) {
            var that = jQuery(this);

            that.on('click',Core.onMapClickHandler);
            that.off('mouseleave', Core.onMapMouseleaveHandler);
            that.find('iframe').css("pointer-events", "none");
        },

        onMapClickHandler : function (event) {
            var that = jQuery(this);

            // Disable the click handler until the user leaves the map area
            that.off('click', Core.onMapClickHandler);

            // Enable scrolling zoom
            that.find('iframe').css("pointer-events", "auto");

            // Handle the mouse leave event
            that.on('mouseleave', Core.onMapMouseleaveHandler);
        },
        processWord : function () {
            $('h2','.page-title-wrapper').lastWord();
        },
        process_Blog : function() {
            Core.blog_switcher();
            Core.blog_infinite_scroll();
            Core.blog_jplayer();
            Core.blog_hr();
            Core.blog_load_more();
            if ($('.entry-tag-social .entry-share-wrapper').length == 0) {
                if ($('.entry-tag-social .entry-tag-wrapper').length == 0) {
                    $('.entry-tag-social').remove();
                } else {
                    $('.entry-tag-social .entry-tag-wrapper').addClass('entry-tag-full-wrapper');
                }
            }

        },
        blog_load_more : function() {
            $('.blog-load-more').on('click',function(event){
                event.preventDefault();
                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var contentWrapper = '.blog-inner';
                var element = 'article';

                $.get(link,function(data) {
                    var next_href = $('.blog-load-more',data).attr('data-href');
                    var $newElems = $(element,data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);

                    $newElems.imagesLoaded(function () {
                        Core.owlCarousel();
                        Core.blog_jplayer();
                        Core.blog_hr();

                        $newElems.animate({
                            opacity: 1
                        });
                    });

                    if (typeof(next_href) == 'undefined') {
                        $this.hide();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href',next_href);
                    }

                });
            });
        },
        blog_jplayer : function() {
            $('.jp-jplayer').each(function () {
                var $this = $(this),
                    url = $this.data('audio'),
                    title = $this.data('title'),
                    type = url.substr(url.lastIndexOf('.') + 1),
                    player = '#' + $this.data('player'),
                    audio = {};
                audio[type] = url;
                audio['title'] = title;
                $this.jPlayer({
                    ready              : function () {
                        $this.jPlayer('setMedia', audio);
                    },
                    swfPath            : '../plugins/jquery.jPlayer',
                    cssSelectorAncestor: player
                });


            });

            Core.processWidthAudioPlayer();
        },
        processWidthAudioPlayer : function(){
            setTimeout(function(){
                $('.jp-audio').each(function(){
                    var _width = $(this).outerWidth() - $('.jp-play-pause',this).outerWidth() - $('.jp-volume',this).outerWidth() - 46;
                    $('.jp-progress',this).width(_width);

                });
            },100);
        },
        blog_switcher : function() {
            $('a','.blog-switcher-wrapper').on('click',function() {
                if ($(this).hasClass('blog-switcher-active')) return;
                var $this = $(this);
                $('a.blog-switcher-active','.blog-switcher-wrapper').removeClass('blog-switcher-active');
                $.cookie('cupid-blog-style',$this.attr('data-rel'));
                $(this).addClass('blog-switcher-active');
                $('.blog-inner').fadeOut(500,function(){
                    $('.blog-inner').removeClass($this.attr('data-unrel')).addClass($this.attr('data-rel'));
                    Core.blog_hr();
                    Core.processWidthAudioPlayer();

                    $('.owl-carousel','.blog-inner').each(function() {
                        var owl = $(this).data('owlCarousel').destroy();
                        if (typeof (owl) != 'undefined') {
                            owl.destroy();
                        }
                    });
                    Core.owlCarousel();
                    $('.blog-inner').fadeIn(500);
                })
            });
        },
        blog_infinite_scroll : function() {
            $('.blog-inner').infinitescroll({
                navSelector  	: "#infinite_scroll_button",
                nextSelector 	: "#infinite_scroll_button a",
                itemSelector 	: "article",
                loading : {
                    'selector' : '#infinite_scroll_loading',
                    'img' : cupid_theme_url + 'assets/images/ajax-loader.gif',
                    'msgText' : 'Loading...',
                    'finishedMsg' : ''
                }
            }, function(newElements, data, url){
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function () {
                    Core.owlCarousel();
                    Core.blog_jplayer();
                    Core.blog_hr();
                    $newElems.animate({
                        opacity: 1
                    });
                });

            });
        },
        blog_hr : function () {
            $('hr','[data-hr="true"]').remove();
            var blog_col = parseInt($('[data-hr="true"]').attr('data-col'),10) ;
            $('article','[data-hr="true"]').each(function(i){
                if (i > 0 && i % blog_col == 0) {
                    $(this).before("<hr/>");
                }
            });
        },
		iframe_height_in_widget_area: function() {
			$('.footer-top-widget-area .footer-col-3').each(function(index){
				var footer_top_width = $('.footer-top-widget-area').width() - 1;
				if (footer_top_width < 1200) {
					$(this).css('width','');
					return;
				}
				var col_center_width = 458;
				if (index == 1) {
					$(this).css('width',col_center_width + 'px');
				}
				else {
					$(this).css('width', ((footer_top_width - col_center_width)*1.0/2) + 'px');
				}
			});
			setTimeout(function(){
				$('.footer-top-widget-area .footer-col-3').each(function(){
					var $this = $(this);
					if ($('aside', $this).length > 1) {
						return;
					}
					$('iframe', $this).css('height','');
					if ($(window).width() < 768) {
						return;
					}
					setTimeout(function(){
						if ($('iframe', $this).outerHeight() < $('.footer-top-widget-area').height()) {
							$('iframe', $this).css('height', $('.footer-top-widget-area').height() + 'px');
						}
					}, 50);
				});

			}, 100);
		},
		login_link_event: function() {
			$('.cupid-login-link .login-link, .cupid-login-link .sign-up-link').off('click').click(function() {
				var action_name = 'cupid_login';
				if ($(this).hasClass('sign-up-link')) {
					action_name = 'cupid_sign_up'
				}
				var popupWrapper = '#cupid-popup-login-wrapper';
				Core.show_loading();
				$.ajax({
					type   : 'POST',
					data   : 'action=' + action_name,
					url    : cupid_ajax_url,
					success: function (html) {
						Core.hide_loading();
						if ($(popupWrapper).length) {
							$(popupWrapper).remove();
						}
						$('body').append(html);

						$(popupWrapper).modal();

						$('#cupid-popup-login-form').submit(function(event) {
							var input_data = $('#cupid-popup-login-form').serialize();
							Core.show_loading();
							jQuery.ajax({
								type   : 'POST',
								data   : input_data,
								url    : cupid_ajax_url,
								success: function (html) {
									Core.hide_loading();
									var response_data = jQuery.parseJSON(html);
									if (response_data.code < 0) {
										jQuery('.login-message', '#cupid-popup-login-form').html(response_data.message);
									}
									else {
										window.location.reload();
									}
								},
								error  : function (html) {
									Core.hide_loading();
								}
							});
							event.preventDefault();
							return false;
						});
					},
					error  : function (html) {
						Core.hide_loading();
					}
				});
			});
		},
		show_loading: function() {
			$('body').addClass('overflow-hidden');
			if ($('.loading-wrapper').length == 0) {
				$('body').append('<div class="loading-wrapper"><span class="spinner-double-section-far"></span></div>');
			}
		},
		hide_loading: function() {
			$('.loading-wrapper').fadeOut(function() {
				$('.loading-wrapper').remove();
				$('body').removeClass('overflow-hidden');
			});
		},
        classes_switcher : function() {
            $('a','.classes-switcher-wrapper').on('click',function() {
                if ($(this).hasClass('blog-switcher-active')) return;
                var $this = $(this);
                $('a.classes-switcher-active','.classes-switcher-wrapper').removeClass('classes-switcher-active');
                $.cookie('cupid-classes-style',$this.attr('data-rel'));
                $(this).addClass('classes-switcher-active');
                $('.classes-inner').fadeOut(500,function(){
                    $('.classes-inner').removeClass($this.attr('data-unrel')).addClass($this.attr('data-rel'));
                    Core.classes_hr();
                    $('.classes-inner').fadeIn(500);
                })
            });
        },
        classes_hr:function(){
            var $style = $.cookie('cupid-classes-style');
            var contentWrapper = '.archive-cupid-class .classes-inner';
            var col = parseInt($('.archive-cupid-class .classes-inner').attr('data-col'),10) ;
            if($style=='list')
                col = 1;
            $('hr',contentWrapper).remove();
            $('.classes-item',contentWrapper).each(function(i){
                if (i > 0 && i % col == 0) {
                    $(this).before("<hr class='separate-line' />");
                }
            });
        },
        classes_load_more: function() {
            $('.blog-load-more').on('click',function(event){
                event.preventDefault();
                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var class_item = '.classes-item';
                Core.classes_bind_paging(link);
            });

        },
        classes_bind_paging:function(link, callback){
            $.get(link,function(data) {
                var contentWrapper = '.archive-cupid-class .classes-inner';
                var next_href = $('.blog-load-more',data).attr('data-href');
                var $elms = $($(contentWrapper,data).html()).css({opacity: 0});
                var $this = $(this).button('loading');
                $('.archive-cupid-class .classes-inner').append($elms);
                $elms.imagesLoaded(function () {
                    $elms.animate({
                        opacity: 1
                    });
                    Core.classes_hr();
                });
                if (typeof(next_href) == 'undefined') {
                    $this.hide();
                } else {
                    $this.button('reset');
                    $this.attr('data-href',next_href);
                }
                if(callback)
                    callback();

            });
        },
        classes_search_event: function(){
            $('#keyword_classes','.archive-cupid-class').keypress(function(e){
                var code = (e.keyCode ? e.keyCode : e.which);
                if(code==13){
                    Core.classes_search();
                }
            });
            $('#bt_search','.archive-cupid-class').click(function(){
                Core.classes_search();
            });
            $('i.fa-close','.archive-cupid-class .keyword-wrapper').click(function(){
                $('.archive-cupid-class .classes-inner').empty();
                $('#keyword_classes','.archive-cupid-class').val('');
                $(this).removeClass();
                $(this).addClass('fa fa-refresh fa-spin');
                Core.classes_bind_paging('',function(){
                    var $i = $('i','.archive-cupid-class .keyword-wrapper');
                    $($i).removeClass();
                    $($i).addClass('fa fa-close');
                    $($i).css({opacity:0});
                });
            });
        },
        classes_search: function(){
            var $keyword =$('#keyword_classes','.archive-cupid-class').val();
            if($keyword!=''){
                var $btSearch = $('#bt_search','.archive-cupid-class');
                $btSearch.attr("disabled", true);
                $('i',$btSearch).removeClass();
                $('i',$btSearch).addClass('fa fa-refresh fa-spin');

                $.ajax({
                    url: cupid_ajax_url,
                    data: ({action : 'cupid_classes_search', keyword: $keyword
                    }),
                    success: function(data) {
                        $('.blog-load-more-wrapper','.archive-cupid-class').hide();
                        $('i.fa-close','.archive-cupid-class .keyword-wrapper').css({opacity:1});
                        var contentWrapper = '.archive-cupid-class .classes-inner';
                        $(contentWrapper).css({opacity: 0});
                        $(contentWrapper).empty();
                        var $elms = $(data);

                            $elms.imagesLoaded(function () {
                                $(contentWrapper).append($elms);
                                $(contentWrapper).animate({
                                    opacity: 1
                                });
                            });
                            Core.classes_hr();
                            $btSearch.removeAttr("disabled");
                            $('i',$btSearch).removeClass();
                            $('i',$btSearch).addClass('fa fa-search');
                    }
                });
            }
        },
        page404_search:function(){
            $('#keyword_404','.page404').keypress(function(e){
                var code = (e.keyCode ? e.keyCode : e.which);
                if(code==13){
                    $('#bt_search_404','.page404').click();
                }
            });
          $('#bt_search_404','.page404').click(function(){
                var keyword = $('#keyword_404','.page404').val();
                if(keyword!=''){
                    keyword = keyword.replace(/ /g,'+');
                    console.log(keyword);
                    window.location= cupid_site_url + '?s=' + keyword;
                }
          })
        },
		mega_menu_process: function(isInit) {
			if (isInit) {
				$('.main-menu b.caret').click(function(event){
					if ($(window).width() >= 992) {
						return;
					}
					event.preventDefault();
					$('> ul.dropdown-menu', $(this).parent().parent()).toggle();
				});
				$('.main-menu > li > a > i.fa.fa-search').click(function(event){
					event.preventDefault();
					$('.header .icon-search-menu').trigger('click');
				});
			}
			if ($(window).width() >= 992) {
				$('.main-menu ul.dropdown-menu').css('display','');
			}
			setTimeout(function(){
				jQuery('> .mega-menu', '.main-menu').hover(function(){
					if ($(window).width() < 992) {
						return;
					}
					var dropdown_width = 0;
					var $this = $(this);
					var container_width = $('header .navbar-default > .container').outerWidth();

					if (jQuery('> ul.dropdown-menu', this).hasClass('not-auto-size')) {
						dropdown_width = $('> ul.dropdown-menu > li', $this).outerWidth();
					}
					else {
						$('.yamm-content > .row > .menu-item', $this).each(function(){
							dropdown_width += $(this).outerWidth();
						});
					}

					if ($this.hasClass('yamm-fw')) {
						$('> ul', $this).css('left', '15px');
						$('> ul', $this).css('right', '15px');
					}
					else {
						if ($this.hasClass('drop-to-left')) {
							if ($this.width() + $this.position().left < dropdown_width) {
								$('> ul', $this).css('right','auto');
								$('> ul', $this).css('left', '15px');
							}
							else {
								var left = jQuery(this).position().left + 15;
								$('> ul', $this).css('right', (container_width - $this.width() - $this.position().left) + 'px');
								$('> ul', $this).css('left','auto');
							}
						}
						if ($this.hasClass('drop-to-right')) {
							if (container_width - $this.position().left < dropdown_width) {
								$('> ul', $this).css('right','15px');
								$('> ul', $this).css('left', 'auto');
							}
							else {
								var right = jQuery(this).position().left + 15;
								$('> ul', $this).css('left', ($this.position().left) + 'px');
								$('> ul', $this).css('right','auto');
							}
						}
					}
				});
			}, 100);
		},
		search_popup_process: function () {
			$('header .icon-search-menu').click(function(event){
				event.preventDefault();
				Core.search_popup_open();
			});
			$('.cupid-dismiss-modal, .modal-backdrop', '#cupid-modal-search').click(function(){
				Core.search_popup_close();
			});
			$('.cupid-search-wrapper button > i.ajax-search-icon').click(function(){
				s_search();
			});

			// search
			$('#search-ajax', '#cupid-modal-search').on('keyup', function(event){
				var s_timeOut_search = null;
				if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
					return;
				}

				var keys = ["Control", "Alt", "Shift"];
				if (keys.indexOf(event.key) != -1) return;
				switch (event.which) {
					case 27:	// ESC
						Core.search_popup_close();
						break;
					case 38:	// UP
						s_up();
						break;
					case 40:	// DOWN
						s_down();
						break;
					case 13:	//ENTER
						var $item = $('li.selected a', '#cupid-modal-search');
						if ($item.length == 0) {
							event.preventDefault();
							return false;
						}
						s_enter();
						break;
					default:
						clearTimeout(Core.timeOut_search);
						Core.timeOut_search = setTimeout(s_search, 500);
						break;
				}
			});

			function s_up(){
				var $item = $('li.selected', '#cupid-modal-search');
				if ($('li', '#cupid-modal-search').length < 2) return;
				var $prev = $item.prev();
				$item.removeClass('selected');
				if ($prev.length) {
					$prev.addClass('selected');
				}
				else {
					$('li:last', '#cupid-modal-search').addClass('selected');
					$prev = $('li:last', '#cupid-modal-search');
				}
				if ($prev.position().top < jQuery('#cupid-modal-search .ajax-search-result').scrollTop()) {
					jQuery('#cupid-modal-search .ajax-search-result').scrollTop($prev.position().top);
				}
				else if ($prev.position().top + $prev.outerHeight() > jQuery('#cupid-modal-search .ajax-search-result').scrollTop() + jQuery('#cupid-modal-search .ajax-search-result').height()) {
					jQuery('#cupid-modal-search .ajax-search-result').scrollTop($prev.position().top - jQuery('#cupid-modal-search .ajax-search-result').height() + $prev.outerHeight());
				}
			}
			function s_down() {
				var $item = $('li.selected', '#cupid-modal-search');
				if ($('li', '#cupid-modal-search').length < 2) return;
				var $next = $item.next();
				$item.removeClass('selected');
				if ($next.length) {
					$next.addClass('selected');
				}
				else {
					$('li:first', '#cupid-modal-search').addClass('selected');
					$next = $('li:first', '#cupid-modal-search');
				}
				if ($next.position().top < jQuery('#cupid-modal-search .ajax-search-result').scrollTop()) {
					jQuery('#cupid-modal-search .ajax-search-result').scrollTop($next.position().top);
				}
				else if ($next.position().top + $next.outerHeight() > jQuery('#cupid-modal-search .ajax-search-result').scrollTop() + jQuery('#cupid-modal-search .ajax-search-result').height()) {
					jQuery('#cupid-modal-search .ajax-search-result').scrollTop($next.position().top - jQuery('#cupid-modal-search .ajax-search-result').height() + $next.outerHeight());
				}
			}
			function s_enter() {
				var $item = $('li.selected a', '#cupid-modal-search');
				if ($item.length > 0) {
					window.location = $item.attr('href');
				}
			}
			function s_search() {
				var keyword = $('input[type="search"]', '#cupid-modal-search').val();
				if (keyword.length < 2) {
					$('.ajax-search-result', '#cupid-modal-search').html('');
					return;
				}
				$('.ajax-search-icon', '#cupid-modal-search').addClass('fa fa-spinner fa-spin');
				$('.ajax-search-icon', '#cupid-modal-search').removeClass('icon-search');
				$.ajax({
					type   : 'POST',
					data   : 'action=result_search&keyword=' + keyword,
					url    : cupid_ajax_url,
					success: function (data) {
						$('.ajax-search-icon', '#cupid-modal-search').removeClass('fa fa-spinner fa-spin');
						$('.ajax-search-icon', '#cupid-modal-search').addClass('icon-search');
						var html = '';
						if (data) {
							var items = $.parseJSON(data);
							if (items.length) {
								html +='<ul>';
								if (items[0]['id'] == -1) {
									html += '<li class="selected">' + items[0]['title']  + '</li>';
								}
								else {
									$.each(items, function (index) {
										if (index == 0) {
											html += '<li class="selected">';
										}
										else {
											html += '<li>';
										}
										if (this['title'] == null || this['title'] == '') {
											html += '<a href="' + this['guid'] + '">' + this['date'] + '</a>';
										}
										else {
											html += '<a href="' + this['guid'] + '">' + this['title'] + '</a>';
											html += '<span>' + this['date'] + ' </span>';
										}

										html += '</li>';
									});
								}


								html +='</ul>';
							}
							else {
								html = '';
							}
						}
						$('.ajax-search-result', '#cupid-modal-search').html(html);
						jQuery('#cupid-modal-search .ajax-search-result').scrollTop(0);
					},
					error : function(data) {
						$('.ajax-search-icon', '#cupid-modal-search').removeClass('fa fa-spinner fa-spin');
						$('.ajax-search-icon', '#cupid-modal-search').addClass('icon-search');
					}
				});
			}
		},
		search_popup_open : function() {
			if (!$('#cupid-modal-search').hasClass('in')) {
				$('#cupid-modal-search').show();
				setTimeout(function() {
					$('#cupid-modal-search').addClass('in');
				}, 300);
				$('#search-ajax', '#cupid-modal-search').focus();
				$('#search-ajax', '#cupid-modal-search').val('');
				$('.ajax-search-result', '#cupid-modal-search').html('')
			}
		},
		search_popup_close : function() {
			if ($('#cupid-modal-search').hasClass('in')) {
				$('#cupid-modal-search').removeClass('in');
				setTimeout(function(){
					$('#cupid-modal-search').hide();
				}, 300);
			}
		},
        page_animsition: function() {

            $(".animsition").animsition({

                inClass               :   'fade-in',
                outClass              :   'fade-out',
                inDuration            :    1500,
                outDuration           :    800,
                linkElement           :   '.animsition-link:not([href^=#]):not([target="_blank"]):not([href^=javascript])',
                // e.g. linkElement   :   'a:not([target="_blank"]):not([href^=#])'
                loading               :    true,
                loadingParentElement  :   'body', //animsition wrapper element
                loadingClass          :   'animsition-loading',
                unSupportCss          : [ 'animation-duration',
                    '-webkit-animation-duration',
                    '-o-animation-duration'
                ],
                //"unSupportCss" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
                //The default setting is to disable the "animsition" in a browser that does not support "animation-duration".

                overlay               :   false,

                overlayClass          :   'animsition-overlay-slide',
                overlayParentElement  :   'body'
            });
        },
		widget_default_process: function() {
			$('.footer-top-widget-area aside.widget').each(function() {
				if ($('select', this).length > 0) {
					var $select = $('select', this);
					$('select', this).remove();
					$(this).append('<div class="select-widget"></div>');
					$('> .select-widget', this).append($select);
				}
			});
		},
        process_product : function() {
            Core.product_animated();
            Core.add_cart_quantity();
            Core.select2();
        },
        add_cart_quantity : function() {
            $(document).off('click','.quantity .btn-number').on('click','.quantity .btn-number',function(event) {
                event.preventDefault();
                var type = $(this).data('type');
                var input =$('input',$(this).parent());
                var current_value = parseInt(input.val());

                var max = input.attr('max');
                if (typeof(max) == 'undefined' ) {
                    max = 100;
                }

                var min = input.attr('min');
                if (typeof(min) == 'undefined' ) {
                    min = 0;
                }
                if (!isNaN(current_value)) {
                    if (type == 'minus') {
                        if(current_value > min) {
                            input.val(current_value - 1).change();
                        }
                        if(parseInt(input.val()) == min) {
                            $(this).attr('disabled', true);
                        }
                    }

                    if (type == 'plus') {

                        if(current_value < max) {
                            input.val(current_value + 1).change();
                        }
                        if(parseInt(input.val()) == max) {
                            $(this).attr('disabled', true);
                        }
                    }
                } else {
                    input.val(0);
                }
            });


            $('input','.quantity').focusin(function(){
                $(this).data('oldValue', $(this).val());
            });

            $('input','.quantity').on('change',function() {
                var input = $(this);
                var max = input.attr('max');
                if (typeof(max) == 'undefined' ) {
                    max = 100;
                }

                var min = input.attr('min');
                if (typeof(min) == 'undefined' ) {
                    min = 0;
                }

                var current_value = parseInt(input.val());

                if(current_value >= min) {
                    $(".btn-number[data-type='minus']",$(this).parent()).removeAttr('disabled');
                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
                }

                if(current_value <= max) {
                    $(".btn-number[data-type='plus']",$(this).parent()).removeAttr('disabled');
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                }

            });

        },
        product_animated : function(){
            var window_width = $(window).width();
            $('.product_animated').each(function(){
                var col = parseInt( $(this).data('col'),10);
                if (isNaN(col)) {
                    col = 0;
                }
                var index = 0;
                $('div.product-item-wrapper:not(".umScaleIn")',$(this)).each(function (i) {
                    var el = $(this);

                    if ((col > 0) && ( i % col == 0)){
                        index = 0;
                    }
                    var animation_delay = index * 300;
                    index++;
                    if (window_width > 991) {
                        el.css({
                            '-webkit-animation-delay':  animation_delay +'ms',
                            '-moz-animation-delay':     animation_delay +'ms',
                            '-ms-animation-delay' : animation_delay +'ms',
                            '-o-animation-delay' : animation_delay + 'ms',
                            'animation-delay':          animation_delay + 'ms'
                        });
                    }
                    el.waypoint(function(){
                        el.addClass('animated').addClass('umScaleIn');
                    },{
                        triggerOnce: true,
                        offset: '90%'
                    });
                });
            });
        },
        select2 : function() {
            $('.woocommerce form .form-row select').select2();
        }

    };
    $(document).ready(function(){
        Core.initialize();
    });
})(jQuery);
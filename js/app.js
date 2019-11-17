var public_vars = public_vars || {}; 
(function($, window, undefined) {
    "use strict";
    $(document).ready(function() {
		// Main Vars
        public_vars.$body                 = $("body");
        public_vars.$pageContainer        = public_vars.$body.find(".page-container");
        public_vars.$chat                 = public_vars.$pageContainer.find("#chat");
        public_vars.$sidebarMenu          = public_vars.$pageContainer.find('.sidebar-menu');
        public_vars.$sidebarProfile       = public_vars.$sidebarMenu.find('.sidebar-user-info');
        public_vars.$mainMenu             = public_vars.$sidebarMenu.find('.main-menu');
        public_vars.$horizontalNavbar     = public_vars.$body.find('.navbar.horizontal-menu');
        public_vars.$horizontalMenu       = public_vars.$horizontalNavbar.find('.navbar-nav');
        public_vars.$mainContent          = public_vars.$pageContainer.find('.main-content');
        public_vars.$mainFooter           = public_vars.$body.find('footer.main-footer');
        public_vars.$userInfoMenuHor      = public_vars.$body.find('.navbar.horizontal-menu');
        public_vars.$userInfoMenu         = public_vars.$body.find('nav.navbar.user-info-navbar');
        public_vars.$settingsPane         = public_vars.$body.find('.settings-pane');
        public_vars.$settingsPaneIn       = public_vars.$settingsPane.find('.settings-pane-inner');
        public_vars.wheelPropagation      = true;
        public_vars.$pageLoadingOverlay   = public_vars.$body.find('.page-loading-overlay');
        public_vars.defaultColorsPalette  = ['#68b828', '#7c38bc', '#0e62c7', '#fcd036', '#4fcdfc', '#00b19d', '#ff6264', '#f7aa47'];
        
		// Setup Sidebar Menu
		setup_sidebar_menu();
		// Setup Horizontal Menu
        setup_horizontal_menu();
        
		// Sticky Footer
		if(public_vars.$mainFooter.hasClass('sticky'))
		{
			stickFooterToBottom();
			$(window).on('xenon.resized', stickFooterToBottom);
		}
		// Go to top links
		$('body').on('click', 'a[rel="go-top"]', function(ev)
		{
			ev.preventDefault();

			var obj = {pos: $(window).scrollTop()};

			TweenLite.to(obj, .3, {pos: 0, ease:Power4.easeOut, onUpdate: function()
			{
				$(window).scrollTop(obj.pos);
			}});
		}); 
        if ($.isFunction($.fn.tocify) && $("#toc").length) {
            $("#toc").tocify({
                context: '.tocify-content',
                selectors: "h2,h3,h4,h5"
            });
            var $this = $(".tocify"),
            watcher = scrollMonitor.create($this.get(0));
            $this.width($this.parent().width());
            watcher.lock();
            watcher.stateChange(function() {
                $($this.get(0)).toggleClass('fixed', this.isAboveViewport)
            })
        }
        $(".login-form .form-group:has(label)").each(function(i, el) {
            var $this = $(el),
            $label = $this.find('label'),
            $input = $this.find('.form-control');
            $input.on('focus',
            function() {
                $this.addClass('is-focused')
            });
            $input.on('keydown',
            function() {
                $this.addClass('is-focused')
            });
            $input.on('blur',
            function() {
                $this.removeClass('is-focused');
                if ($input.val().trim().length > 0) {
                    $this.addClass('is-focused')
                }
            });
            $label.on('click',
            function() {
                $input.focus()
            });
            if ($input.val().trim().length > 0) {
                $this.addClass('is-focused')
            }
        })
    });
    var wid = 0;
    $(window).resize(function() {
        clearTimeout(wid);
        wid = setTimeout(trigger_resizable, 200)
    })
})(jQuery, window);
var sm_duration = .2,
sm_transition_delay = 150;
function setup_sidebar_menu() {
    if (public_vars.$sidebarMenu.length) {
        var $items_with_subs = public_vars.$sidebarMenu.find('li:has(> ul)'),
        toggle_others = public_vars.$sidebarMenu.hasClass('toggle-others');
        $items_with_subs.filter('.active').addClass('expanded');
        if (is('largescreen') && public_vars.$sidebarMenu.hasClass('collapsed') == false) {
            $(window).on('resize',
            function() {
                if (is('tabletscreen')) {
                    public_vars.$sidebarMenu.addClass('collapsed');
                    ps_destroy()
                } else if (is('largescreen')) {
                    public_vars.$sidebarMenu.removeClass('collapsed');
                    ps_init()
                }
            })
        }
        $items_with_subs.each(function(i, el) {
            var $li = jQuery(el),
            $a = $li.children('a'),
            $sub = $li.children('ul');
            $li.addClass('has-sub');
            $a.on('click',
            function(ev) {
                ev.preventDefault();
                if (toggle_others) {
                    sidebar_menu_close_items_siblings($li)
                }
                if ($li.hasClass('expanded') || $li.hasClass('opened')) sidebar_menu_item_collapse($li, $sub);
                else sidebar_menu_item_expand($li, $sub)
            })
        })
    }
}
function sidebar_menu_item_expand($li, $sub) {
    if ($li.data('is-busy') || ($li.parent('.main-menu').length && public_vars.$sidebarMenu.hasClass('collapsed'))) return;
    $li.addClass('expanded').data('is-busy', true);
    $sub.show();
    var $sub_items = $sub.children(),
    sub_height = $sub.outerHeight(),
    win_y = jQuery(window).height(),
    total_height = $li.outerHeight(),
    current_y = public_vars.$sidebarMenu.scrollTop(),
    item_max_y = $li.position().top + current_y,
    fit_to_viewpport = public_vars.$sidebarMenu.hasClass('fit-in-viewport');
    $sub_items.addClass('is-hidden');
    $sub.height(0);
    TweenMax.to($sub, sm_duration, {
        css: {
            height: sub_height
        },
        onUpdate: ps_update,
        onComplete: function() {
            $sub.height('')
        }
    });
    var interval_1 = $li.data('sub_i_1'),
    interval_2 = $li.data('sub_i_2');
    window.clearTimeout(interval_1);
    interval_1 = setTimeout(function() {
        $sub_items.each(function(i, el) {
            var $sub_item = jQuery(el);
            $sub_item.addClass('is-shown')
        });
        var finish_on = sm_transition_delay * $sub_items.length,
        t_duration = parseFloat($sub_items.eq(0).css('transition-duration')),
        t_delay = parseFloat($sub_items.last().css('transition-delay'));
        if (t_duration && t_delay) {
            finish_on = (t_duration + t_delay) * 1000
        }
        window.clearTimeout(interval_2);
        interval_2 = setTimeout(function() {
            $sub_items.removeClass('is-hidden is-shown')
        },
        finish_on);
        $li.data('is-busy', false)
    },
    0);
    $li.data('sub_i_1', interval_1),
    $li.data('sub_i_2', interval_2)
}
function sidebar_menu_item_collapse($li, $sub) {
    if ($li.data('is-busy')) return;
    var $sub_items = $sub.children();
    $li.removeClass('expanded').data('is-busy', true);
    $sub_items.addClass('hidden-item');
    TweenMax.to($sub, sm_duration, {
        css: {
            height: 0
        },
        onUpdate: ps_update,
        onComplete: function() {
            $li.data('is-busy', false).removeClass('opened');
            $sub.attr('style', '').hide();
            $sub_items.removeClass('hidden-item');
            $li.find('li.expanded ul').attr('style', '').hide().parent().removeClass('expanded');
            ps_update(true)
        }
    })
}
function sidebar_menu_close_items_siblings($li) {
    $li.siblings().not($li).filter('.expanded, .opened').each(function(i, el) {
        var $_li = jQuery(el),
        $_sub = $_li.children('ul');
        sidebar_menu_item_collapse($_li, $_sub)
    })
}

// Horizontal Menu
function setup_horizontal_menu()
{
	if(public_vars.$horizontalMenu.length)
	{
		var $items_with_subs = public_vars.$horizontalMenu.find('li:has(> ul)'),
			click_to_expand = public_vars.$horizontalMenu.hasClass('click-to-expand');

		if(click_to_expand)
		{
			public_vars.$mainContent.add( public_vars.$sidebarMenu ).on('click', function(ev)
			{
				$items_with_subs.removeClass('hover');
			});
		}

		$items_with_subs.each(function(i, el)
		{
			var $li = jQuery(el),
				$a = $li.children('a'),
				$sub = $li.children('ul'),
				is_root_element = $li.parent().is('.navbar-nav');

			$li.addClass('has-sub');

			// Mobile Only
			$a.on('click', function(ev)
			{
				if(isxs())
				{
					ev.preventDefault();

					// Automatically will toggle other menu items in mobile view
					if(true)
					{
						sidebar_menu_close_items_siblings($li);
					}

					if($li.hasClass('expanded') || $li.hasClass('opened'))
						sidebar_menu_item_collapse($li, $sub);
					else
						sidebar_menu_item_expand($li, $sub);
				}
			});

			// Click To Expand
			if(click_to_expand)
			{
				$a.on('click', function(ev)
				{
					ev.preventDefault();

					if(isxs())
						return;

					// For parents only
					if(is_root_element)
					{
						$items_with_subs.filter(function(i, el){ return jQuery(el).parent().is('.navbar-nav'); }).not($li).removeClass('hover');
						$li.toggleClass('hover');
					}
					// Sub menus
					else
					{
						var sub_height;

						// To Expand
						if($li.hasClass('expanded') == false)
						{
							$li.addClass('expanded');
							$sub.addClass('is-visible');

							sub_height = $sub.outerHeight();

							$sub.height(0);

							TweenLite.to($sub, .15, {css: {height: sub_height}, ease: Sine.easeInOut, onComplete: function(){ $sub.attr('style', ''); }});

							// Hide Existing in the list
							$li.siblings().find('> ul.is-visible').not($sub).each(function(i, el)
							{
								var $el = jQuery(el);

								sub_height = $el.outerHeight();

								$el.removeClass('is-visible').height(sub_height);
								$el.parent().removeClass('expanded');

								TweenLite.to($el, .15, {css: {height: 0}, onComplete: function(){ $el.attr('style', ''); }});
							});
						}
						// To Collapse
						else
						{
							sub_height = $sub.outerHeight();

							$li.removeClass('expanded');
							$sub.removeClass('is-visible').height(sub_height);
							TweenLite.to($sub, .15, {css: {height: 0}, onComplete: function(){ $sub.attr('style', ''); }});
						}
					}
				});
			}
			// Hover To Expand
			else
			{
				$li.hoverIntent({
					over: function()
					{
						if(isxs())
							return;

						if(is_root_element)
						{
							$li.addClass('hover');
						}
						else
						{
							$sub.addClass('is-visible');
							sub_height = $sub.outerHeight();

							$sub.height(0);

							TweenLite.to($sub, .25, {css: {height: sub_height}, ease: Sine.easeInOut, onComplete: function(){ $sub.attr('style', ''); }});
						}
					},
					out: function()
					{
						if(isxs())
							return;

						if(is_root_element)
						{
							$li.removeClass('hover');
						}
						else
						{
							sub_height = $sub.outerHeight();

							$li.removeClass('expanded');
							$sub.removeClass('is-visible').height(sub_height);
							TweenLite.to($sub, .25, {css: {height: 0}, onComplete: function(){ $sub.attr('style', ''); }});
						}
					},
					timeout: 200,
					interval: is_root_element ? 10 : 100
				});
			}
		});
	}
}


function stickFooterToBottom()
{
	public_vars.$mainFooter.add( public_vars.$mainContent ).add( public_vars.$sidebarMenu ).attr('style', '');

	if(isxs())
		return false;

	if(public_vars.$mainFooter.hasClass('sticky'))
	{
		var win_height				 = jQuery(window).height(),
			footer_height			= public_vars.$mainFooter.outerHeight(true),
			main_content_height	  = public_vars.$mainFooter.position().top + footer_height,
			main_content_height_only = main_content_height - footer_height,
			extra_height			 = public_vars.$horizontalNavbar.outerHeight();


		if(win_height > main_content_height - parseInt(public_vars.$mainFooter.css('marginTop'), 10))
		{
			public_vars.$mainFooter.css({
				marginTop: win_height - main_content_height - extra_height
			});
		}
	}
}

function ps_update(destroy_init) {
    if (isxs()) return;
    if (jQuery.isFunction(jQuery.fn.perfectScrollbar)) {
        if (public_vars.$sidebarMenu.hasClass('collapsed')) {
            return
        }
        public_vars.$sidebarMenu.find('.sidebar-menu-inner').perfectScrollbar('update');
        if (destroy_init) {
            ps_destroy();
            ps_init()
        }
    }
}
function ps_init() {
    if (isxs()) return;
    if (jQuery.isFunction(jQuery.fn.perfectScrollbar)) {
        if (public_vars.$sidebarMenu.hasClass('collapsed') || !public_vars.$sidebarMenu.hasClass('fixed')) {
            return
        }
        public_vars.$sidebarMenu.find('.sidebar-menu-inner').perfectScrollbar({
            wheelSpeed: 1,
            wheelPropagation: public_vars.wheelPropagation
        })
    }
}
function ps_destroy() {
    if (jQuery.isFunction(jQuery.fn.perfectScrollbar)) {
        public_vars.$sidebarMenu.find('.sidebar-menu-inner').perfectScrollbar('destroy')
    }
}
function cbr_replace() {
    var $inputs = jQuery('input[type="checkbox"].cbr, input[type="radio"].cbr').filter(':not(.cbr-done)'),
    $wrapper = '<div class="cbr-replaced"><div class="cbr-input"></div><div class="cbr-state"><span></span></div></div>';
    $inputs.each(function(i, el) {
        var $el = jQuery(el),
        is_radio = $el.is(':radio'),
        is_checkbox = $el.is(':checkbox'),
        is_disabled = $el.is(':disabled'),
        styles = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'purple', 'blue', 'red', 'gray', 'pink', 'yellow', 'orange', 'turquoise'];
        if (!is_radio && !is_checkbox) return;
        $el.after($wrapper);
        $el.addClass('cbr-done');
        var $wrp = $el.next();
        $wrp.find('.cbr-input').append($el);
        if (is_radio) $wrp.addClass('cbr-radio');
        if (is_disabled) $wrp.addClass('cbr-disabled');
        if ($el.is(':checked')) {
            $wrp.addClass('cbr-checked')
        }
        jQuery.each(styles,
        function(key, val) {
            var cbr_class = 'cbr-' + val;
            if ($el.hasClass(cbr_class)) {
                $wrp.addClass(cbr_class);
                $el.removeClass(cbr_class)
            }
        });
        $wrp.on('click',
        function(ev) {
            if (is_radio && $el.prop('checked') || $wrp.parent().is('label')) return;
            if (jQuery(ev.target).is($el) == false) {
                $el.prop('checked', !$el.is(':checked'));
                $el.trigger('change')
            }
        });
        $el.on('change',
        function(ev) {
            $wrp.removeClass('cbr-checked');
            if ($el.is(':checked')) $wrp.addClass('cbr-checked');
            cbr_recheck()
        })
    })
}
function cbr_recheck() {
    var $inputs = jQuery("input.cbr-done");
    $inputs.each(function(i, el) {
        var $el = jQuery(el),
        is_radio = $el.is(':radio'),
        is_checkbox = $el.is(':checkbox'),
        is_disabled = $el.is(':disabled'),
        $wrp = $el.closest('.cbr-replaced');
        if (is_disabled) $wrp.addClass('cbr-disabled');
        if (is_radio && !$el.prop('checked') && $wrp.hasClass('cbr-checked')) {
            $wrp.removeClass('cbr-checked')
        }
    })
}
function attrDefault($el, data_var, default_val) {
    if (typeof $el.data(data_var) != 'undefined') {
        return $el.data(data_var)
    }
    return default_val
}
function callback_test() {
    alert("Callback function executed! No. of arguments: " + arguments.length + "\n\nSee console log for outputed of the arguments.");
    console.log(arguments)
}; 

(function($, window, undefined) {
    "use strict";
    $(document).ready(function() {
        $('a[data-toggle="chat"]').each(function(i, el) {
            $(el).on('click',
            function(ev) {
                ev.preventDefault();
                public_vars.$body.toggleClass('chat-open');
                if ($.isFunction($.fn.perfectScrollbar)) {
                    setTimeout(function() {
                        public_vars.$chat.find('.chat_inner').perfectScrollbar('update');
                        $(window).trigger('xenon.resize')
                    },
                    1)
                }
            })
        });
        $('a[data-toggle="settings-pane"]').each(function(i, el) {
            $(el).on('click',
            function(ev) {
                ev.preventDefault();
                var use_animation = attrDefault($(el), 'animate', false) && !isxs();
                var scroll = {
                    top: $(document).scrollTop(),
                    toTop: 0
                };
                if (public_vars.$body.hasClass('settings-pane-open')) {
                    scroll.toTop = scroll.top
                }
                TweenMax.to(scroll, (use_animation ? .1 : 0), {
                    top: scroll.toTop,
                    roundProps: ['top'],
                    ease: scroll.toTop < 10 ? null: Sine.easeOut,
                    onUpdate: function() {
                        $(window).scrollTop(scroll.top)
                    },
                    onComplete: function() {
                        if (use_animation) {
                            public_vars.$settingsPaneIn.addClass('with-animation');
                            if (!public_vars.$settingsPane.is(':visible')) {
                                public_vars.$body.addClass('settings-pane-open');
                                var height = public_vars.$settingsPane.outerHeight(true);
                                public_vars.$settingsPane.css({
                                    height: 0
                                });
                                TweenMax.to(public_vars.$settingsPane, .25, {
                                    css: {
                                        height: height
                                    },
                                    ease: Circ.easeInOut,
                                    onComplete: function() {
                                        public_vars.$settingsPane.css({
                                            height: ''
                                        })
                                    }
                                });
                                public_vars.$settingsPaneIn.addClass('visible')
                            } else {
                                public_vars.$settingsPaneIn.addClass('closing');
                                TweenMax.to(public_vars.$settingsPane, .25, {
                                    css: {
                                        height: 0
                                    },
                                    delay: .15,
                                    ease: Power1.easeInOut,
                                    onComplete: function() {
                                        public_vars.$body.removeClass('settings-pane-open');
                                        public_vars.$settingsPane.css({
                                            height: ''
                                        });
                                        public_vars.$settingsPaneIn.removeClass('closing visible')
                                    }
                                })
                            }
                        } else {
                            public_vars.$body.toggleClass('settings-pane-open');
                            public_vars.$settingsPaneIn.removeClass('visible');
                            public_vars.$settingsPaneIn.removeClass('with-animation')
                        }
                    }
                })
            })
        });
        $('a[data-toggle="sidebar"]').each(function(i, el) {
            $(el).on('click',
            function(ev) {
                ev.preventDefault();
                if (public_vars.$sidebarMenu.hasClass('collapsed')) {
                    public_vars.$sidebarMenu.removeClass('collapsed');
                    ps_init()
                } else {
                    public_vars.$sidebarMenu.addClass('collapsed');
                    ps_destroy()
                }
                $(window).trigger('xenon.resize')
            })
        });

		// Mobile Menu Trigger
		$('a[data-toggle="mobile-menu"]').on('click', function(ev)
		{
			ev.preventDefault();
			public_vars.$mainMenu.add(public_vars.$sidebarProfile).toggleClass('mobile-is-visible');
			ps_destroy();
		});
		// Mobile Menu Trigger for Horizontal Menu
		$('a[data-toggle="mobile-menu-horizontal"]').on('click', function(ev)
		{
			ev.preventDefault();
			public_vars.$horizontalMenu.toggleClass('mobile-is-visible');
		});
		// Mobile Menu Trigger for Sidebar & Horizontal Menu
		$('a[data-toggle="mobile-menu-both"]').on('click', function(ev)
		{
			ev.preventDefault();
			public_vars.$mainMenu.toggleClass('mobile-is-visible both-menus-visible');
			public_vars.$horizontalMenu.toggleClass('mobile-is-visible both-menus-visible');
		});
		// Mobile User Info Menu Trigger
		$('a[data-toggle="user-info-menu"]').on('click', function(ev)
		{
			ev.preventDefault();
			public_vars.$userInfoMenu.toggleClass('mobile-is-visible');
		});
		// Mobile User Info Menu Trigger for Horizontal Menu
		$('a[data-toggle="user-info-menu-horizontal"]').on('click', function(ev)
		{
			ev.preventDefault();
			public_vars.$userInfoMenuHor.find('.nav.nav-userinfo').toggleClass('mobile-is-visible');
        });
        
        $('body').on('click', '.panel a[data-toggle="remove"]',
        function(ev) {
            ev.preventDefault();
            var $panel = $(this).closest('.panel'),
            $panel_parent = $panel.parent();
            $panel.remove();
            if ($panel_parent.children().length == 0) {
                $panel_parent.remove()
            }
        });
        $('body').on('click', '.panel a[data-toggle="reload"]',
        function(ev) {
            ev.preventDefault();
            var $panel = $(this).closest('.panel');
            $panel.append('<div class="panel-disabled"><div class="loader-1"></div></div>');
            var $pd = $panel.find('.panel-disabled');
            setTimeout(function() {
                $pd.fadeOut('fast',
                function() {
                    $pd.remove()
                })
            },
            500 + 300 * (Math.random() * 5))
        });
        $('body').on('click', '.panel a[data-toggle="panel"]',
        function(ev) {
            ev.preventDefault();
            var $panel = $(this).closest('.panel');
            $panel.toggleClass('collapsed')
        });
        $('[data-loading-text]').each(function(i, el) {
            var $this = $(el);
            $this.on('click',
            function(ev) {
                $this.button('loading');
                setTimeout(function() {
                    $this.button('reset')
                },
                1800)
            })
        });
        $('[data-toggle="popover"]').each(function(i, el) {
            var $this = $(el),
            placement = attrDefault($this, 'placement', 'right'),
            trigger = attrDefault($this, 'trigger', 'click'),
            popover_class = $this.get(0).className.match(/(popover-[a-z0-9]+)/i);
            $this.popover({
                placement: placement,
                trigger: trigger
            });
            if (popover_class) {
                $this.removeClass(popover_class[1]);
                $this.on('show.bs.popover',
                function(ev) {
                    setTimeout(function() {
                        var $popover = $this.next();
                        $popover.addClass(popover_class[1])
                    },
                    0)
                })
            }
        });
        $('[data-toggle="tooltip"]').each(function(i, el) {
            var $this = $(el),
            placement = attrDefault($this, 'placement', 'top'),
            trigger = attrDefault($this, 'trigger', 'hover'),
            tooltip_class = $this.get(0).className.match(/(tooltip-[a-z0-9]+)/i);
            $this.tooltip({
                placement: placement,
                trigger: trigger
            });
            if (tooltip_class) {
                $this.removeClass(tooltip_class[1]);
                $this.on('show.bs.tooltip',
                function(ev) {
                    setTimeout(function() {
                        var $tooltip = $this.next();
                        $tooltip.addClass(tooltip_class[1])
                    },
                    0)
                })
            }
        })
    })
})(jQuery, window);

var public_vars = public_vars || {};
jQuery.extend(public_vars, {
    breakpoints: {
        largescreen: [991, -1],
        tabletscreen: [768, 990],
        devicescreen: [420, 767],
        sdevicescreen: [0, 419]
    },
    lastBreakpoint: null
});
function resizable(breakpoint) {
    var sb_with_animation;
    if (is('largescreen')) {}
    if (ismdxl()) {}
    if (is('tabletscreen')) {}
    if (is('tabletscreen')) {
        public_vars.$sidebarMenu.addClass('collapsed');
        ps_destroy()
    }
    if (isxs()) {}
    jQuery(window).trigger('xenon.resize')
}
function get_current_breakpoint() {
    var width = jQuery(window).width(),
    breakpoints = public_vars.breakpoints;
    for (var breakpont_label in breakpoints) {
        var bp_arr = breakpoints[breakpont_label],
        min = bp_arr[0],
        max = bp_arr[1];
        if (max == -1) max = width;
        if (min <= width && max >= width) {
            return breakpont_label
        }
    }
    return null
}
function is(screen_label) {
    return get_current_breakpoint() == screen_label
}
function isxs() {
    return is('devicescreen') || is('sdevicescreen')
}
function ismdxl() {
    return is('tabletscreen') || is('largescreen')
}
function trigger_resizable() {
    if (public_vars.lastBreakpoint != get_current_breakpoint()) {
        public_vars.lastBreakpoint = get_current_breakpoint();
        resizable(public_vars.lastBreakpoint)
    }
    jQuery(window).trigger('xenon.resized')
}

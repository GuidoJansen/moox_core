/*! AdminLTE app.js
 * ================
 * Main JS application file for AdminLTE v2. This file
 * should be included in all pages. It controls some layout
 * options and implements exclusive AdminLTE plugins.
 *
 * @Author  Almsaeed Studio
 * @Support <http://www.almsaeedstudio.com>
 * @Email   <support@almsaeedstudio.com>
 * @version 2.3.0
 * @license MIT <http://opensource.org/licenses/MIT>
 */

//Make sure jQuery has been loaded before app.js
if (typeof TYPO3.jQuery === "undefined") {
    throw new Error("AdminLTE requires jQuery");
}

/* AdminLTE
 *
 * @type Object
 * @description TYPO3.jQuery.AdminLTE is the main object for the template's app.
 *              It's used for implementing functions and options related
 *              to the template. Keeping everything wrapped in an object
 *              prevents conflict with other plugins and is a better
 *              way to organize our code.
 */
TYPO3.jQuery.AdminLTE = {};

/* --------------------
 * - AdminLTE Options -
 * --------------------
 * Modify these options to suit your implementation
 */
TYPO3.jQuery.AdminLTE.options = {
    //Add slimscroll to navbar menus
    //This requires you to load the slimscroll plugin
    //in every page before app.js
    navbarMenuSlimscroll: true,
    navbarMenuSlimscrollWidth: "3px", //The width of the scroll bar
    navbarMenuHeight: "200px", //The height of the inner menu
    //General animation speed for JS animated elements such as box collapse/expand and
    //sidebar treeview slide up/down. This options accepts an integer as milliseconds,
    //'fast', 'normal', or 'slow'
    animationSpeed: 500,
    //Sidebar push menu toggle button selector
    sidebarToggleSelector: "[data-toggle='offcanvas']",
    //Activate sidebar push menu
    sidebarPushMenu: true,
    //Activate sidebar slimscroll if the fixed layout is set (requires SlimScroll Plugin)
    sidebarSlimScroll: true,
    //Enable sidebar expand on hover effect for sidebar mini
    //This option is forced to true if both the fixed layout and sidebar mini
    //are used together
    sidebarExpandOnHover: false,
    //BoxRefresh Plugin
    enableBoxRefresh: true,
    //Bootstrap.js tooltip
    enableBSToppltip: true,
    BSTooltipSelector: "[data-toggle='tooltip']",
    //Enable Fast Click. Fastclick.js creates a more
    //native touch experience with touch devices. If you
    //choose to enable the plugin, make sure you load the script
    //before AdminLTE's app.js
    enableFastclick: true,
    //Control Sidebar Options
    enableControlSidebar: true,
    controlSidebarOptions: {
        //Which button should trigger the open/close event
        toggleBtnSelector: "[data-toggle='control-sidebar']",
        //The sidebar selector
        selector: ".control-sidebar",
        //Enable slide over content
        slide: true
    },
    //Box Widget Plugin. Enable this plugin
    //to allow boxes to be collapsed and/or removed
    enableBoxWidget: true,
    //Box Widget plugin options
    boxWidgetOptions: {
        boxWidgetIcons: {
            //Collapse icon
            collapse: 'fa-minus',
            //Open icon
            open: 'fa-plus',
            //Remove icon
            remove: 'fa-times'
        },
        boxWidgetSelectors: {
            //Remove button selector
            remove: '[data-widget="remove"]',
            //Collapse button selector
            collapse: '[data-widget="collapse"]'
        }
    },
    //Direct Chat plugin options
    directChat: {
        //Enable direct chat by default
        enable: true,
        //The button to open and close the chat contacts pane
        contactToggleSelector: '[data-widget="chat-pane-toggle"]'
    },
    //Define the set of colors to use globally around the website
    colors: {
        lightBlue: "#3c8dbc",
        red: "#f56954",
        green: "#00a65a",
        aqua: "#00c0ef",
        yellow: "#f39c12",
        blue: "#0073b7",
        navy: "#001F3F",
        teal: "#39CCCC",
        olive: "#3D9970",
        lime: "#01FF70",
        orange: "#FF851B",
        fuchsia: "#F012BE",
        purple: "#8E24AA",
        maroon: "#D81B60",
        black: "#222222",
        gray: "#d2d6de"
    },
    //The standard screen sizes that bootstrap uses.
    //If you change these in the variables.less file, change
    //them here too.
    screenSizes: {
        xs: 480,
        sm: 768,
        md: 992,
        lg: 1200
    }
};

/* ------------------
 * - Implementation -
 * ------------------
 * The next block of code implements AdminLTE's
 * functions and plugins as specified by the
 * options above.
 */
TYPO3.jQuery(function () {
    "use strict";

    //Fix for IE page transitions
    TYPO3.jQuery("body").removeClass("hold-transition");

    //Extend options if external options exist
    if (typeof AdminLTEOptions !== "undefined") {
        TYPO3.jQuery.extend(true,
            TYPO3.jQuery.AdminLTE.options,
            AdminLTEOptions);
    }

    //Easy access to options
    var o = TYPO3.jQuery.AdminLTE.options;

    //Set up the object
    _init();

    //Activate the layout maker
    TYPO3.jQuery.AdminLTE.layout.activate();

    //Enable sidebar tree view controls
    TYPO3.jQuery.AdminLTE.tree('.sidebar');

    //Enable control sidebar
    if (o.enableControlSidebar) {
        TYPO3.jQuery.AdminLTE.controlSidebar.activate();
    }

    //Add slimscroll to navbar dropdown
    if (o.navbarMenuSlimscroll && typeof TYPO3.jQuery.fn.slimscroll != 'undefined') {
        TYPO3.jQuery(".navbar .menu").slimscroll({
            height: o.navbarMenuHeight,
            alwaysVisible: false,
            size: o.navbarMenuSlimscrollWidth
        }).css("width", "100%");
    }

    //Activate sidebar push menu
    if (o.sidebarPushMenu) {
        TYPO3.jQuery.AdminLTE.pushMenu.activate(o.sidebarToggleSelector);
    }

    //Activate Bootstrap tooltip
    //if (o.enableBSToppltip) {
    //    TYPO3.jQuery('body').tooltip({
    //        selector: o.BSTooltipSelector
    //    });
    //}

    //Activate box widget
    if (o.enableBoxWidget) {
        TYPO3.jQuery.AdminLTE.boxWidget.activate();
    }

    //Activate fast click
    if (o.enableFastclick && typeof FastClick != 'undefined') {
        FastClick.attach(document.body);
    }

    //Activate direct chat widget
    if (o.directChat.enable) {
        TYPO3.jQuery(document).on('click', o.directChat.contactToggleSelector, function () {
            var box = TYPO3.jQuery(this).parents('.direct-chat').first();
            box.toggleClass('direct-chat-contacts-open');
        });
    }

    /*
     * INITIALIZE BUTTON TOGGLE
     * ------------------------
     */
    TYPO3.jQuery('.btn-group[data-toggle="btn-toggle"]').each(function () {
        var group = TYPO3.jQuery(this);
        TYPO3.jQuery(this).find(".btn").on('click', function (e) {
            group.find(".btn.active").removeClass("active");
            TYPO3.jQuery(this).addClass("active");
            e.preventDefault();
        });

    });
});

/* ----------------------------------
 * - Initialize the AdminLTE Object -
 * ----------------------------------
 * All AdminLTE functions are implemented below.
 */
function _init() {
    'use strict';
    /* Layout
     * ======
     * Fixes the layout height in case min-height fails.
     *
     * @type Object
     * @usage TYPO3.jQuery.AdminLTE.layout.activate()
     *        TYPO3.jQuery.AdminLTE.layout.fix()
     *        TYPO3.jQuery.AdminLTE.layout.fixSidebar()
     */
    TYPO3.jQuery.AdminLTE.layout = {
        activate: function () {
            var _this = this;
            _this.fix();
            _this.fixSidebar();
            TYPO3.jQuery(window, ".wrapper").resize(function () {
                _this.fix();
                _this.fixSidebar();
            });
        },
        fix: function () {
            //Get window height and the wrapper height
            var neg = TYPO3.jQuery('.main-header').outerHeight() + TYPO3.jQuery('.main-footer').outerHeight();
            var window_height = TYPO3.jQuery(window).height();
            var sidebar_height = TYPO3.jQuery(".sidebar").height();
            //Set the min-height of the content and sidebar based on the
            //the height of the document.
            if (TYPO3.jQuery("body").hasClass("fixed")) {
                TYPO3.jQuery(".content-wrapper, .right-side").css('min-height', window_height - TYPO3.jQuery('.main-footer').outerHeight());
            } else {
                var postSetWidth;
                if (window_height >= sidebar_height) {
                    TYPO3.jQuery(".content-wrapper, .right-side").css('min-height', window_height - neg);
                    postSetWidth = window_height - neg;
                } else {
                    TYPO3.jQuery(".content-wrapper, .right-side").css('min-height', sidebar_height);
                    postSetWidth = sidebar_height;
                }

                //Fix for the control sidebar height
                var controlSidebar = TYPO3.jQuery(TYPO3.jQuery.AdminLTE.options.controlSidebarOptions.selector);
                if (typeof controlSidebar !== "undefined") {
                    if (controlSidebar.height() > postSetWidth)
                        TYPO3.jQuery(".content-wrapper, .right-side").css('min-height', controlSidebar.height());
                }

            }
        },
        fixSidebar: function () {
            //Make sure the body tag has the .fixed class
            if (!TYPO3.jQuery("body").hasClass("fixed")) {
                if (typeof TYPO3.jQuery.fn.slimScroll != 'undefined') {
                    TYPO3.jQuery(".sidebar").slimScroll({destroy: true}).height("auto");
                }
                return;
            } else if (typeof TYPO3.jQuery.fn.slimScroll == 'undefined' && window.console) {
                window.console.error("Error: the fixed layout requires the slimscroll plugin!");
            }
            //Enable slimscroll for fixed layout
            if (TYPO3.jQuery.AdminLTE.options.sidebarSlimScroll) {
                if (typeof TYPO3.jQuery.fn.slimScroll != 'undefined') {
                    //Destroy if it exists
                    TYPO3.jQuery(".sidebar").slimScroll({destroy: true}).height("auto");
                    //Add slimscroll
                    TYPO3.jQuery(".sidebar").slimscroll({
                        height: (TYPO3.jQuery(window).height() - TYPO3.jQuery(".main-header").height()) + "px",
                        color: "rgba(0,0,0,0.2)",
                        size: "3px"
                    });
                }
            }
        }
    };

    /* PushMenu()
     * ==========
     * Adds the push menu functionality to the sidebar.
     *
     * @type Function
     * @usage: TYPO3.jQuery.AdminLTE.pushMenu("[data-toggle='offcanvas']")
     */
    TYPO3.jQuery.AdminLTE.pushMenu = {
        activate: function (toggleBtn) {
            //Get the screen sizes
            var screenSizes = TYPO3.jQuery.AdminLTE.options.screenSizes;

            //Enable sidebar toggle
            TYPO3.jQuery(toggleBtn).on('click', function (e) {
                e.preventDefault();

                //Enable sidebar push menu
                if (TYPO3.jQuery(window).width() > (screenSizes.sm - 1)) {
                    if (TYPO3.jQuery("body").hasClass('sidebar-collapse')) {
                        TYPO3.jQuery("body").removeClass('sidebar-collapse').trigger('expanded.pushMenu');
                    } else {
                        TYPO3.jQuery("body").addClass('sidebar-collapse').trigger('collapsed.pushMenu');
                    }
                }
                //Handle sidebar push menu for small screens
                else {
                    if (TYPO3.jQuery("body").hasClass('sidebar-open')) {
                        TYPO3.jQuery("body").removeClass('sidebar-open').removeClass('sidebar-collapse').trigger('collapsed.pushMenu');
                    } else {
                        TYPO3.jQuery("body").addClass('sidebar-open').trigger('expanded.pushMenu');
                    }
                }
            });

            TYPO3.jQuery(".content-wrapper").click(function () {
                //Enable hide menu when clicking on the content-wrapper on small screens
                if (TYPO3.jQuery(window).width() <= (screenSizes.sm - 1) && TYPO3.jQuery("body").hasClass("sidebar-open")) {
                    TYPO3.jQuery("body").removeClass('sidebar-open');
                }
            });

            //Enable expand on hover for sidebar mini
            if (TYPO3.jQuery.AdminLTE.options.sidebarExpandOnHover
                || (TYPO3.jQuery('body').hasClass('fixed')
                && TYPO3.jQuery('body').hasClass('sidebar-mini'))) {
                this.expandOnHover();
            }
        },
        expandOnHover: function () {
            var _this = this;
            var screenWidth = TYPO3.jQuery.AdminLTE.options.screenSizes.sm - 1;
            //Expand sidebar on hover
            TYPO3.jQuery('.main-sidebar').hover(function () {
                if (TYPO3.jQuery('body').hasClass('sidebar-mini')
                    && TYPO3.jQuery("body").hasClass('sidebar-collapse')
                    && TYPO3.jQuery(window).width() > screenWidth) {
                    _this.expand();
                }
            }, function () {
                if (TYPO3.jQuery('body').hasClass('sidebar-mini')
                    && TYPO3.jQuery('body').hasClass('sidebar-expanded-on-hover')
                    && TYPO3.jQuery(window).width() > screenWidth) {
                    _this.collapse();
                }
            });
        },
        expand: function () {
            TYPO3.jQuery("body").removeClass('sidebar-collapse').addClass('sidebar-expanded-on-hover');
        },
        collapse: function () {
            if (TYPO3.jQuery('body').hasClass('sidebar-expanded-on-hover')) {
                TYPO3.jQuery('body').removeClass('sidebar-expanded-on-hover').addClass('sidebar-collapse');
            }
        }
    };

    /* Tree()
     * ======
     * Converts the sidebar into a multilevel
     * tree view menu.
     *
     * @type Function
     * @Usage: TYPO3.jQuery.AdminLTE.tree('.sidebar')
     */
    TYPO3.jQuery.AdminLTE.tree = function (menu) {
        var _this = this;
        var animationSpeed = TYPO3.jQuery.AdminLTE.options.animationSpeed;
        TYPO3.jQuery(document).on('click', menu + ' li a', function (e) {
            //Get the clicked link and the next element
            var $this = TYPO3.jQuery(this);
            var checkElement = $this.next();

            //Check if the next element is a menu and is visible
            if ((checkElement.is('.treeview-menu')) && (checkElement.is(':visible'))) {
                //Close the menu
                checkElement.slideUp(animationSpeed, function () {
                    checkElement.removeClass('menu-open');
                    //Fix the layout in case the sidebar stretches over the height of the window
                    //_this.layout.fix();
                });
                checkElement.parent("li").removeClass("active");
            }
            //If the menu is not visible
            else if ((checkElement.is('.treeview-menu')) && (!checkElement.is(':visible'))) {
                //Get the parent menu
                var parent = $this.parents('ul').first();
                //Close all open menus within the parent
                var ul = parent.find('ul:visible').slideUp(animationSpeed);
                //Remove the menu-open class from the parent
                ul.removeClass('menu-open');
                //Get the parent li
                var parent_li = $this.parent("li");

                //Open the target menu and add the menu-open class
                checkElement.slideDown(animationSpeed, function () {
                    //Add the class active to the parent li
                    checkElement.addClass('menu-open');
                    parent.find('li.active').removeClass('active');
                    parent_li.addClass('active');
                    //Fix the layout in case the sidebar stretches over the height of the window
                    _this.layout.fix();
                });
            }
            //if this isn't a link, prevent the page from being redirected
            if (checkElement.is('.treeview-menu')) {
                e.preventDefault();
            }
        });
    };

    /* ControlSidebar
     * ==============
     * Adds functionality to the right sidebar
     *
     * @type Object
     * @usage TYPO3.jQuery.AdminLTE.controlSidebar.activate(options)
     */
    TYPO3.jQuery.AdminLTE.controlSidebar = {
        //instantiate the object
        activate: function () {
            //Get the object
            var _this = this;
            //Update options
            var o = TYPO3.jQuery.AdminLTE.options.controlSidebarOptions;
            //Get the sidebar
            var sidebar = TYPO3.jQuery(o.selector);
            //The toggle button
            var btn = TYPO3.jQuery(o.toggleBtnSelector);

            //Listen to the click event
            btn.on('click', function (e) {
                e.preventDefault();
                //If the sidebar is not open
                if (!sidebar.hasClass('control-sidebar-open')
                    && !TYPO3.jQuery('body').hasClass('control-sidebar-open')) {
                    //Open the sidebar
                    _this.open(sidebar, o.slide);
                } else {
                    _this.close(sidebar, o.slide);
                }
            });

            //If the body has a boxed layout, fix the sidebar bg position
            var bg = TYPO3.jQuery(".control-sidebar-bg");
            _this._fix(bg);

            //If the body has a fixed layout, make the control sidebar fixed
            if (TYPO3.jQuery('body').hasClass('fixed')) {
                _this._fixForFixed(sidebar);
            } else {
                //If the content height is less than the sidebar's height, force max height
                if (TYPO3.jQuery('.content-wrapper, .right-side').height() < sidebar.height()) {
                    _this._fixForContent(sidebar);
                }
            }
        },
        //Open the control sidebar
        open: function (sidebar, slide) {
            //Slide over content
            if (slide) {
                sidebar.addClass('control-sidebar-open');
            } else {
                //Push the content by adding the open class to the body instead
                //of the sidebar itself
                TYPO3.jQuery('body').addClass('control-sidebar-open');
            }
        },
        //Close the control sidebar
        close: function (sidebar, slide) {
            if (slide) {
                sidebar.removeClass('control-sidebar-open');
            } else {
                TYPO3.jQuery('body').removeClass('control-sidebar-open');
            }
        },
        _fix: function (sidebar) {
            var _this = this;
            if (TYPO3.jQuery("body").hasClass('layout-boxed')) {
                sidebar.css('position', 'absolute');
                sidebar.height(TYPO3.jQuery(".wrapper").height());
                TYPO3.jQuery(window).resize(function () {
                    _this._fix(sidebar);
                });
            } else {
                sidebar.css({
                    'position': 'fixed',
                    'height': 'auto'
                });
            }
        },
        _fixForFixed: function (sidebar) {
            sidebar.css({
                'position': 'fixed',
                'max-height': '100%',
                'overflow': 'auto',
                'padding-bottom': '50px'
            });
        },
        _fixForContent: function (sidebar) {
            TYPO3.jQuery(".content-wrapper, .right-side").css('min-height', sidebar.height());
        }
    };

    /* BoxWidget
     * =========
     * BoxWidget is a plugin to handle collapsing and
     * removing boxes from the screen.
     *
     * @type Object
     * @usage TYPO3.jQuery.AdminLTE.boxWidget.activate()
     *        Set all your options in the main TYPO3.jQuery.AdminLTE.options object
     */
    TYPO3.jQuery.AdminLTE.boxWidget = {
        selectors: TYPO3.jQuery.AdminLTE.options.boxWidgetOptions.boxWidgetSelectors,
        icons: TYPO3.jQuery.AdminLTE.options.boxWidgetOptions.boxWidgetIcons,
        animationSpeed: TYPO3.jQuery.AdminLTE.options.animationSpeed,
        activate: function (_box) {
            var _this = this;
            if (!_box) {
                _box = document; // activate all boxes per default
            }
            //Listen for collapse event triggers
            TYPO3.jQuery(_box).on('click', _this.selectors.collapse, function (e) {
                e.preventDefault();
                _this.collapse(TYPO3.jQuery(this));
            });

            //Listen for remove event triggers
            TYPO3.jQuery(_box).on('click', _this.selectors.remove, function (e) {
                e.preventDefault();
                _this.remove(TYPO3.jQuery(this));
            });
        },
        collapse: function (element) {
            var _this = this;
            //Find the box parent
            var box = element.parents(".box").first();
            //Find the body and the footer
            var box_content = box.find("> .box-body, > .box-footer, > form  >.box-body, > form > .box-footer");
            if (!box.hasClass("collapsed-box")) {
                //Convert minus into plus
                element.children(":first")
                    .removeClass(_this.icons.collapse)
                    .addClass(_this.icons.open);
                //Hide the content
                box_content.slideUp(_this.animationSpeed, function () {
                    box.addClass("collapsed-box");
                });
            } else {
                //Convert plus into minus
                element.children(":first")
                    .removeClass(_this.icons.open)
                    .addClass(_this.icons.collapse);
                //Show the content
                box_content.slideDown(_this.animationSpeed, function () {
                    box.removeClass("collapsed-box");
                });
            }
        },
        remove: function (element) {
            //Find the box parent
            var box = element.parents(".box").first();
            box.slideUp(this.animationSpeed);
        }
    };
}

/* ------------------
 * - Custom Plugins -
 * ------------------
 * All custom plugins are defined below.
 */

/*
 * BOX REFRESH BUTTON
 * ------------------
 * This is a custom plugin to use with the component BOX. It allows you to add
 * a refresh button to the box. It converts the box's state to a loading state.
 *
 * @type plugin
 * @usage TYPO3.jQuery("#box-widget").boxRefresh( options );
 */
(function ($) {

    "use strict";

    TYPO3.jQuery.fn.boxRefresh = function (options) {

        // Render options
        var settings = TYPO3.jQuery.extend({
            //Refresh button selector
            trigger: ".refresh-btn",
            //File source to be loaded (e.g: ajax/src.php)
            source: "",
            //Callbacks
            onLoadStart: function (box) {
                return box;
            }, //Right after the button has been clicked
            onLoadDone: function (box) {
                return box;
            } //When the source has been loaded

        }, options);

        //The overlay
        var overlay = TYPO3.jQuery('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');

        return this.each(function () {
            //if a source is specified
            if (settings.source === "") {
                if (window.console) {
                    window.console.log("Please specify a source first - boxRefresh()");
                }
                return;
            }
            //the box
            var box = TYPO3.jQuery(this);
            //the button
            var rBtn = box.find(settings.trigger).first();

            //On trigger click
            rBtn.on('click', function (e) {
                e.preventDefault();
                //Add loading overlay
                start(box);

                //Perform ajax call
                box.find(".box-body").load(settings.source, function () {
                    done(box);
                });
            });
        });

        function start(box) {
            //Add overlay and loading img
            box.append(overlay);

            settings.onLoadStart.call(box);
        }

        function done(box) {
            //Remove overlay and loading img
            box.find(overlay).remove();

            settings.onLoadDone.call(box);
        }

    };

})(TYPO3.jQuery);

/*
 * EXPLICIT BOX ACTIVATION
 * -----------------------
 * This is a custom plugin to use with the component BOX. It allows you to activate
 * a box inserted in the DOM after the app.js was loaded.
 *
 * @type plugin
 * @usage TYPO3.jQuery("#box-widget").activateBox();
 */
(function ($) {

    'use strict';

    TYPO3.jQuery.fn.activateBox = function () {
        TYPO3.jQuery.AdminLTE.boxWidget.activate(this);
    };

})(TYPO3.jQuery);

/*
 * TODO LIST CUSTOM PLUGIN
 * -----------------------
 * This plugin depends on iCheck plugin for checkbox and radio inputs
 *
 * @type plugin
 * @usage TYPO3.jQuery("#todo-widget").todolist( options );
 */
(function ($) {

    'use strict';

    TYPO3.jQuery.fn.todolist = function (options) {
        // Render options
        var settings = TYPO3.jQuery.extend({
            //When the user checks the input
            onCheck: function (ele) {
                return ele;
            },
            //When the user unchecks the input
            onUncheck: function (ele) {
                return ele;
            }
        }, options);

        return this.each(function () {

            if (typeof TYPO3.jQuery.fn.iCheck != 'undefined') {
                TYPO3.jQuery('input', this).on('ifChecked', function () {
                    var ele = TYPO3.jQuery(this).parents("li").first();
                    ele.toggleClass("done");
                    settings.onCheck.call(ele);
                });

                TYPO3.jQuery('input', this).on('ifUnchecked', function () {
                    var ele = TYPO3.jQuery(this).parents("li").first();
                    ele.toggleClass("done");
                    settings.onUncheck.call(ele);
                });
            } else {
                TYPO3.jQuery('input', this).on('change', function () {
                    var ele = TYPO3.jQuery(this).parents("li").first();
                    ele.toggleClass("done");
                    if (TYPO3.jQuery('input', ele).is(":checked")) {
                        settings.onCheck.call(ele);
                    } else {
                        settings.onUncheck.call(ele);
                    }
                });
            }
        });
    };
}(TYPO3.jQuery));


TYPO3.jQuery(document).ready(function() {
    TYPO3.jQuery('body').addClass('hold-transition skin-green-light sidebar-mini');
});
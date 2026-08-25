/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.box-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
  $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

  // jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder         : 'sort-highlight',
    handle              : '.handle',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });

  // bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5();

  var start = moment().subtract(29, 'days');
  var end = moment();

  function cb(start, end) {
      $('.daterange').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      $('#min_date').val(start.format('YYYY-MM-DD'));
      $('#max_date').val(end.format('YYYY-MM-DD'));
  }
  $('.daterange').daterangepicker({
    ranges   : {
      'Today'       : [moment(), moment()],
      'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: start,
    endDate: end,
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
  }, cb);

  $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $('#min_date').val('');
      $('#max_date').val('');
  });

  cb(start, end);

  /* jQueryKnob */
  $('.knob').knob();

  // jvectormap data
  var visitorsData = {
    US: 398, // USA
    SA: 400, // Saudi Arabia
    CA: 1000, // Canada
    DE: 500, // Germany
    FR: 760, // France
    CN: 300, // China
    AU: 700, // Australia
    BR: 600, // Brazil
    IN: 800, // India
    GB: 320, // Great Britain
    RU: 3000 // Russia
  };
  if($('#world-map').length){
    // World map by jvectormap
    $('#world-map').vectorMap({
      map              : 'world_mill_en',
      backgroundColor  : 'transparent',
      regionStyle      : {
        initial: {
          fill            : '#e4e4e4',
          'fill-opacity'  : 1,
          stroke          : 'none',
          'stroke-width'  : 0,
          'stroke-opacity': 1
        }
      },
      series           : {
        regions: [
          {
            values           : visitorsData,
            scale            : ['#92c1dc', '#ebf4f9'],
            normalizeFunction: 'polynomial'
          }
        ]
      },
      onRegionLabelShow: function (e, el, code) {
        if (typeof visitorsData[code] != 'undefined')
          el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
      }
    });
  }
  

  // Sparkline charts
  var myvalues = [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021];
  $('#sparkline-1').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#92c1dc',
    fillColor: '#ebf4f9',
    height   : '50',
    width    : '80'
  });
  myvalues = [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921];
  $('#sparkline-2').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#92c1dc',
    fillColor: '#ebf4f9',
    height   : '50',
    width    : '80'
  });
  myvalues = [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21];
  $('#sparkline-3').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#92c1dc',
    fillColor: '#ebf4f9',
    height   : '50',
    width    : '80'
  });

  // The Calender
  $('#calendar').datepicker();

  // SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').slimScroll({
    height: '250px'
  });

  /* Morris.js Charts */
  // Sales chart
  // var area = new Morris.Area({
  //   element   : 'revenue-chart',
  //   resize    : true,
  //   data      : [
  //     { y: '2011 Q1', item1: 2666, item2: 2666 },
  //     { y: '2011 Q2', item1: 2778, item2: 2294 },
  //     { y: '2011 Q3', item1: 4912, item2: 1969 },
  //     { y: '2011 Q4', item1: 3767, item2: 3597 },
  //     { y: '2012 Q1', item1: 6810, item2: 1914 },
  //     { y: '2012 Q2', item1: 5670, item2: 4293 },
  //     { y: '2012 Q3', item1: 4820, item2: 3795 },
  //     { y: '2012 Q4', item1: 15073, item2: 5967 },
  //     { y: '2013 Q1', item1: 10687, item2: 4460 },
  //     { y: '2013 Q2', item1: 8432, item2: 5713 }
  //   ],
  //   xkey      : 'y',
  //   ykeys     : ['item1', 'item2'],
  //   labels    : ['Item 1', 'Item 2'],
  //   lineColors: ['#a0d0e0', '#3c8dbc'],
  //   hideHover : 'auto'
  // });
  // var line = new Morris.Line({
  //   element          : 'line-chart',
  //   resize           : true,
  //   data             : [
  //     { y: '2011 Q1', item1: 2666 },
  //     { y: '2011 Q2', item1: 2778 },
  //     { y: '2011 Q3', item1: 4912 },
  //     { y: '2011 Q4', item1: 3767 },
  //     { y: '2012 Q1', item1: 6810 },
  //     { y: '2012 Q2', item1: 5670 },
  //     { y: '2012 Q3', item1: 4820 },
  //     { y: '2012 Q4', item1: 15073 },
  //     { y: '2013 Q1', item1: 10687 },
  //     { y: '2013 Q2', item1: 8432 }
  //   ],
  //   xkey             : 'y',
  //   ykeys            : ['item1'],
  //   labels           : ['Item 1'],
  //   lineColors       : ['#efefef'],
  //   lineWidth        : 2,
  //   hideHover        : 'auto',
  //   gridTextColor    : '#fff',
  //   gridStrokeWidth  : 0.4,
  //   pointSize        : 4,
  //   pointStrokeColors: ['#efefef'],
  //   gridLineColor    : '#efefef',
  //   gridTextFamily   : 'Open Sans',
  //   gridTextSize     : 10
  // });

  // // Donut Chart
  // var donut = new Morris.Donut({
  //   element  : 'sales-chart',
  //   resize   : true,
  //   colors   : ['#3c8dbc', '#f56954', '#00a65a'],
  //   data     : [
  //     { label: 'Download Sales', value: 12 },
  //     { label: 'In-Store Sales', value: 30 },
  //     { label: 'Mail-Order Sales', value: 20 }
  //   ],
  //   hideHover: 'auto'
  // });

  // Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    donut.redraw();
    line.redraw();
  });

  /* The todo list plugin */
  if ($('.todo-list').length) {
      $('.todo-list').todoList({
        onCheck  : function () {
          window.console.log($(this), 'The element has been checked');
        },
        onUnCheck: function () {
          window.console.log($(this), 'The element has been unchecked');
        }
      });
    }

});
/* Tree()
 * ======
 * Converts a nested list into a multilevel
 * tree view menu.
 *
 * @Usage: $('.my-menu').tree(options)
 *         or add [data-widget="tree"] to the ul element
 *         Pass any option as data-option="value"
 */
+function ($) {
  'use strict'

  var DataKey = 'lte.tree'

  var Default = {
    animationSpeed: 100,
    accordion     : false,
    followLink    : false,
    trigger       : '.treeview a'
  }

  var Selector = {
    tree        : '.tree',
    treeview    : '.treeview',
    treeviewMenu: '.treeview-menu',
    open        : '.menu-open, .active',
    li          : 'li',
    data        : '[data-widget="tree"]',
    active      : '.active'
  }

  var ClassName = {
    open: 'menu-open',
    tree: 'tree'
  }

  var Event = {
    collapsed: 'collapsed.tree',
    expanded : 'expanded.tree'
  }

  // Tree Class Definition
  // =====================
  var Tree = function (element, options) {
    this.element = element
    this.options = options

    $(this.element).addClass(ClassName.tree)

    $(Selector.treeview + Selector.active, this.element).addClass(ClassName.open)

    this._setUpListeners()
  }

  Tree.prototype.toggle = function (link, event) {
    var treeviewMenu = link.next(Selector.treeviewMenu)
    var parentLi     = link.parent()
    var isOpen       = parentLi.hasClass(ClassName.open)

    if (!parentLi.is(Selector.treeview)) {
      return
    }

    if (!this.options.followLink || link.attr('href') === '#') {
      event.preventDefault()
    }

    if (isOpen) {
      this.collapse(treeviewMenu, parentLi)
    } else {
      this.expand(treeviewMenu, parentLi)
    }
  }

  Tree.prototype.expand = function (tree, parent) {
    var expandedEvent = $.Event(Event.expanded)

    if (this.options.accordion) {
      var openMenuLi = parent.siblings(Selector.open)
      var openTree   = openMenuLi.children(Selector.treeviewMenu)
      this.collapse(openTree, openMenuLi)
    }

    parent.addClass(ClassName.open)
    tree.slideDown(this.options.animationSpeed, function () {
      $(this.element).trigger(expandedEvent)
    }.bind(this))
  }

  Tree.prototype.collapse = function (tree, parentLi) {
    var collapsedEvent = $.Event(Event.collapsed)

    tree.find(Selector.open).removeClass(ClassName.open)
    parentLi.removeClass(ClassName.open)
    tree.slideUp(this.options.animationSpeed, function () {
      tree.find(Selector.open + ' > ' + Selector.treeview).slideUp()
      $(this.element).trigger(collapsedEvent)
    }.bind(this))
  }

  // Private

  Tree.prototype._setUpListeners = function () {
    var that = this

    $(this.element).on('click', this.options.trigger, function (event) {
      that.toggle($(this), event)
    })
  }

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data(DataKey)
      console.log(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option)
        $this.data(DataKey, new Tree($this, options))
      }
    })
  }

  var old = $.fn.tree

  $.fn.tree             = Plugin
  $.fn.tree.Constructor = Tree

  // No Conflict Mode
  // ================
  $.fn.tree.noConflict = function () {
    $.fn.tree = old
    return this
  }

  // Tree Data API
  // =============
  $(window).on('load', function () {
    $(Selector.data).each(function () {
      Plugin.call($(this))
    })
  })

  
  var sidebar = $('#sidebar');
var tree =  $('<ul id="" class="sidebar-menu tree" data-widget="tree" id="tree"></ul>');

var title = $('<li class="header">MAIN NAVIGATION</li>');

var record = $('<span class="pull-right-container">\n' +
    '              <span class="label label-primary pull-right">4</span>\n' +
    '            </span>');

var parent =  $('<li class="active treeview menu-open">\n' +
    '          <a href="#">\n' +
    '            <i class="fa fa-dashboard"></i> <span>Dashboard</span>\n' +
    '            <span class="pull-right-container">\n' +
    '              <i class="fa fa-angle-left pull-right"></i>\n'+
    '            </span>\n' +
    '          </a>\n' +
    '        </li>');

var child =  $('<ul class="treeview-menu"></ul>');

var childItem = $('<li><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>' +
    '<li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>');


child.append(childItem);

parent.append(child);

tree.append(title);
tree.append(parent);
sidebar.append(tree);
}(jQuery)

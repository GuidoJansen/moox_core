// A $( document ).load() block.//$(window).load(function() {////});// A $( document ).ready() block.jQuery(document).ready(function() {    jQuery(".sortable").sortable({connectWith: ".sortable"}).disableSelection();});// A $( document ).resize() block.//$(window).resize(function() {////});/*var gridster;      jQuery(function(){        gridster = jQuery(".gridster ul").gridster({          widget_base_dimensions: [100, 120],          widget_margins: [5, 5],          draggable: {            handle: 'header'          }        }).data('gridster');      });  */          // https://github.com/ducksboard/gridster.js/issues/121 // GRIDSTER     //$('<div id="main" class="gridster"></div>').appendTo('body');if(jQuery.cookie("moox-dashboard-grid-data") == null) {    var json = [      {        "id": "widget1",        "col": 1,        "row": 1,        "size_y": 3,        "size_x": 3      },      {        "id": "widget2",        "col": 4,        "row": 1,        "size_y": 2,        "size_x": 2      },    ];} else {    var json = JSON.parse(jQuery.cookie("moox-dashboard-grid-data"));}var grid = jQuery(".gridster ul").gridster({    draggable: {        stop: function(event, ui){             jQuery.cookie("moox-dashboard-grid-data", JSON.stringify(grid.serialize()));        }    },    widget_margins: [8, 8],    widget_base_dimensions: [140, 140],    serialize_params: function($w, wgd) {         return {             id: wgd.el[0].id,             col: wgd.col,             row: wgd.row,            size_y: wgd.size_y,            size_x: wgd.size_x,        }     }}).data('gridster');for(i=0; i<json.length; i++) {    grid.add_widget(        '<li id="' + json[i]['id'] + '"></li>',         json[i]['size_x'],         json[i]['size_y'],         json[i]['col'],         json[i]['row']     );}jQuery.cookie("moox-dashboard-grid-data", JSON.stringify(grid.serialize()));
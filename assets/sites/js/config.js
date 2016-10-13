var baseUrl = "http://10.10.10.96/nkoppos/"
var loadCss = function(url) {
    var link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = baseUrl + url + ".css";
    document.getElementsByTagName("head")[0].appendChild(link);
  }
  // sites default Config
require.config({
  baseUrl: baseUrl,
  map: {
    '*': {
      'css': 'assets/require-css/css'
    }
  },
  shim: {
    bootstrap: {
      deps: ['jquery']
    },
    bootbox: {
      deps: ['jquery', 'bootstrap'],
    },
    bootstrapTable: {
      deps: ['jquery', 'bootstrap', "css!assets/bootstrap-tables/bootstrap-table.min.css"]
    },
    
    validator: {
      deps: ['jquery']
    },
    datepicker: {
      deps: ['jquery', 'bootstrap', 'css!assets/datepicker/css/datepicker.css']
    },
    pickadate: {
      deps: ['jquery', 'css!assets/pickadate/themes/default.css']
    },
    'pickadate-date':{
      deps: ['jquery', 'pickadate','css!assets/pickadate/themes/default.date.css']
    },
    'pickadate-time':{
      deps: ['jquery', 'pickadate','css!assets/pickadate/themes/default.time.css']
    }
    "bootstrapTableFC": {
      deps: ['jquery', 'bootstrapTable']
    },
    mask: {
      deps: ['jquery']
    }
  },
  paths: {
    "jquery": "assets/jquery/jquery.min",
    "bootstrap": "assets/bootstrap/js/bootstrap.min",
    "bootbox": "assets/bootbox/bootbox",
    "datepicker": "assets/datepicker/js/bootstrap-datepicker",
    "validator": "assets/bootstrap-validator/validator.min",
    "bootstrapTable": "assets/bootstrap-tables/bootstrap-table.min",
    "bootstrapTableFC": "assets/bootstrap-tables/extensions/filter-control/bootstrap-table-filter-control.min",
    "mask": "assets/maskedinput/maskedinput",
    pickadate: 'assets/pickadate/picker',
    'pickadate-date': 'assets/pickadate/picker.date',
    'pickadate-time': 'assets/pickadate/picker.time'
  }
});
requirejs(['jquery', 'bootstrap'], function($) {
  $(document).ready(function() {
    $('nav.sidebar [data-toggle="tooltip"]').tooltip({
      container: 'nav.sidebar'
    });
    $('[data-toggle="sidebar"]').click(function(e) {
      e.preventDefault();
      $($(this).data('target')).toggleClass('active');
    });
    $(document).mouseup(function(e) {
      var container = $("#sidebar.active .sidebar-content");
      if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
      {
        container.parent('#sidebar').removeClass('active');
      }
    })
  })
})
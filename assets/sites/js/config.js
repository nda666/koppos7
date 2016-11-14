var baseUrl = ""
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
    mcustomScrollbar: {
      deps: ['jquery', "css!assets/jquery-mcustom-scrollbar/jquery.mCustomScrollbar.min.css"]
    },
    validator: {
      deps: ['jquery']
    },
    MobileDetect: {
      deps: ['jquery']
    },
    datepicker: {
      deps: ['jquery', 'bootstrap', 'css!assets/datepicker/css/datepicker.css']
    },
    pickadate: {
      deps: ['jquery', 'css!assets/pickadate/themes/default.css']
    },
    'pickadate-date': {
      deps: ['jquery', 'pickadate', 'css!assets/pickadate/themes/default.date.css']
    },
    'pickadate-time': {
      deps: ['jquery', 'pickadate', 'css!assets/pickadate/themes/default.time.css']
    },
    "bootstrapTableFC": {
      deps: ['jquery', 'bootstrapTable']
    },
    'mask': {
      deps: ['jquery']
    },
    'select2': {
      deps: ['jquery', 'css!assets/select2/css/select2.min.css', 'css!assets/select2/css/select2-bootstrap.css']
    },
    'toastr': {
      deps: ['jquery', 'css!assets/toastr/toastr.min.css']
    }
  },
  paths: {
    "jquery": "assets/jquery/jquery.min",
    "bootstrap": "assets/bootstrap/js/bootstrap.min",
    "bootbox": "assets/bootbox/bootbox",
    "datepicker": "assets/datepicker/js/bootstrap-datepicker",
    "validator": "assets/bootstrap-validator/validator.min",
    "mcustomScrollbar": "assets/jquery-mcustom-scrollbar/jquery.mCustomScrollbar.min",
    "bootstrapTable": "assets/bootstrap-tables/bootstrap-table.min",
    "bootstrapTableFC": "assets/bootstrap-tables/extensions/filter-control/bootstrap-table-filter-control.min",
    "MobileDetect": "assets/mobile-detect/mobile-detect.min",
    "mask": "assets/maskedinput/maskedinput",
    'pickadate': 'assets/pickadate/picker',
    'pickadate-date': 'assets/pickadate/picker.date',
    'pickadate-time': 'assets/pickadate/picker.time',
    'select2': 'assets/select2/js/select2.min',
    'toastr': 'assets/toastr/toastr.min'
  }
});
requirejs(['jquery', 'MobileDetect', 'toastr','bootstrap', 'mcustomScrollbar'], function($, MobileDetect, toastr) {
  var md = new MobileDetect(window.navigator.userAgent);
  $(document).ready(function() {
    $('nav.sidebar [data-toggle="tooltip"]').tooltip({
      container: 'nav.sidebar'
    });
    if (!md.mobile()) {
      $('.sidebar-main').mCustomScrollbar({
        theme: "minimal",
        axis: 'y'
      });
    }
    $('[data-toggle="sidebar-toggle"]').click(function() {
      $($(this).attr('href')).toggleClass('collapsed');
      $('.content-main, .footer-container').toggleClass('expanded');
    })
    $('[data-toggle="dropdown-sidebar"]').click(function(e) {
      e.preventDefault();
      $(this).parent().toggleClass('open');
    })
    
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right-fix",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
      "onShown": function(e){
        console.log(toastr.options)
      }
    }
  })
})

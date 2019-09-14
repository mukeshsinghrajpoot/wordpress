/*************************************
Wordpay
Author:  Vijay Dhanvai
Version: 1.0.0
****************************************/
(function($) {
  "use strict";
  var wordPay = {
    // Main init function
    init: function() {
      this.config();
      this.events();
    },
    // Define vars for caching
    config: function() {
      this.config = {
        $window: $(window),
        $document: $(document)
      };
    },

    // Events
    events: function() {
      var self = this;

      // Run on document ready
      self.config.$document.ready(function() {
        //  01  Left Navigation Toggle
        self.leftMenuToggle();

        //  02  Login and Forgot Pass word
        self.loginForgotPassword();

        //  03  Custom Scroll Bar
        self.customScrollBar();
      });

      // Run on Window Load
      self.config.$window.on("load", function() {
        // Preloader
        // self.preLoader();
      });
    },

    /* ----------------- All Function defination are below ----------------*/

    //  01  Left Navigation Toggle
    leftMenuToggle: function() {
      /* DropDown */
      $(".menu-icon").on("click", function(e) {
        $(".left-navigation").toggleClass("collapse-left");
        $(".page-container").toggleClass("page-container-full");
        return false;
      });
    },
    //  02  Login and Forgot Pass word
    loginForgotPassword: function() {
      $(".forgot-pass-link").on("click", function(e) {
        //alert("call");
        $(".user-login").fadeOut(0);
        $(".forgot-pass").fadeIn(300);
        return false;
      });

      $(".back-to-login").on("click", function(e) {
        //alert("call");
        $(".user-login").fadeIn(300);
        $(".forgot-pass").fadeOut(0);
        return false;
      });
    },

    //  03  Custom Scroll Bar
    customScrollBar: function() {
      if ($(window).width() > 1024) {
        $(
          ".step2, .collapse-new ul , .notificatin .dropdown-menu"
        ).mCustomScrollbar({
          theme: "dark",
          mouseWheel: { preventDefault: false },
          mouseWheel: { enable: true },
          axis: "y"
        });
      }
    }
  }; // end legal-one

  // Ends things up
  wordPay.init();
})/*(jQuery)*/;


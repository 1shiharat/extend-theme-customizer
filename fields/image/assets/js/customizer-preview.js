/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
var $ = jQuery;
$(function() {
  // lightenDarkenColor
  var lightenDarkenColor = function(col, amt) {
    var usePound = false;
    if (col[0] == "#") {
      col = col.slice(1);
      usePound = true;
    }
    var num = parseInt(col, 16);
    var r = (num >> 16) + amt;
    if (r > 255) {
      r = 255;
    } else if (r < 0) {
      r = 0;
    }
    var b = ((num >> 8) & 0x00FF) + amt;
    if (b > 255) {
      b = 255;
    } else if (b < 0) {
      b = 0;
    }
    var g = (num & 0x0000FF) + amt;
    if (g > 255) {
      g = 255;
    } else if (g < 0) {
      g = 0;
    }
    return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);
  };
  // themecolor_themecolor
  wp.customize('theme_mods_growcreater[themecolor_themecolor]', function(value) {
    value.bind(function(to) {
      $('.themecolor-bg').css('background', to);
      $('.themecolor-color').css('color', to);
      $('.themecolor-border').css('border-color', to);
    });
  });
  // themecolor_primary
  wp.customize('theme_mods_growcreater[themecolor_primary]', function(value) {
    value.bind(function(to) {
      $('.primary-bg').css('background', to);
      $('.primary-color').css('background', to);
      var darkenColor = lightenDarkenColor(to, -30);
      $('.primary-border').css('border-color', to);
      $('.btn-dimensional').css('background', to);
    });
  });

  // themecolor_secondary
  // wp.customize('theme_mods_growcreater[themecolor_secondary]', function(value) {
  //   value.bind(function(to) {
  //     $('.secondary-bg').css('background', to);
  //     $('.secondary-border').attr('style', 'border-color: ' + to + ' !important ;');
  //     $('.secondary-color').attr('style', 'color: ' + to + ' !important ;');
  //     // $('.widget-title').attr('style', 'background: ' + to + ' !important ;');
  //     // $('.widget-title').attr('style', 'border-color: ' + to + ' !important ;');
  //     // $('.entry_header').attr('style', 'color: ' + to + ' !important ;');
  //     // $('.entry_header').attr('style', 'background: ' + to + ' !important ;');

  //   });
  // });
  wp.customize('theme_mods_growcreater[themecolor_linkcolor]', function(value) {
    value.bind(function(to) {
      $('a').css('color', to);
    });
  });
  wp.customize('theme_mods_growcreater[themecolor_linkcolor_hover]', function(value) {
    value.bind(function(to) {
      $('a:hover').css('color', to);
    });
  });
  // background_color
  wp.customize('theme_mods_growcreater[background_color]', function(value) {
    value.bind(function(to) {
      $('body').css('background-color', to);
    });
  });
  // background_image_upload
  wp.customize('theme_mods_growcreater[background_image_upload]', function(value) {
    value.bind(function(to) {
      $('body').css('background', 'url(' + to + ')');
    });
  });
  // font_base_size
  wp.customize('theme_mods_growcreater[font_base_size]', function(value) {
    value.bind(function(to) {
      $('body').css('font-size', to);
    });
  });
  // font_line_height
  wp.customize('theme_mods_growcreater[font_line_height]', function(value) {
    value.bind(function(to) {
      $('body').css('line-height', to);
    });
  });
  // font_letter_space
  wp.customize('theme_mods_growcreater[font_letter_space]', function(value) {
    value.bind(function(to) {
      $('body').css('letter-spacing', to);
    });
  });
  wp.customize('theme_mods_growcreater[themecolor_linkcolor]', function(value) {
    value.bind(function(to) {
      $('a').css('color', to);
    });
  });
  wp.customize('theme_mods_growcreater[themecolor_linkcolor]', function(value) {
    value.bind(function(to) {
      $('.entry_header').css('color', to);
    });
  });
  wp.customize('theme_mods_growcreater[layout_top]', function(value) {
    value.bind(function(to) {
      var $top_selecter = $('body.home');
      $top_selecter.find('.main').removeClass('pull-left');
      $top_selecter.find('.main').removeClass('pull-right');
      $top_selecter.find('.sidebar').removeClass('pull-left');
      $top_selecter.find('.sidebar').removeClass('pull-right');
      $top_selecter.find('.main').removeClass('col-lg-24');
      $top_selecter.find('.sidebar').removeClass('hidden');
      switch ( to ) {
        case 'right' :
          $top_selecter.find('.main').addClass( 'pull-left' );
          $top_selecter.find('.sidebar').addClass( 'pull-' + to );
          break;
        case 'left' :
          $top_selecter.find('.main').addClass( 'pull-right' );
          $top_selecter.find('.sidebar').addClass( 'pull-' + to );
          break;
        case 'one_column' :
          $top_selecter.find('.main').addClass( 'col-lg-24' );
          $top_selecter.find('.sidebar').addClass( 'hidden' );
          break;
      }
    });
  });
  wp.customize('theme_mods_growcreater[layout_layer]', function(value) {
    value.bind(function(to) {
      var $layer_selecter = $('body.single,body.page,.body.archive');
      $layer_selecter.find('.main').removeClass('pull-left');
      $layer_selecter.find('.main').removeClass('pull-right');
      $layer_selecter.find('.sidebar').removeClass('pull-left');
      $layer_selecter.find('.sidebar').removeClass('pull-right');
      $layer_selecter.find('.main').removeClass('col-lg-24');
      $layer_selecter.find('.sidebar').removeClass('hidden');
      switch ( to ) {
        case 'right' :
          $layer_selecter.find('.main').addClass( 'pull-left' );
          $layer_selecter.find('.sidebar').addClass( 'pull-' + to );
          break;
        case 'left' :
          $layer_selecter.find('.main').addClass( 'pull-right' );
          $layer_selecter.find('.sidebar').addClass( 'pull-' + to );
          break;
        case 'one_column' :
          $layer_selecter.find('.main').addClass( 'col-lg-24' );
          $layer_selecter.find('.sidebar').addClass( 'hidden' );
          break;
      }
    });
  });
  // ナビゲーション
  wp.customize('theme_mods_growcreater[layout_navigation]', function(value) {
    value.bind(function(to) {
      if ( to == 'true' ) {
        $('nav.navbar').css('display', 'block' );
      } else {
        $('nav.navbar').css('display', 'none' );
      };
    });
  });

  wp.customize('theme_mods_growcreater[navigation_color]', function(value) {
    value.bind(function(to) {
        $('nav.navbar').removeClass('navbar-relative navbar-default navbar-inverse').addClass( 'navbar-' + to );
    });
  });


  var logo = $('header#masthead .logo');

  // ロゴ テキストカラー
  wp.customize('theme_mods_growcreater[logo_text_color]', function(value) {
    value.bind(function(to) {
      logo.css('color', to );
    });
  });

  // ロゴ画像
  wp.customize('theme_mods_growcreater[logo_image_uoload]', function(value) {
    value.bind(function(to) {
      if ( logo.find('img') ) {
        logo.find('img').attr('src',  to );
      };
    });
  });

  // ロゴの大きさ
  wp.customize('theme_mods_growcreater[logo_size]', function(value) {
    value.bind(function(to) {
      logo.removeClass('normal full small');
      if ( to == 'small' ) {
        logo.closest('.col-lg-12').removeClass('col-lg-12').addClass( 'col-lg-8' );
        logo.closest('.col-lg-24').removeClass('col-lg-24').addClass( 'col-lg-8' );
      };
      if ( to == 'normal' ) {
        logo.closest('.col-lg-8').removeClass('col-lg-8').addClass( 'col-lg-12' );
        logo.closest('.col-lg-24').removeClass('col-lg-24').addClass( 'col-lg-12' );
      };
      if ( to == 'full' ) {
        logo.closest('.col-lg-8').removeClass('col-lg-8').addClass( 'col-lg-24' );
        logo.closest('.col-lg-12').removeClass('col-lg-12').addClass( 'col-lg-24' );
      };

      logo.addClass( to );
    });
  });

  // ロゴの位置
  wp.customize('theme_mods_growcreater[logo_align]', function(value) {
    value.bind(function(to) {
      logo.removeClass('text-center text-right text-left');
      logo.addClass( 'text-' + to );
    });
  });

  // ロゴの位置
  // wp.customize('theme_mods_growcreater[logo_align]', function(value) {
  //   value.bind(function(to) {
  //     logo.removeClass('text-center text-right text-left');
  //     logo.addClass( to );
  //   });
  // });

  // ヘッダー背景
  wp.customize('theme_mods_growcreater[header_background_image_upload]', function(value) {
    value.bind(function(to) {
      $('header#masthead').css('background-image', 'url(' + to + ')' );
    });
  });


});

<style>
    :root {
        --white-color: #fff;
        /* --theme-color: #5e3fd7; */
        --light-purple: rgba(117, 79, 254, 0.1);
        /* --heading-color: #040453; */
        --orange-color: #FC8068;
        --orange-deep: #FF3C16;
        --para-color: #52526C;
        --gray-color: #767588;
        --gray-color2: #929292;
        --disable-color: #B5B4BD;
        --color-green: #45C881;
        --color-light-green: rgba(69, 200, 129, 0.22);
        --color-yellow: #FFC014;
        --light-bg: #F9F8F6;
        --page-bg: #F8F6F0;
        /* --plyr-color-main: #5e3fd7; */
        --border-color: rgba(0, 0, 0, 0.07);
        --border-color2: rgba(0, 0, 0, 0.09);
        /* --font-jost: 'Jost', sans-serif; */
        /* style by sohel */
        --title-color-1: #060667;
        --accordion-bg: #EFEDE5;
        --accordion-active-color: #6449C3;
        --footer-svg-fill: #F8F6F0;
        --white: #ffffff;
        --white-10: rgba(255, 255, 255, 0.1);
        --white-20: rgba(255, 255, 255, 0.2);
        --white-55: rgba(255, 255, 255, 0.55);
        --white-65: rgba(255, 255, 255, 0.65);
        --white-72: rgba(255, 255, 255, 0.72);
        --black: #000000;
        --black-10: rgba(0, 0, 0, 0.1);
        --main-color: #060667;
        --main-color-8: rgba(6, 6, 103, 0.08);
        --secondary-color: #754ffe;
        --red: #fc8068;
        --para-text: #767588;
        --para-text-alt: #52526c;
        --yellow: #ffd25d;
        --yellow-1: #ffc107;
        --purple: #704fe6;
        --green: #45c881;
        --purple-light: #7a5ede;
        --blue-alt: #180f37;
        --section-bg: #f2f0e9;
        --lan-bg: #f8f6f0;
        --faq-header: #efede5;
        --price-toggle-bg: #e8e4f6;
        --price-toggle-btn: #704fe6;
        --cooking-primary: #0c0c0d;
        --cooking-primary-20: rgba(12, 12, 13, 0.2);
        --cooking-para-text: #7c7c7c;
        --cooking-red: #ee5e37;
        --cooking-red-17: rgba(238, 94, 55, 0.17);
        --cooking-discount: #52526c;
        --cooking-disable: #52526c;
        --cooking-yellow: #febe00;
        --cooking-orange: #ff9401;
        --cooking-header: #eeeadf;
        --cooking-price-toggle-bg: rgba(255, 255, 255, 0.38);
        --cooking-price-toggle-btn: #fff;
        --meditation-primary: #0c0c0d;
        --meditation-secondary: #52526c;
        --meditation-para-text: #7c7c7c;
        --meditation-red: #ee5e37;
        --meditation-yellow: #d8f87f;
        --meditation-blue: #46d3ff;
        --meditation-header: #ffeee8;
        --meditation-faq-header: #f9ede5;
        --meditation-testi-bg-20: rgba(254, 202, 184, 0.2);
        --meditation-price-toggle: #ffdcd2;
        --meditation-banner-1: #fecab8;
        --meditation-disable: rgba(255, 255, 255, 0.72);
        --meditation-hero-banner-gradient: linear-gradient(180deg, rgba(254, 202, 184, 0.6) 0%, rgba(248, 246, 240, 1) 100%);
        --meditation-video-gradient: linear-gradient(180deg, rgba(251, 109, 104, 0) 0%, rgba(251, 109, 104, 1) 100%);
        --meditation-core-feature-gradient: linear-gradient(180deg, rgba(12, 12, 13, 1) 0%, rgba(52, 29, 16, 1) 100%);
        --meditation-overlay-default: linear-gradient(180deg, rgba(251, 109, 104, 0) 0%, rgba(251, 109, 104, 1) 100%);
        --meditation-overlay-blue: linear-gradient(180deg, rgba(70, 211, 255, 0) 0%, rgba(70, 211, 255, 1) 100%);
        --meditation-overlay-yellow: linear-gradient(180deg, rgba(216, 248, 127, 0) 0%, rgba(216, 248, 127, 1) 100%);
        --kindergarten-primary: #101828;
        --kindergarten-para-text: #52526c;
        --kindergarten-secondary: #288f8a;
        --kindergarten-secondary-light: #d9fbf9;
        --kindergarten-white-alt: #f8f6f0;
        --kindergarten-coreFeatures: #fafafa;
        --kindergarten-yellow: #ffc014;
        --kindergarten-header: #2da19c;
        --kindergarten-disable: #52526c;
        --kindergarten-price-toggle-bg: rgba(40, 143, 138, 0.2);
        --kindergarten-price-toggle-btn: #288f8a;

        @if (get_option('app_font_design_type') == 2)
            @if (empty(get_option('app_font_link')))
                 --body-font-family: 'Jost', sans-serif;
        @else
         --body-font-family: {!! get_option('app_font_family') !!};
        @endif
    @else
         --body-font-family: 'Jost', sans-serif;
        @endif

        @if (get_option('app_color_design_type') == 2)
             --cooking-red: {{ empty(get_option('cooking_theme_color')) ? '#ee5e37' : get_option('cooking_theme_color') }};
        --cooking-orange: {{ empty(get_option('cooking_theme_color')) ? '#ee5e37' : get_option('cooking_theme_color') }};
        --cooking-price-toggle-btn: {{ empty(get_option('cooking_theme_color')) ? '#ee5e37' : get_option('cooking_theme_color') }};
        --cooking-primary: {{ empty(get_option('cooking_theme_heading_color')) ? '#0c0c0d' : get_option('cooking_theme_heading_color') }};
        --cooking-yellow: {{ empty(get_option('cooking_theme_secondary_bg_color')) ? '#d8f87f' : get_option('cooking_theme_secondary_bg_color') }};
        --cooking-footer: {{ empty(get_option('cooking_theme_bg_color')) ? '#0c0c0d' : get_option('cooking_theme_bg_color') }};
        --cooking-header-bg: {{ empty(get_option('cooking_header_bg_color')) ? '#ee5e37' : get_option('cooking_header_bg_color') }};
        --cooking-para-text: {{ empty(get_option('cooking_app_body_font_color')) ? '#7c7c7c' : get_option('cooking_app_body_font_color') }};
    @endif

    }
    @if (get_option('app_color_design_type') == 2)
        .bg-cooking-primary{
            background-color: var(--cooking-footer) !important;
        }
        .landing-footer-cooking{
            background: var(--cooking-footer) !important;
        }
        .landing-header-cooking #mainNav.sticky {
            background-color: var(--cooking-header-bg) !important;
        }
        .zTab-instructorOrganization-cooking {
            background-color: var(--cooking-red) !important;
        }
        .zTab-instructorOrganization-cooking .nav-link{
            color: var(--white) !important;
        }
    @endif
</style>

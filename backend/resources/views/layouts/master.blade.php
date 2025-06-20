<!DOCTYPE html>
<!--Purchase: https://1.envato.market/Vm7VRE-->
<html lang="en">
    <!--begin::Head-->
    <head>
        <title>{{ config('app.name') }}</title>
        <meta charset="utf-8" />
        <meta name="description" content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
        <meta name="keywords" content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
        <meta property="og:url" content="https://keenthemes.com/metronic" />
        <meta property="og:site_name" content="Metronic by Keenthemes" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="canonical" href="{{url('')}}" />
        <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
        <!--begin::Fonts(mandatory for all pages)-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Vendor Stylesheets(used for this page only)-->
        <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Vendor Stylesheets-->
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        @yield('beauty')
        <style>
            .select2-dropdown,.select2-container {
                display: block; /* Ensure the dropdown is visible */
                z-index: 9999; /* Ensure the dropdown appears on top */
            }
        </style>
        <!--end::Global Stylesheets Bundle-->
        <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
    </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body id="kt_body" class="header-fixed sidebar-enabled">
        <!--begin::Theme mode setup on page load-->
        <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
        <!--end::Theme mode setup on page load-->
        @yield('app')
        @yield('modals')
        <!--begin::Javascript-->
        <script>
            var hostUrl = "assets/";
            var pageLength = 25;
            var lengthMenu = [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ];
        </script>
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
        <script type="text/javascript">
            document.querySelector(".kt_button_indicator").addEventListener("click", function() {
                let button = this; // Correctly reference the clicked button
                button.setAttribute("data-kt-indicator", "on");

                setTimeout(function() {
                    button.removeAttribute("data-kt-indicator");
                }, 3000);
            });

            $(document).on('shown.bs.modal', function (e) {
                $(e.target).find('.thousand').each(function() {
                    Inputmask({
                        alias: "numeric",
                        groupSeparator: ".",
                        autoGroup: true,
                        digits: 0,
                        digitsOptional: false,
                        placeholder: "0",
                        removeMaskOnSubmit: true,
                        rightAlign: false
                    }).mask(this);
                });
            });

            
        </script>
        <!--end::Global Javascript Bundle-->
        @yield('compute')
        <!--end::Javascript-->
    </body>
    <!--end::Body-->
</html>
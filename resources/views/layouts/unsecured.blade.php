<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
        .alert-success {
            --bs-alert-color: var(--bs-success-text-emphasis);
            --bs-alert-bg: var(--bs-success-bg-subtle);
            --bs-alert-border-color: var(--bs-success-border-subtle);
            --bs-alert-link-color: var(--bs-success-text-emphasis);
        }
        .alert {
            --bs-alert-bg: transparent;
            --bs-alert-padding-x: 1rem;
            --bs-alert-padding-y: 1rem;
            --bs-alert-margin-bottom: 1rem;
            --bs-alert-color: inherit;
            --bs-alert-border-color: transparent;
            --bs-alert-border: var(--bs-border-width) solid var(--bs-alert-border-color);
            --bs-alert-border-radius: var(--bs-border-radius);
            --bs-alert-link-color: inherit;
            position: relative;
            padding: var(--bs-alert-padding-y) var(--bs-alert-padding-x);
            margin-bottom: var(--bs-alert-margin-bottom);
            color: var(--bs-alert-color);
            background-color: var(--bs-alert-bg);
            border: var(--bs-alert-border);
            border-radius: var(--bs-alert-border-radius);
        }
        [data-bs-theme=dark] {
            color-scheme: dark;
            --bs-body-color: #adb5bd;
            --bs-body-color-rgb: 173,181,189;
            --bs-body-bg: #212529;
            --bs-body-bg-rgb: 33,37,41;
            --bs-emphasis-color: #fff;
            --bs-emphasis-color-rgb: 255,255,255;
            --bs-secondary-color: rgba(173, 181, 189, 0.75);
            --bs-secondary-color-rgb: 173,181,189;
            --bs-secondary-bg: #343a40;
            --bs-secondary-bg-rgb: 52,58,64;
            --bs-tertiary-color: rgba(173, 181, 189, 0.5);
            --bs-tertiary-color-rgb: 173,181,189;
            --bs-tertiary-bg: #2b3035;
            --bs-tertiary-bg-rgb: 43,48,53;
            --bs-primary-text-emphasis: #6ea8fe;
            --bs-secondary-text-emphasis: #a7acb1;
            --bs-success-text-emphasis: #75b798;
            --bs-info-text-emphasis: #6edff6;
            --bs-warning-text-emphasis: #ffda6a;
            --bs-danger-text-emphasis: #ea868f;
            --bs-light-text-emphasis: #f8f9fa;
            --bs-dark-text-emphasis: #dee2e6;
            --bs-primary-bg-subtle: #031633;
            --bs-secondary-bg-subtle: #161719;
            --bs-success-bg-subtle: #051b11;
            --bs-info-bg-subtle: #032830;
            --bs-warning-bg-subtle: #332701;
            --bs-danger-bg-subtle: #2c0b0e;
            --bs-light-bg-subtle: #343a40;
            --bs-dark-bg-subtle: #1a1d20;
            --bs-primary-border-subtle: #084298;
            --bs-secondary-border-subtle: #41464b;
            --bs-success-border-subtle: #0f5132;
            --bs-info-border-subtle: #087990;
            --bs-warning-border-subtle: #997404;
            --bs-danger-border-subtle: #842029;
            --bs-light-border-subtle: #495057;
            --bs-dark-border-subtle: #343a40;
            --bs-link-color: #6ea8fe;
            --bs-link-hover-color: #8bb9fe;
            --bs-link-color-rgb: 110,168,254;
            --bs-link-hover-color-rgb: 139,185,254;
            --bs-code-color: #e685b5;
            --bs-border-color: #495057;
            --bs-border-color-translucent: rgba(255, 255, 255, 0.15);
            --bs-form-valid-color: #75b798;
            --bs-form-valid-border-color: #75b798;
            --bs-form-invalid-color: #ea868f;
            --bs-form-invalid-border-color: #ea868f;
        }
        :root, [data-bs-theme=light] {
            --bs-blue: #0d6efd;
            --bs-indigo: #6610f2;
            --bs-purple: #6f42c1;
            --bs-pink: #d63384;
            --bs-red: #dc3545;
            --bs-orange: #fd7e14;
            --bs-yellow: #ffc107;
            --bs-green: #198754;
            --bs-teal: #20c997;
            --bs-cyan: #0dcaf0;
            --bs-black: #000;
            --bs-white: #fff;
            --bs-gray: #6c757d;
            --bs-gray-dark: #343a40;
            --bs-gray-100: #f8f9fa;
            --bs-gray-200: #e9ecef;
            --bs-gray-300: #dee2e6;
            --bs-gray-400: #ced4da;
            --bs-gray-500: #adb5bd;
            --bs-gray-600: #6c757d;
            --bs-gray-700: #495057;
            --bs-gray-800: #343a40;
            --bs-gray-900: #212529;
            --bs-primary: #0d6efd;
            --bs-secondary: #6c757d;
            --bs-success: #198754;
            --bs-info: #0dcaf0;
            --bs-warning: #ffc107;
            --bs-danger: #dc3545;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
            --bs-primary-rgb: 13,110,253;
            --bs-secondary-rgb: 108,117,125;
            --bs-success-rgb: 25,135,84;
            --bs-info-rgb: 13,202,240;
            --bs-warning-rgb: 255,193,7;
            --bs-danger-rgb: 220,53,69;
            --bs-light-rgb: 248,249,250;
            --bs-dark-rgb: 33,37,41;
            --bs-primary-text-emphasis: #052c65;
            --bs-secondary-text-emphasis: #2b2f32;
            --bs-success-text-emphasis: #0a3622;
            --bs-info-text-emphasis: #055160;
            --bs-warning-text-emphasis: #664d03;
            --bs-danger-text-emphasis: #58151c;
            --bs-light-text-emphasis: #495057;
            --bs-dark-text-emphasis: #495057;
            --bs-primary-bg-subtle: #cfe2ff;
            --bs-secondary-bg-subtle: #e2e3e5;
            --bs-success-bg-subtle: #d1e7dd;
        Show All Properties (65 more)
        }
        :root {
            --docsearch-primary-color: #5468ff;
            --docsearch-text-color: #1c1e21;
            --docsearch-spacing: 12px;
            --docsearch-icon-stroke-width: 1.4;
            --docsearch-highlight-color: var(--docsearch-primary-color);
            --docsearch-muted-color: #969faf;
            --docsearch-container-background: rgba(101,108,133,0.8);
            --docsearch-logo-color: #5468ff;
            --docsearch-modal-width: 560px;
            --docsearch-modal-height: 600px;
            --docsearch-modal-background: #f5f6f7;
            --docsearch-modal-shadow: inset 1px 1px 0 0 hsla(0,0%,100%,0.5),0 3px 8px 0 #555a64;
            --docsearch-searchbox-height: 56px;
            --docsearch-searchbox-background: #ebedf0;
            --docsearch-searchbox-focus-background: #fff;
            --docsearch-searchbox-shadow: inset 0 0 0 2px var(--docsearch-primary-color);
            --docsearch-hit-height: 56px;
            --docsearch-hit-color: #444950;
            --docsearch-hit-active-color: #fff;
            --docsearch-hit-background: #fff;
            --docsearch-hit-shadow: 0 1px 3px 0 #d4d9e1;
            --docsearch-key-gradient: linear-gradient(-225deg,#d5dbe4,#f8f8f8);
            --docsearch-key-shadow: inset 0 -2px 0 0 #cdcde6,inset 0 0 1px 1px #fff,0 1px 2px 1px rgba(30,35,90,0.4);
            --docsearch-footer-height: 44px;
            --docsearch-footer-background: #fff;
            --docsearch-footer-shadow: 0 -1px 0 0 #e0e3e8,0 -3px 6px 0 rgba(69,98,155,0.12);
        }
        </style>
    </head>
    <body>
        <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>

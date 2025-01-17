<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Trix Editor CSS -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/mycourse.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <main>
        <!-- Start the project -->
        @role('owner|teacher')
        <div id="main-wrapper" class="flex p-5 xl:pr-0 min-h-screen">
            @include('layouts.components.sidebar')

            <div class="w-full page-wrapper xl:px-6 px-0">
                <!-- Main Content -->
                <main class="h-full max-w-full">
                    <div class="container full-container p-0 flex flex-col gap-6">
                        <!-- Header Start -->
                        <header class="bg-white shadow-lg rounded-[30px] w-full text-sm py-4 px-8">
                            @include('layouts.components.navbar')
                        </header>
                        <!-- Header End -->
                        {{ $slot }}
                    </div>
                </main>
                <!-- Main Content End -->
            </div>


        </div>
        @elserole('student')

        <!-- Main Content -->
        <main class="h-full max-w-full">
            <div class="container full-container p-0 flex flex-col gap-6">
                <!-- Header Start -->
                <header class="bg-white shadow-lg rounded-[30px] w-full text-sm py-4 px-8">
                    @include('layouts.components.navbar')
                </header>
                <!-- Header End -->
                {{ $slot }}
            </div>
        </main>
        @endrole
        <!-- Main Content End -->
        <!-- End of project -->
    </main>

    <!-- Dependencies -->
    {{-- jQuery (Ensure it's loaded first) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- Select2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    {{-- Flowbite --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>


    <!-- Application Scripts -->
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/dropdown/index.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/overlay/index.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <!-- Select2 Initialization -->
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Choose or add categories', // Placeholder for dropdown
                allowClear: true, // Clearable input
                tags: true, // Allow user to create new tags
                tokenSeparators: [',', ' '], // Tokens for creating new tags
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true // Mark as new tag
                    };
                }
            });
        });
    </script>
</body>

</html>

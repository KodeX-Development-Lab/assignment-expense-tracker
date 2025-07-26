<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <title>Pangea | @yield('title')</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('backend/media/shortcut_icon.png') }}" />
    <!--begin::Fonts-->
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('backend/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/custom_style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/css/dataTables.bootstrap5.min.css') }}">
    <link href="{{ asset('backend/css/quill.snow.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/css/github.min.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />

    <!-- flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Optional Bootstrap Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--end::Global Stylesheets Bundle-->
    @stack('style')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            @include('layouts.sidebar')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                @include('layouts.header')
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">@yield('breadcrumb')
                                </h1>
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-300 border-start mx-4"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        @yield('breadcrumb-info')
                                    </li>
                                </ul>
                                <!--end::Description-->
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!-- Main Content -->
                    <div class="post flex-column-fluid" id="kt_post">
                        @yield('content')
                    </div>

                    <button type="button" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4"
                        style="width: 60px; height: 60px; font-size: 24px;" data-bs-toggle="modal"
                        data-bs-target="#addTransactionModal">
                        +
                    </button>

                    <div class="modal" id="addTransactionModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="py-3 ps-3">
                                    <h5 class="modal-title text-black text-center">
                                        Choose
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <a href="{{ route('budgets.create', ['type' => 'income']) }}"
                                                class="me-3">

                                                Income
                                            </a>
                                        </div>
                                        <div class="col-6 text-center">
                                            <a href="{{ route('budgets.create', ['type' => 'expense']) }}"
                                                class="ms-3">

                                                Expense
                                            </a>
                                        </div>


                                    </div>

                                </div>
                                <div class="pt-2 pb-3 text-center">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Content-->
                <!--begin::Footer-->
                @include('layouts.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Scrolltop-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ asset('backend/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/scripts.bundle.js') }}"></script>
    {{-- <script src="{{ asset('backend/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script> --}}
    <script src="{{ asset('backend/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('backend/js/custom/apps/customers/list/list.js') }}"></script>
    <script src="{{ asset('backend/js/stand-alone-button.js') }}"></script>

    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('backend/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('backend/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('backend/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('backend/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('backend/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="{{ asset('backend/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/quill.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('backend/js/quill@1.3.7/quill.js') }}"></script>
    <script src="{{ asset('backend/js/quill-html-edit-button@2.2.7/quill.htmlEditButton.min.js') }}"></script>
    <script src="{{ asset('backend/js/highlight.min.js') }}"></script>
    <script src="{{ asset('backend/js/2.0.0-dev.4-quill.min.js') }}"></script>
    <script src="{{ asset('backend/js/quilleditor.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("wheel", function(event) {
            if (document.activeElement.type === "number") {
                document.activeElement.blur();
            }
        });

        function clearSearch() {
            $('.search-box').val('');

            $('.filter-clear-form').submit();
        }
    </script>
    <script>
        $('.show_confirm_delete').click(function(e) {
            e.preventDefault();
            let form = $(this).parent();
            Swal.fire({
                html: `Are you sure you want to delete?`,
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Delete",
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Deleted!',
                        'Your record have been deleted',
                        'success'
                    )
                }
            })
        });
    </script>
    <script>
        function statusChange(id, url) {
            Swal.fire({
                    html: `Want to change status?`,
                    icon: "question",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: id
                            },
                            success: function(response) {
                                let num = response.number;
                                if (response.success == true) {
                                    toastr.success('You have successfully changed Status');
                                    if (num) {
                                        if (response.isPublish == true) {
                                            $('#status' + num + id).html(
                                                `<span class="badge bg-primary" style="padding:5px 8px;">Valid</span>`
                                            );
                                        } else {
                                            $('#status' + num + id).html(
                                                `<span class="badge badge-light text-dark" style="padding:5px 8px;">Invalid</span>`
                                            );
                                        }
                                    } else {
                                        if (response.isPublish == true) {
                                            $('#status' + id).html(
                                                `<span class="badge bg-primary" style="padding:5px 8px;">Enabled</span>`
                                            );
                                        } else {
                                            $('#status' + id).html(
                                                `<span class="badge badge-light text-dark" style="padding:5px 8px;">Disabled</span>`
                                            );
                                        }
                                    }
                                }
                            },

                        })
                    } else {
                        location.reload(true);
                    }
                })
        }
    </script>
    <script src="{{ asset('backend/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: ".editor",
                height: "250",
                menubar: false,
                toolbar: ["styleselect fontselect fontsizeselect",
                    "undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify",
                    "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code"
                ],
                relative_urls: false,
                remove_script_host: true,

                images_upload_handler: function(blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '/upload');
                    var token = '{{ csrf_token() }}';
                    xhr.setRequestHeader("X-CSRF-Token", token);
                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success('{{ url('') }}' + json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                },
                directionality: 'ltr',

                plugins: 'image code ',

                /* enable title field in the Image dialog*/
                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                /*
                URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                images_upload_url: 'postAcceptor.php',
                here we add custom filepicker only to Image dialog
                */
                file_picker_types: 'image',
                /* and here's our custom image picker*/

            });
        });
    </script>
    @stack('scripts')
    <x-toast />
</body>
<!--end::Body-->

</html>

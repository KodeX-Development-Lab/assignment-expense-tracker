@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}")
    </script>
@endif
@if(session('message'))
    <script>
        toastr.success("{{ session('message') }}")
    </script>
@endif
@if(session('flash_message'))
    <script>
        toastr.success("{{ session('flash_message') }}")
    </script>
@endif
@if(session('warning'))
    <script>
        toastr.warning("{{ session('warning') }}")
    </script>
@endif
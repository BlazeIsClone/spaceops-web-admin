<x-default-layout>
    <div class="card mb-5">
        <div class="card-body">
            @include('admin.partials.data-table')
        </div>
    </div>

    @push('footer')
        @env('local')
        <script>
            {!! file_get_contents(resource_path('js/admin/post.js')) !!}
        </script>
        @endenv

        @env('production')
        <script src="{{ asset('assets/js/admin/post.js') }}"></script>
        @endenv
    @endpush
</x-default-layout>

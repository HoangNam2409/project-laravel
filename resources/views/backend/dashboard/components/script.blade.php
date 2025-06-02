<!-- Mainly scripts -->
<script src={{ asset('backend/js/jquery-3.1.1.min.js') }}></script>
<script src={{ asset('backend/js/bootstrap.min.js') }}></script>
<script src={{ asset('backend/js/plugins/metisMenu/jquery.metisMenu.js') }}></script>
<script src={{ asset('backend/js/plugins/metisMenu/jquery.metisMenu.js') }}></script>

<!-- Custom and plugin javascript -->
<script src={{ asset('backend/js/inspinia.js') }}></script>
<script src={{ asset('backend/js/plugins/pace/pace.min.js') }}></script>
{{-- jQuery custom --}}
<script src={{ asset('backend/library/library.js') }}></script>

<!-- jQuery UI -->
<script src={{ asset('backend/js/plugins/jquery-ui/jquery-ui.min.js') }}></script>


@if (isset($config['js']) && is_array($config['js']))
    @foreach ($config['js'] as $val)
        <script src="{{ asset($val) }}"></script>
    @endforeach
@endif

<base href="{{ env('APP_URL') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>INSPINIA | Dashboard v.2</title>

<link href={{ asset('backend/css/bootstrap.min.css') }} rel="stylesheet" />
<link href={{ asset('backend/font-awesome/css/font-awesome.css') }} rel="stylesheet" />

<link href={{ asset('backend/css/animate.css') }} rel="stylesheet" />
@if (isset($config['css']) && is_array($config['css']))
    @foreach ($config['css'] as $val)
        <link rel="stylesheet" href="{{ asset($val) }}" />
    @endforeach
@endif
<link href={{ asset('backend/css/style.css') }} rel="stylesheet" />
<link href={{ asset('backend/css/customize.css') }} rel="stylesheet" />
<script>
    const BASE_URL = "{{ env('APP_URL') }}"
</script>

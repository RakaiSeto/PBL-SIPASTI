{{-- @unless(
    Request::is('admin') ||
    Request::is('teknisi') ||
    Request::is('sarpras') ||
    Request::is('civitas')
)
<div class="bg-white p-4 rounded shadow mb-4">
    <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1">
            <li><a href="/" class="text-gray-500 hover:text-blue-600">Dashboard</a></li>
            <li class="px-1">/</li>
        </ol>
    </nav>
</div>
@endunless --}}

@php
    $role = Auth::check() ? Auth::user()->role->role_nama : null;
    $dashboardUrl = '/'; // default

    switch ($role) {
        case 'Admin':
            $dashboardUrl = '/admin';
            break;
        case 'Teknisi':
            $dashboardUrl = '/teknisi';
            break;
        case 'Sarpras':
            $dashboardUrl = '/sarpras';
            break;
        case 'Civitas':
            $dashboardUrl = '/civitas';
            break;
    }
@endphp

@unless(
    Request::is('admin') ||
    Request::is('teknisi') ||
    Request::is('sarpras') ||
    Request::is('civitas')
)
<div class="bg-white p-4 rounded shadow mb-4">
    <nav class="text-base text-gray-600" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1">
            <li>
                <a href="{{ $dashboardUrl }}" class="text-gray-500 hover:text-blue-600">
                    Dashboard
                </a>
            </li>
            <li class="px-1">/</li>
        </ol>
    </nav>
</div>
@endunless


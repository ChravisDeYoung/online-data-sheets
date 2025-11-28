<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4">

@auth
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
            type="button"
            class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">

        <span class="sr-only">Open sidebar</span>

        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                  d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <aside id="default-sidebar"
           class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
           aria-label="Sidebar">
        <div
            class="h-full px-3 py-4 overflow-y-auto bg-white shadow dark:border dark:bg-gray-800 dark:border-gray-700">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboards.index') }}"
                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <x-sidebar-icon name="dashboard"/>

                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('notifications.index') }}"
                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <x-sidebar-icon name="inbox"/>

                        <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>

                        @if (Auth::user()->unreadNotifications->isNotEmpty())
                            <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </li>

                @if (Auth::user()->hasAnyRole(['admin']))
                    <li>
                        <button type="button"
                                class="flex items-center w-full justify-between p-2 text-gray-900 dark:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group"
                                aria-controls="admin-dropdown" data-collapse-toggle="admin-dropdown">
                            <x-sidebar-icon name="admin"/>

                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Admin</span>

                            <x-sidebar-icon name="dropdown"/>
                        </button>

                        <ul id="admin-dropdown" class="hidden py-2 pl-6 space-y-2">
                            <li>
                                <a href="{{ route('users.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <x-sidebar-icon name="users"/>

                                    <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('fields.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <x-sidebar-icon name="fields"/>

                                    <span class="flex-1 ms-3 whitespace-nowrap">Fields</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('pages.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <x-sidebar-icon name="pages"/>

                                    <span class="flex-1 ms-3 whitespace-nowrap">Pages</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('dashboard-tiles.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <x-sidebar-icon name="dashboard-tiles"/>

                                    <span class="flex-1 ms-3 whitespace-nowrap">Dashboard Tiles</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li>
                    <form id="logout-form" method="POST" action="{{ route('sessions.destroy') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center text-start w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <x-sidebar-icon name="logout"/>

                            <span class="flex-1 ms-3 whitespace-nowrap">Log Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>
@endauth

<div class="@auth sm:ml-64 @endauth">
    {{ $slot }}
</div>

<x-flash/>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EasyColoc</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    fontFamily: {

                        serif: ['DM Serif Display', 'serif'],

                        sans: ['DM Sans', 'sans-serif'],

                    },

                    colors: {
                    adminbg: '#0F172A', 
                    admincard: '#1E293B',    
                    adminborder: '#334155', 
                    adminaccent: '#2563EB',  
                    admintext: '#E2E8F0',    
                    adminmuted: '#94A3B8'    
                     }

                }

            }

        }

    </script>

</head>

<body class="bg-adminbg font-sans text-admintext min-h-screen">

    <!-- Header -->
    <header class="bg-admincard border-b border-adminborder">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-adminaccent flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 4l9 5.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
                    </svg>
                </div>
                <span class="font-serif text-xl text-admintext tracking-tight">EasyColoc Admin</span>
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-4">
                <a href="/dashboard" class="bg-adminborder px-3 py-1.5 rounded-full text-adminaccent text-sm font-medium hover:bg-adminaccent/10 transition">Go Back</a>

                <div class="flex items-center gap-2 bg-adminborder px-3 py-1.5 rounded-full">
                    <div class="w-5 h-5 rounded-full bg-adminaccent/30 flex items-center justify-center">
                        <span class="text-adminaccent text-xs font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <span class="text-adminmuted text-sm font-medium">{{ auth()->user()->name }}</span>
                </div>

                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-adminmuted hover:text-admintext transition-colors duration-200 flex items-center gap-1.5 group">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <div class="max-w-6xl mx-auto px-6 py-8 space-y-8">

        <!-- Stats cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-admincard border border-adminborder rounded-2xl p-6 shadow-sm">
                <h3 class="text-adminmuted text-sm font-medium mb-2">Users</h3>
                <h4 class="text-admintext text-xl font-semibold">{{ count($users) }}</h4>
            </div>

            <div class="bg-admincard border border-adminborder rounded-2xl p-6 shadow-sm">
                <h3 class="text-adminmuted text-sm font-medium mb-2">Accommodations</h3>
                <h4 class="text-admintext text-xl font-semibold">{{ count($colocs) }}</h4>
            </div>
            <div class="bg-admincard border border-adminborder rounded-2xl p-6 shadow-sm">
                <h3 class="text-adminmuted text-sm font-medium mb-2">Canceles Accommodations</h3>
                <h4 class="text-admintext text-xl font-semibold">{{ $colocs->where('state', 'canceled')->count() }}</h4>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-admincard border border-adminborder rounded-2xl shadow-sm overflow-x-auto">
            <table class="min-w-full divide-y divide-adminborder">
                <thead class="bg-adminborder">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-adminmuted">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-adminmuted">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-adminmuted">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-adminmuted">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-adminborder">
                    @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 text-admintext">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-admintext">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if (!$user->is_banned)
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-600 text-white">Active</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-600 text-white">Banned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4"
                        @if (!$user->hasRole('admin'))
                            @if (!$user->is_banned)
                                <h1></h1>
                                <a href="/ban/{{ $user->id }}" class="bg-adminborder px-3 py-1.5 rounded-full text-adminaccent text-sm font-medium hover:bg-adminaccent/10 transition">Ban</a>
                            @else
                                <h1></h1>
                                <a href="/unban/{{ $user->id }}" method="POST" class="bg-adminborder px-3 py-1.5 rounded-full text-adminaccent text-sm font-medium hover:bg-adminaccent/10 transition">Unban</a>
                            @endif
                        @else
                            <button class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm hover:bg-red-500 transition">Protected</button>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
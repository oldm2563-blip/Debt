<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                        cream: '#FAF8F5',
                        ink: '#1A1A2E',
                        sage: '#4A7C6F',
                        blush: '#E8DDD4',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-cream font-sans min-h-screen">

    <!-- Header -->
    <header class="bg-white border-b border-blush sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-sage flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 4l9 5.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
                    </svg>
                </div>
                <span class="font-serif text-xl text-ink tracking-tight">EasyColoc</span>
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-4">
                <!-- User badge -->
                <div class="flex items-center gap-2 bg-blush px-3 py-1.5 rounded-full">
                    <div class="w-5 h-5 rounded-full bg-sage/30 flex items-center justify-center">
                        <span class="text-sage text-xs font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <span class="text-ink/70 text-sm font-medium">{{ auth()->user()->name }}</span>
                </div>

                <!-- Logout -->
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-sm font-medium text-ink/50 hover:text-ink transition-colors duration-200 flex items-center gap-1.5 group">
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
    <main class="max-w-6xl mx-auto px-6 py-10">

        <!-- Page title -->
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-ink">Your colocation</h1>
            <p class="text-ink/50 text-sm mt-1">Manage your household members and shared expenses.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Members card -->
            <div class="bg-white rounded-2xl border border-blush p-6 shadow-sm">

                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <!-- Icon -->
                        <div class="w-8 h-8 rounded-full bg-sage/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-sage" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6zM3 17a3 3 0 016 0"/>
                            </svg>
                        </div>
                        <h2 class="font-serif text-lg text-ink">Members</h2>
                    </div>
                    <span class="text-xs font-medium text-sage bg-sage/10 px-2.5 py-1 rounded-full">
                        {{ count($users) }} people
                    </span>
                </div>

                <ul class="space-y-3">
                    @foreach ($users as $user)
                        <li class="flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blush flex items-center justify-center flex-shrink-0">
                                    <span class="text-sm font-medium text-sage">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="text-sm font-medium text-ink">{{ $user->name }}</span>
                            </div>
                            @if ($user->pivot->role === 'owner')
                                <span class="text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full capitalize">
                                    {{ $user->pivot->role }}
                                </span>
                            @else
                                <span class="text-xs font-medium text-ink/40 bg-blush px-2 py-0.5 rounded-full capitalize">
                                    {{ $user->pivot->role }}
                                </span>
                            @endif
                        </li>
                    @endforeach
                    <div class="pt-3">
                        <a href="#" id="inviteToggle"
                        class="block w-full text-center text-sm font-medium text-sage bg-sage/10 px-4 py-2 rounded-xl border border-blush">
                            Invite a new member
                        </a>
                    </div>

                    <div id="inviteForm" class="hidden pt-3">
                        <form action="/invite/{{ $coloc->id }}" method="POST">
                            @csrf
                            <input type="email" name="email" placeholder="Enter email address" class="w-full px-3 py-2 text-sm border border-blush rounded-xl bg-cream focus:outline-none">
                            <button type="submit" class="mt-3 w-full bg-sage text-white text-sm font-medium px-4 py-2 rounded-xl">invite</button>
                        </form>
                    </div>
                </ul>

            </div>

            <div class="lg:col-span-2 bg-white rounded-2xl border border-blush p-6 shadow-sm">

                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-sage/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-sage" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="font-serif text-lg text-ink">Expenses</h2>
                    </div>

                    <button class="flex items-center gap-1.5 text-sm font-medium text-white bg-sage hover:bg-sage/90 transition-colors duration-200 px-4 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add expense
                    </button>
                </div>
                <div>
                    
                </div>
            </div>

        </div>
    </main>

</body>
<script>
    document.getElementById('inviteToggle').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('inviteForm').classList.toggle('hidden');
    });
</script>
</html>
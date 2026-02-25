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

<body class="bg-cream font-sans">



    <header class="bg-white border-b border-blush">

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

    <main class="flex-grow flex flex-col items-center justify-center text-center px-6">
    <h3 class="text-2xl font-serif text-ink mb-6">Do you wish to accept the invitation?</h3>

    <div class="flex gap-4">
      <a href="/accept/{{ $invite->token }}" class="px-6 py-3 bg-sage text-white font-medium rounded-lg hover:bg-sage/80 transition-colors duration-200">
        Yes
      </a>
      <a href="/dashboard" class="px-6 py-3 bg-blush text-ink font-medium rounded-lg hover:bg-blush/90 transition-colors duration-200">
        No
      </a>
    </div>
  </main>

</body>
</html>
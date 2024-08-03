<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiAuth</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        #video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .auth-container {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            border-radius: 5px;
            z-index: 1;
        }
        .auth-container a {
            color: white;
            text-decoration: none;
            margin-right: 10px;
        }
        .auth-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="video-container">
        <video part="video" crossorigin="" playsinline="" muted="" oncontextmenu="return false;" src="{{ Storage::url('public/video/homepage.mp4') }}" preload="metadata" autoplay loop></video>
    </div>
    @if (Route::has('login'))
        <div class="auth-container">
            @auth
                @php
                    $userType = Auth::user()->user_type ?? null;
                    $homeRoute = $userType === 'admin' ? route('admin.home') : ($userType === 'manager' ? route('manager.home') : url('/home'));
                @endphp

                <a href="{{ $homeRoute }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endif
            @endauth
        </div>
    @endif

</body>
</html>

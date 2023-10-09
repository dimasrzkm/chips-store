<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white border border-gray-200 rounded-lg shadow card md:w-2/6 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-5 py-6 card-header">
                <h1 class="text-4xl font-semibold text-center">Sign In</h1>
            </div>
            <div class="px-8 py-2 card-bod">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Username</span>
                        </label>
                        <input type="text" placeholder="Username" name="username"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none"
                            value="{{ old('username') }}" />
                        <label class="label">
                            @error('username')
                                <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" placeholder="********" name="password"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none" />
                        <label class="label">
                            @error('password')
                                <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
            </div>
            <div class="flex justify-end px-8 py-3 card-footer">
                <button class="text-white bg-blue-700 rounded-lg btn hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
            </div>
            </form>
        </div>
    </div>
</body>

</html>

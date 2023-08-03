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
    <div class="flex justify-center items-center h-screen bg-[#bae8e8]">
        <div class="card bg-[#fffffe] md:w-2/6">
            <div class="card-header px-5 py-6">
                <h1 class="text-center font-semibold text-4xl">Sign In</h1>
            </div>
            <div class="card-bod py-2 px-8">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" placeholder="Email" name="email"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none"
                            value="{{ old('email') }}" />
                        <label class="label">
                            @error('email')
                                <span class="label-text-alt text-rose-600 text-sm">{{ $message }}</span>
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
                                <span class="label-text-alt text-rose-600 text-sm">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
            </div>
            <div class="card-footer px-8 py-3 flex justify-end">
                <button class="btn bg-[#bae8e8] hover:bg-[#bae8e8] text-[#272343] font-bold">Login</button>
            </div>
            </form>
        </div>
    </div>
</body>

</html>

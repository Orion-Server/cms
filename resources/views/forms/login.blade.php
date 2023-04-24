<h2 class="text-2xl font-semibold text-gray-700 text-center">Login</h2>
<p class="text-lg text-gray-600 text-center">Welcome back!</p>
<div class="mt-4 flex flex-col">
    <label class="text-gray-700 text-left text-sm font-bold mb-2">
        <i class="fa-regular fa-user"></i>
        Email/Username
    </label>
    <input placeholder="Email/Username"
        class="bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-500 border rounded-lg py-2 px-4 block w-full appearance-none"
        type="email">
</div>
<div class="mt-4 flex flex-col">
    <label class="block text-gray-700 text-left text-sm font-bold mb-2">
        <i class="fa-solid fa-lock"></i>
        Password
    </label>
    <input placeholder="Password"
        class="bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-500 border rounded-lg py-2 px-4 block w-full appearance-none"
        type="password">
</div>
<div class="flex gap-4 mt-6">
    <x-ui.button @click="toggleToRegisterModal()"
        class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 flex-1 py-3">
        <i class="fa-solid fa-user-plus"></i>
        Register
    </x-ui.button>
    <x-ui.button
        class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 flex-1 py-3">
        <i class="fa-solid fa-right-to-bracket"></i>
        Login
    </x-ui.button>
</div>
<div class="my-6 flex items-center justify-between">
    <span class="border-b w-1/5 md:w-1/4"></span>
    <span class="text-xs text-gray-500 uppercase">or join with</span>
    <span class="border-b w-1/5 md:w-1/4"></span>
</div>
<div class="flex justify-around flex-col sm:flex-row gap-3 mt-4">
    <a href="#" class="flex gap-3 items-center justify-center text-white rounded-lg shadow-md hover:bg-gray-100">
        <div class="pl-4 py-3">
            <i class="fa-brands fa-google text-red-500"></i>
        </div>
        <h1 class="pr-4 py-3 text-center text-gray-600 font-bold">Google</h1>
    </a>
    <a href="#" class="flex gap-3 items-center justify-center text-white rounded-lg shadow-md hover:bg-gray-100">
        <div class="pl-4 py-3">
            <i class="fa-brands fa-facebook-f text-blue-500"></i>
        </div>
        <h1 class="pr-4 py-3 text-center text-gray-600 font-bold">Facebook</h1>
    </a>
    <a href="#" class="flex gap-3 items-center justify-center text-white rounded-lg shadow-md hover:bg-gray-100">
        <div class="pl-4 py-3">
            <i class="fa-brands fa-discord text-gray-900"></i>
        </div>
        <h1 class="pr-4 py-3 text-center text-gray-600 font-bold">Discord</h1>
    </a>
</div>

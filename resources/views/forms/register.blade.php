<h2 class="text-2xl font-semibold text-gray-700 text-center">Register</h2>
<p class="text-lg text-gray-600 text-center">We are glad you are here!</p>
<div class="mt-4 flex flex-col">
    <label class="text-gray-700 text-left text-sm font-bold mb-2">
        <i class="fa-regular fa-user"></i>
        Username
    </label>
    <input placeholder="Username"
        class="bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-500 border rounded-lg py-2 px-4 block w-full appearance-none"
        type="text">
</div>
<div class="mt-4 flex flex-col">
    <label class="text-gray-700 text-left text-sm font-bold mb-2">
        <i class="fa-regular fa-envelope"></i>
        Email
    </label>
    <input placeholder="Email"
        class="bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-500 border rounded-lg py-2 px-4 block w-full appearance-none"
        type="email">
</div>
<div class="flex mt-4 justify-between gap-3 sm:flex-row flex-col bg-gray-100 p-2 rounded-lg">
    <div class="flex flex-col">
        <label class="block text-gray-700 text-left text-sm font-bold mb-2">
            <i class="fa-solid fa-lock"></i>
            Your Password
        </label>
        <input placeholder="Password"
            class="bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-500 border rounded-lg py-2 px-4 block w-full appearance-none"
            type="password">
    </div>
    <div class="flex flex-col">
        <label class="block text-gray-700 text-left text-sm font-bold mb-2">
            <i class="fa-solid fa-lock"></i>
            Confirm Password
        </label>
        <input placeholder="Confirmation"
            class="bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-500 border rounded-lg py-2 px-4 block w-full appearance-none"
            type="password">
    </div>
</div>
<div class="flex gap-4 mt-6">
    <x-ui.button
        class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 flex-1 py-3 text-white">
        <i class="fa-solid fa-user-plus"></i>
        Register
    </x-ui.button>
</div>
<a class="text-gray-500 underline underline-offset-4 block text-center mt-6 text-sm" href="#" @click="toggleToLoginModal()">Click here if you already have an account</a>

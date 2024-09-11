<nav class="h-full border-gray-100 flex flex-col rounded-[2vw]">
    <!-- Sidebar Navigation Menu -->
    <div class="flex-grow px-4 py-4 space-y-4">
        <!-- Logo -->
        <!-- <div class="shrink-0 flex justify-center items-center text-white bg-white rounded-xl">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-[6vw] w-auto fill-current text-black" />
            </a>
        </div> -->

        <!-- Navigation Links -->
        <div class="space-y-3 flex flex-col pt-6">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[1.5rem] anek-latin-bold pb-5 hover:scale-[1.05] hover:transition duration-100 ease-in-out hover:shadow-lg">
                {{ __('Dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('chart-data')" :active="request()->routeIs('chart-data')" class="text-[1.5rem] anek-latin-bold pb-5 hover:scale-[1.05] hover:transition duration-100 ease-in-out hover:shadow-lg">
                {{ __('Grouped Bar Chart') }}
            </x-nav-link>
            <x-nav-link :href="route('linechart.view')" :active="request()->routeIs('linechart.view')" class="text-[1.5rem] anek-latin-bold pb-5 hover:scale-[1.05] hover:transition duration-100 ease-in-out hover:shadow-lg">
                {{ __('Line Chart') }}
            </x-nav-link>
        </div>
    </div>
</nav>

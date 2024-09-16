<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    @if (Auth::user()->usdt_address)
                    address:
                    {{ Auth::user()->usdt_address}}
                    @else
                        <button type="button" id="bindAddress"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >BindAddress</button>
                    @endif
            </div>


        </div>
    </div>
</x-app-layout>
<script src="/js/jquery-3.7.1.min.js"></script>
<script>
jQuery(function ($){
    console.log('ready$:', $);
    $('#bindAddress').click(function (){
        console.log('@click bindAddress');
        $.get('/bind_address', function (data){
            console.log('/bind_address resp:', data);
            window.location.reload();
        }).fail(function (){
            console.log('failed');
        });
    })
});
</script>

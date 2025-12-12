<x-layout>
    <x-slot name="sidebar">
        <x-navigation-sidebar/>
    </x-slot>
    <h1>Welcome {{Auth::user()->name}}.</h1>
</x-layout>
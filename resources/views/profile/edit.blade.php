@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Header del Perfil --}}
            <div class="mb-8">
                <h2 class="font-bold text-3xl text-white">
                    {{ __('Perfil de Usuario') }}
                </h2>
                <p class="text-slate-400">Administra tu información personal y seguridad.</p>
            </div>

            <div class="p-4 sm:p-8 bg-[#1a1a1a] shadow-lg shadow-black/40 sm:rounded-xl border border-slate-800">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#1a1a1a] shadow-lg shadow-black/40 sm:rounded-xl border border-slate-800">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#1a1a1a] shadow-lg shadow-black/40 sm:rounded-xl border border-slate-800">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Profile') }}
    </h2>
@stop

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
       
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Profile Information') }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Update your account's profile information and email address.") }}</p>

                <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    
                    {{-- profile --}}
                    <div class="mb-3">
                        {{-- <label for="image" class="form-label">{{ __('Profile Image') }}</label>
                        <input id="image" name="image" type="file" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                 --}}
                        @if ($user->image)
                            <div class="mt-3">
                                <img src="{{ Storage::url($user->image) }}" alt="Profile Image" class="img-fluid" style="max-width: 150px;">
                            </div>
                        @endif
                    </div>
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2">
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to re-send the verification email.') }}</button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Save Button -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password Form -->
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Update Password') }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
        
                <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')
        
                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                        <input id="update_password_password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <!-- Save Button -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success mt-3" role="alert">
                                <p class="mb-0">{{ __('Password updated successfully.') }}</p>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        

        <!-- Delete Account Form -->
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Delete Account') }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data or information you wish to retain before deleting your account.') }}
                </p>

                <!-- Delete Account Button -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    {{ __('Delete Account') }}
                </button>

                <!-- Modal for Deleting Account -->
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter your password') }}" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Add any additional custom styles if needed --}}
@stop

@section('js')
    {{-- Include any additional custom scripts if needed --}}
    <script> console.log("Profile page loaded"); </script>
@stop

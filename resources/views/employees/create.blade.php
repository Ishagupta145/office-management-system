@extends('layouts.app')

@section('title', isset($employee) ? 'Edit Employee' : 'Create Employee')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">{{ isset($employee) ? 'Edit Employee' : 'Create New Employee' }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ isset($employee) ? 'Update employee information' : 'Add a new employee to the system' }}</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}" method="POST">
            @csrf
            @if(isset($employee))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="first_name" 
                           id="first_name" 
                           value="{{ old('first_name', $employee->first_name ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-500 @enderror"
                           required>
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="last_name" 
                           id="last_name" 
                           value="{{ old('last_name', $employee->last_name ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-500 @enderror"
                           required>
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $employee->email ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone', $employee->phone ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="position" 
                           id="position" 
                           value="{{ old('position', $employee->position ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('position') border-red-500 @enderror"
                           required>
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary -->
                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-2">
                        Salary
                    </label>
                    <input type="number" 
                           name="salary" 
                           id="salary" 
                           step="0.01"
                           value="{{ old('salary', $employee->salary ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('salary') border-red-500 @enderror">
                    @error('salary')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Company -->
                <div>
                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Company <span class="text-red-500">*</span>
                    </label>
                    <select name="company_id" 
                            id="company_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('company_id') border-red-500 @enderror"
                            required>
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" 
                                    {{ old('company_id', $employee->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Manager -->
<div>
    <label for="manager_id" class="block text-sm font-medium text-gray-700 mb-2">
        Manager
    </label>

    <select name="manager_id"
            id="manager_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                   focus:border-blue-500 focus:ring-blue-500
                   @error('manager_id') border-red-500 @enderror">
        <option value="">Select Company First</option>
    </select>

    @error('manager_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

            </div>

            <!-- Location Fields -->
            <div class="mt-6 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Location Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            Country
                        </label>
                        <select name="country" 
                                id="country" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('country') border-red-500 @enderror">
                            <option value="">Select Country</option>
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                            State
                        </label>
                        <select name="state" 
                                id="state" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('state') border-red-500 @enderror"
                                disabled>
                            <option value="">Select State</option>
                        </select>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            City
                        </label>
                        <select name="city" 
                                id="city" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('city') border-red-500 @enderror"
                                disabled>
                            <option value="">Select City</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Hire Date -->
            <div class="mt-4">
                <label for="hire_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Hire Date
                </label>
                <input type="date" 
                       name="hire_date" 
                       id="hire_date" 
                       value="{{ old('hire_date', isset($employee) ? $employee->hire_date?->format('Y-m-d') : '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('hire_date') border-red-500 @enderror">
                @error('hire_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 mt-6">
                <a href="{{ route('employees.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ isset($employee) ? 'Update Employee' : 'Create Employee' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const savedCountry = "{{ old('country', $employee->country ?? '') }}";
    const savedState = "{{ old('state', $employee->state ?? '') }}";
    const savedCity = "{{ old('city', $employee->city ?? '') }}";
    let currentCountry = savedCountry;

    // Load countries on page load
    loadCountries();
    function loadCountries() {
    $.ajax({
        url: '/locations/countries',
        method: 'GET',
        success: function(data) {
            $('#country').html('<option value="">Select Country</option>');

            data.forEach(function(country) {
                const selected = country.country_name === savedCountry ? 'selected' : '';
                $('#country').append(
                    `<option value="${country.country_name}" ${selected}>
                        ${country.country_name}
                     </option>`
                );
            });

            if (savedCountry) {
                currentCountry = savedCountry;
                loadStates(savedCountry);
            }
        },
        error: function(error) {
            console.error('Error loading countries:', error);
            alert('Failed to load countries. Please refresh the page.');
        }
    });
}


    function loadStates(country) {
        $('#state').prop('disabled', true).html('<option value="">Loading...</option>');
        $('#city').prop('disabled', true).html('<option value="">Select City</option>');
        currentCountry = country;

        $.ajax({
            url: `/locations/states/${encodeURIComponent(country)}`,
            method: 'GET',
            success: function(data) {
                $('#state').html('<option value="">Select State</option>');
                if (data && data.length > 0) {
                    data.forEach(function(state) {
                        const selected = state.state_name === savedState ? 'selected' : '';
                        $('#state').append(`<option value="${state.state_name}" ${selected}>${state.state_name}</option>`);
                    });
                    $('#state').prop('disabled', false);
                    
                    if (savedState) {
                        loadCities(savedState, country);
                    }
                } else {
                    $('#state').html('<option value="">No states available</option>');
                    $('#state').prop('disabled', true);
                }
            },
            error: function(error) {
                console.error('Error loading states:', error);
                $('#state').html('<option value="">Error loading states</option>');
                $('#state').prop('disabled', true);
            }
        });
    }

    function loadCities(state, country) {
        $('#city').prop('disabled', true).html('<option value="">Loading...</option>');

        $.ajax({
            url: `/locations/cities/${encodeURIComponent(state)}?country=${encodeURIComponent(country)}`,
            method: 'GET',
            success: function(data) {
                $('#city').html('<option value="">Select City</option>');
                if (data && data.length > 0) {
                    data.forEach(function(city) {
                        const selected = city.city_name === savedCity ? 'selected' : '';
                        $('#city').append(`<option value="${city.city_name}" ${selected}>${city.city_name}</option>`);
                    });
                    $('#city').prop('disabled', false);
                } else {
                    $('#city').html('<option value="">No cities available</option>');
                    $('#city').prop('disabled', true);
                }
            },
            error: function(error) {
                console.error('Error loading cities:', error);
                $('#city').html('<option value="">Error loading cities</option>');
                $('#city').prop('disabled', true);
            }
        });
    }

    // Event listeners
    $('#country').change(function() {
        const country = $(this).val();
        if (country) {
            currentCountry = country;
            loadStates(country);
        } else {
            $('#state').prop('disabled', true).html('<option value="">Select State</option>');
            $('#city').prop('disabled', true).html('<option value="">Select City</option>');
        }
    });

    $('#state').change(function() {
        const state = $(this).val();
        if (state && currentCountry) {
            loadCities(state, currentCountry);
        } else {
            $('#city').prop('disabled', true).html('<option value="">Select City</option>');
        }
    });

    $(document).ready(function () {

    const savedManager = "{{ old('manager_id', $employee->manager_id ?? '') }}";

    $('#company_id').change(function () {
        const companyId = $(this).val();

        $('#manager_id').html('<option value="">Loading managers...</option>');

        if (!companyId) {
            $('#manager_id').html('<option value="">Select Company First</option>');
            return;
        }

        $.ajax({
            url: `/companies/${companyId}/managers`,
            method: 'GET',
            success: function (data) {
                $('#manager_id').html('<option value="">No Manager</option>');

                data.forEach(function (manager) {
                    $('#manager_id').append(
                        `<option value="${manager.id}">${manager.name}</option>`
                    );
                });

                // Preselect manager in Edit Employee
                if (savedManager) {
                    $('#manager_id').val(savedManager);
                }
            },
            error: function () {
                $('#manager_id').html('<option value="">Error loading managers</option>');
            }
        });
    });

    // Auto-load managers on Edit page
    if ($('#company_id').val()) {
        $('#company_id').trigger('change');
    }
});
});
</script>
@endpush
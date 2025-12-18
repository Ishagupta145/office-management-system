@extends('layouts.app')

@section('title', isset($employee) ? 'Edit Employee' : 'Create Employee')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">
            {{ isset($employee) ? 'Edit Employee' : 'Create New Employee' }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ isset($employee) ? 'Update employee information' : 'Add a new employee to the system' }}
        </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}" method="POST">
            @csrf
            @if(isset($employee))
                @method('PUT')
            @endif

            {{-- Basic Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">First Name *</label>
                    <input type="text" name="first_name" required
                        value="{{ old('first_name', $employee->first_name ?? '') }}"
                        class="w-full rounded-md border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Last Name *</label>
                    <input type="text" name="last_name" required
                        value="{{ old('last_name', $employee->last_name ?? '') }}"
                        class="w-full rounded-md border-gray-300">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Email *</label>
                    <input type="email" name="email" required
                        value="{{ old('email', $employee->email ?? '') }}"
                        class="w-full rounded-md border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Phone</label>
                    <input type="text" name="phone"
                        value="{{ old('phone', $employee->phone ?? '') }}"
                        class="w-full rounded-md border-gray-300">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Position *</label>
                    <input type="text" name="position" required
                        value="{{ old('position', $employee->position ?? '') }}"
                        class="w-full rounded-md border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Salary</label>
                    <input type="number" step="0.01" name="salary"
                        value="{{ old('salary', $employee->salary ?? '') }}"
                        class="w-full rounded-md border-gray-300">
                </div>
            </div>

            {{-- Company & Manager --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Company *</label>
                    <select name="company_id" id="company_id" required class="w-full rounded-md border-gray-300">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_id', $employee->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Manager</label>
                    <select name="manager_id" id="manager_id" class="w-full rounded-md border-gray-300">
                        <option value="">Select Company First</option>
                    </select>
                </div>
            </div>

            {{-- Location --}}
            <div class="mt-6 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">Location Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select id="country" name="country" class="rounded-md border-gray-300">
                        <option value="">Select Country</option>
                    </select>

                    <select id="state" name="state" class="rounded-md border-gray-300" disabled>
                        <option value="">Select State</option>
                    </select>

                    <select id="city" name="city" class="rounded-md border-gray-300" disabled>
                        <option value="">Select City</option>
                    </select>
                </div>
            </div>

            {{-- Hire Date --}}
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Hire Date</label>
                <input type="date" name="hire_date"
                    value="{{ old('hire_date', isset($employee) ? $employee->hire_date?->format('Y-m-d') : '') }}"
                    class="w-full rounded-md border-gray-300">
            </div>

            {{-- Actions --}}
            <div class="flex justify-end mt-6 gap-3">
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-200 rounded-md">Cancel</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    {{ isset($employee) ? 'Update Employee' : 'Create Employee' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {

    const savedManager = "{{ old('manager_id', $employee->manager_id ?? '') }}";
    const savedCountry = "{{ old('country', $employee->country ?? '') }}";
    const savedState   = "{{ old('state', $employee->state ?? '') }}";
    const savedCity    = "{{ old('city', $employee->city ?? '') }}";

    /* ================== MANAGERS ================== */
    $('#company_id').on('change', function () {
        const companyId = $(this).val();
        $('#manager_id').html('<option>Loading managers...</option>');

        if (!companyId) {
            $('#manager_id').html('<option>Select Company First</option>');
            return;
        }

        $.get(`/api/companies/${companyId}/managers`)
            .done(function (data) {
                $('#manager_id').html('<option value="">No Manager</option>');
                data.forEach(m =>
                    $('#manager_id').append(`<option value="${m.id}">${m.name}</option>`)
                );
                if (savedManager) $('#manager_id').val(savedManager);
            })
            .fail(() => {
                $('#manager_id').html('<option>Error loading managers</option>');
            });
    });

    if ($('#company_id').val()) {
        $('#company_id').trigger('change');
    }

    /* ================== LOCATIONS ================== */
    $.get('/api/locations/countries')
        .done(function (data) {
            data.forEach(c => {
                $('#country').append(`<option value="${c.name}" ${c.name===savedCountry?'selected':''}>${c.name}</option>`);
            });
            if (savedCountry) loadStates(savedCountry);
        });

    $('#country').on('change', function () {
        loadStates($(this).val());
    });

    $('#state').on('change', function () {
        loadCities($(this).val(), $('#country').val());
    });

    function loadStates(country) {
        $('#state').prop('disabled', true).html('<option>Loading...</option>');
        $.get(`/api/locations/states/${encodeURIComponent(country)}`)
            .done(data => {
                $('#state').html('<option value="">Select State</option>');
                data.forEach(s =>
                    $('#state').append(`<option value="${s.state_name}" ${s.state_name===savedState?'selected':''}>${s.state_name}</option>`)
                );
                $('#state').prop('disabled', false);
                if (savedState) loadCities(savedState, country);
            });
    }

    function loadCities(state, country) {
        $('#city').prop('disabled', true).html('<option>Loading...</option>');
        $.get(`/api/locations/cities/${encodeURIComponent(state)}?country=${encodeURIComponent(country)}`)
            .done(data => {
                $('#city').html('<option value="">Select City</option>');
                data.forEach(c =>
                    $('#city').append(`<option value="${c.city_name}" ${c.city_name===savedCity?'selected':''}>${c.city_name}</option>`)
                );
                $('#city').prop('disabled', false);
            });
    }
});
</script>
@endpush
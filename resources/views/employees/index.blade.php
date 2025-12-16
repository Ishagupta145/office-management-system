@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Employees</h2>
        <p class="mt-1 text-sm text-gray-600">Manage all employees in the system</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('employees.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Add New Employee
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white shadow-md rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Filters</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="filter_company" class="block text-sm font-medium text-gray-700 mb-2">Filter by Company</label>
            <select id="filter_company" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">All Companies</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="filter_position" class="block text-sm font-medium text-gray-700 mb-2">Filter by Position</label>
            <select id="filter_position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">All Positions</option>
                @foreach($positions as $position)
                    <option value="{{ $position }}">{{ $position }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- DataTable -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-4">
        <table id="employees-table" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manager</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('employees.index') }}",
            data: function (d) {
                d.company_id = $('#filter_company').val();
                d.position = $('#filter_position').val();
            }
        },
        columns: [
            { data: 'full_name', name: 'first_name' },
            { data: 'email', name: 'email' },
            { data: 'position', name: 'position' },
            { data: 'company_name', name: 'company.name' },
            { data: 'manager_name', name: 'manager.first_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10,
        language: {
            search: "Search employees:",
            lengthMenu: "Show _MENU_ employees per page",
            info: "Showing _START_ to _END_ of _TOTAL_ employees",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });

    // Filter by company
    $('#filter_company').change(function() {
        table.draw();
    });

    // Filter by position
    $('#filter_position').change(function() {
        table.draw();
    });
});
</script>
@endpush
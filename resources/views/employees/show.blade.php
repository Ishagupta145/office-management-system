@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $employee->full_name }}</h2>
            <p class="mt-1 text-sm text-gray-600">Employee Information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('employees.edit', $employee) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Edit Employee
            </a>
            <a href="{{ route('employees.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">First Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->first_name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Last Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->last_name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Email</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->email }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->phone ?? 'N/A' }}</dd>
            </div>
        </dl>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Job Information</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Position</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->position }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Salary</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @if($employee->salary)
                        ${{ number_format($employee->salary, 2) }}
                    @else
                        N/A
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Company</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <a href="{{ route('companies.show', $employee->company) }}" class="text-blue-600 hover:text-blue-800">
                        {{ $employee->company->name }}
                    </a>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Manager</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @if($employee->manager)
                        <a href="{{ route('employees.show', $employee->manager) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $employee->manager->full_name }}
                        </a>
                    @else
                        No Manager
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    {{ $employee->hire_date ? $employee->hire_date->format('F d, Y') : 'N/A' }}
                </dd>
            </div>
        </dl>
    </div>

    @if($employee->country || $employee->state || $employee->city)
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Location</h3>
        <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Country</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->country ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">State</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->state ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">City</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $employee->city ?? 'N/A' }}</dd>
            </div>
        </dl>
    </div>
    @endif

    @if($employee->subordinates->count() > 0)
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Direct Reports ({{ $employee->subordinates->count() }})</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($employee->subordinates as $subordinate)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $subordinate->full_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $subordinate->position }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $subordinate->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('employees.show', $subordinate) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
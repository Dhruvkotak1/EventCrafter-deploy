@extends('components.adminLayout')

@section('title', 'Manage Users')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">👤 Manage Users</h1>

    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Customers --}}
        <div class="bg-base-200 rounded-xl p-4 shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-info">Customers</h2>
                <span class="text-sm text-gray-500">🔒 Blocked: {{ $blockedCustomersCount }}</span>
            </div>

            {{-- Search Customers --}}
            <div class="flex gap-2 mb-4">
                <input type="text" id="customerSearch" name="customer_search" value="{{ request('customer_search') }}"
                    placeholder="Search by ID or name..." class="input input-bordered w-full" onkeypress="if(event.key === 'Enter') filterTable('customerTable', this.value)" />
                <button class="btn btn-primary" onclick="filterTable('customerTable', document.getElementById('customerSearch').value)">Sort</button>
            </div>

            <div class="overflow-auto max-h-96 rounded-xl">
                <table class="table table-zebra w-full text-sm">
                    <thead class="sticky top-0 bg-base-300 z-10">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="customerTable">
                        @forelse ($customers as $customer)
                            <tr>
                                <td class="user-id">{{ $customer->id }}</td>
                                <td class="user-name">{{ $customer->name }}</td>
                                <td class="flex flex-wrap gap-2">
                                    <button class="btn btn-sm btn-info tooltip" data-tip="View Info" onclick="showInfoModal({{ $customer->id }})">View</button>
                                    <button class="btn btn-sm {{ $customer->status === 'blocked' ? 'btn-success' : 'btn-error' }} tooltip" data-tip="{{ $customer->status === 'blocked' ? 'Unblock' : 'Block' }}"
                                        onclick="confirmToggle('{{ route('admin.users.toggle', $customer->id) }}', '{{ $customer->status === 'blocked' ? 'Unblock' : 'Block' }}')">
                                        {{ $customer->status === 'blocked' ? 'Unblock' : 'Block' }}
                                    </button>
                                </td>
                            </tr>

                            {{-- Info Modal --}}
                            <dialog id="infoModal-{{ $customer->id }}" class="modal">
                                <div class="modal-box">
                                    <h3 class="font-bold text-lg mb-2">Customer Details</h3>
                                    <p><strong>Name:</strong> {{ $customer->name }}</p>
                                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                                    <p><strong>Joining Date:</strong> {{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</p>
                                    <p><strong>Status:</strong>
                                        <span class="badge {{ $customer->status === 'blocked' ? 'badge-error' : 'badge-success' }}">
                                            {{ ucfirst($customer->status) }}
                                        </span>
                                    </p>
                                    <div class="modal-action">
                                        <form method="dialog">
                                            <button class="btn">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        @empty
                            <tr><td colspan="3" class="text-center text-gray-400">No customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Organizers --}}
        <div class="bg-base-200 rounded-xl p-4 shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-secondary">Organizers</h2>
                <span class="text-sm text-gray-500">🔒 Blocked: {{ $blockedOrganizersCount }}</span>
            </div>

            {{-- Search Organizers --}}
            <div class="flex gap-2 mb-4">
                <input type="text" id="organizerSearch" name="organizer_search" value="{{ request('organizer_search') }}"
                    placeholder="Search by ID or name..." class="input input-bordered w-full" onkeypress="if(event.key === 'Enter') filterTable('organizerTable', this.value)" />
                <button class="btn btn-secondary" onclick="filterTable('organizerTable', document.getElementById('organizerSearch').value)">Sort</button>
            </div>

            <div class="overflow-auto max-h-96 rounded-xl">
                <table class="table table-zebra w-full text-sm">
                    <thead class="sticky top-0 bg-base-300 z-10">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="organizerTable">
                        @forelse ($organizers as $organizer)
                            <tr>
                                <td class="user-id">{{ $organizer->id }}</td>
                                <td class="user-name">{{ $organizer->name }}</td>
                                <td class="flex flex-wrap gap-2">
                                    <button class="btn btn-sm btn-info tooltip" data-tip="View Info" onclick="showInfoModal({{ $organizer->id }})">View</button>
                                    <button class="btn btn-sm {{ $organizer->status === 'blocked' ? 'btn-success' : 'btn-error' }} tooltip" data-tip="{{ $organizer->status === 'blocked' ? 'Unblock' : 'Block' }}"
                                        onclick="confirmToggle('{{ route('admin.users.toggle', $organizer->id) }}', '{{ $organizer->status === 'blocked' ? 'Unblock' : 'Block' }}')">
                                        {{ $organizer->status === 'blocked' ? 'Unblock' : 'Block' }}
                                    </button>
                                </td>
                            </tr>

                            {{-- Info Modal --}}
                            <dialog id="infoModal-{{ $organizer->id }}" class="modal">
                                <div class="modal-box">
                                    <h3 class="font-bold text-lg mb-2">Organizer Details</h3>
                                    <p><strong>Name:</strong> {{ $organizer->name }}</p>
                                    <p><strong>Email:</strong> {{ $organizer->email }}</p>
                                    <p><strong>Joining Date:</strong> {{ \Carbon\Carbon::parse($organizer->created_at)->format('d M Y') }}</p>                                    <p><strong>Status:</strong>
                                        <span class="badge {{ $organizer->status === 'blocked' ? 'badge-error' : 'badge-success' }}">
                                            {{ ucfirst($organizer->status) }}
                                        </span>
                                    </p>
                                    <div class="modal-action">
                                        <form method="dialog">
                                            <button class="btn">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        @empty
                            <tr><td colspan="3" class="text-center text-gray-400">No organizers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Global Confirmation Modal --}}
<dialog id="confirmModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Are you sure?</h3>
        <p class="py-2">Do you really want to <span id="confirmActionText"></span> this user?</p>
        <div class="modal-action">
            <form id="confirmForm" method="POST">
                @csrf
                @method('PATCH')
                <button class="btn btn-error" type="submit">Yes</button>
            </form>
            <form method="dialog">
                <button class="btn">Cancel</button>
            </form>
        </div>
    </div>
</dialog>

<script>
    function showInfoModal(id) {
        const modal = document.getElementById(`infoModal-${id}`);
        if (modal) modal.showModal();
    }

    function filterTable(tableId, query) {
        const rows = document.querySelectorAll(`#${tableId} tr`);
        rows.forEach(row => {
            const nameCell = row.querySelector('.user-name');
            const idCell = row.querySelector('.user-id');
            if ((nameCell && nameCell.textContent.toLowerCase().includes(query.toLowerCase())) ||
                (idCell && idCell.textContent.includes(query))) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function confirmToggle(actionUrl, actionText) {
        const modal = document.getElementById('confirmModal');
        const form = document.getElementById('confirmForm');
        const actionSpan = document.getElementById('confirmActionText');

        form.action = actionUrl;
        actionSpan.textContent = actionText.toLowerCase();

        modal.showModal();
    }
</script>
@endsection

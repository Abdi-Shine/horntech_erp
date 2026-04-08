@extends('super_admin.layouts.master')
@section('page_title', 'Users')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Users</h4>
        <p class="text-muted mb-0">All users across all tenant companies</p>
    </div>
    <span class="sa-badge sa-badge-blue">{{ $users->total() }} total</span>
</div>

{{-- Filter --}}
<form method="GET" class="mb-4 d-flex gap-2 align-items-center">
    <select name="company_id" class="form-select form-select-sm" style="max-width:220px;" onchange="this.form.submit()">
        <option value="">All Companies</option>
        @foreach($companies as $c)
            <option value="{{ $c->id }}" {{ request('company_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
        @endforeach
    </select>
    @if(request('company_id'))
        <a href="{{ route('host.users') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
    @endif
</form>

<div class="sa-card">
    <table class="sa-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Company</th>
                <th>Role</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:34px;height:34px;font-size:.75rem;background:var(--accent);color:var(--primary-dark);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:.85rem;">{{ $user->name }}</div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $user->company->name ?? '—' }}</td>
                <td>
                    @php
                        $roleColors = [
                            'admin'       => 'sa-badge-blue',
                            'Super Admin' => 'sa-badge-red',
                            'Manager'     => 'sa-badge-green',
                            'Cashier'     => 'sa-badge-yellow',
                        ];
                    @endphp
                    <span class="sa-badge {{ $roleColors[$user->role] ?? 'sa-badge-gray' }}">{{ $user->role }}</span>
                </td>
                <td>{{ $user->created_at->format('d M, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-5 text-muted">No users found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
<div class="mt-4 d-flex justify-content-center">{{ $users->links() }}</div>
@endif
@endsection

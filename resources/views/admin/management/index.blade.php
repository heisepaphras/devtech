@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Management Team</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.management.create') }}">Create Member</a>
            <a class="btn btn-outline-light" href="{{ route('players.management') }}">View Public Page</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Contact</th>
                            <th>Sort</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($managementMembers as $member)
                            <tr>
                                <td>
                                    <strong>{{ $member->full_name }}</strong>
                                    <div class="small text-secondary">/{{ $member->slug }}</div>
                                    @if ($member->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $member->role_title }}</div>
                                    <small class="text-secondary">{{ $member->department ?: 'Management' }}</small>
                                </td>
                                <td>
                                    @if ($member->is_published)
                                        <span class="badge text-bg-success">Published</span>
                                    @else
                                        <span class="badge text-bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">{{ $member->email ?: '-' }}</div>
                                    <div class="small text-secondary">{{ $member->phone ?: '' }}</div>
                                </td>
                                <td>{{ $member->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.management.edit', $member) }}">Edit</a>
                                        <form action="{{ route('admin.management.destroy', $member) }}" method="POST" onsubmit="return confirm('Delete this management member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No management members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $managementMembers->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection

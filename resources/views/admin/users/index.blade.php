@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Users</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th> {{-- optional --}}
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
               <td>
                @if($user->is_admin)
                    <span>Admin</span>
                @else
                    <span>User</span>
                @endif
            </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

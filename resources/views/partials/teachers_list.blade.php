<table class="teacher-table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Password Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($teachers as $teacher)
            <tr>
                <td>{{ $teacher->username }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ ucfirst($teacher->role) }}</td>
                <td>{{ $teacher->must_change_password ? 'Must Change Password' : 'Password Updated' }}</td>
                <td>
                    <a href="{{ route('teachers.show', $teacher->id) }}" class="teacher-action-btn teacher-view-btn">View</a>
                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="teacher-action-btn teacher-edit-btn">Edit</a>
                    <button type="button" class="teacher-action-btn teacher-delete-btn" onclick="deleteTeacher({{ $teacher->id }})">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;">No teachers found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

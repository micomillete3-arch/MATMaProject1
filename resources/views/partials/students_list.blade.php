<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Degree</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($students as $student)
            <tr>
                <td>{{ $student->lname }}, {{ $student->fname }}</td>
                <td>{{ optional($student->degree)->name ?? 'Not set' }}</td>
                <td>{{ optional($student->userAccount)->email ?? 'Not set' }}</td>
                <td>{{ $student->contactno }}</td>
                <td>
                    <a href="{{ route('studentss.show', $student->id) }}" class="btn btn-success">View</a>
                    <a href="{{ route('studentss.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                    <button type="button" class="btn btn-danger" onclick="deleteStudent({{ $student->id }})">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;">No students found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

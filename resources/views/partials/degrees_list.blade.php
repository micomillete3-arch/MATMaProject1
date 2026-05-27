@if ($degrees->isEmpty())
    <p style="text-align:center; margin:0;">No degrees found.</p>
@else
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Degree Name</th>
                <th>Students Using It</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($degrees as $degree)
                <tr>
                    <td>{{ $degree->id }}</td>
                    <td>{{ $degree->name }}</td>
                    <td>{{ $degree->students_count }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('degrees.show', $degree->id) }}" class="action-link view-btn">View</a>
                            <a href="{{ route('degrees.edit', $degree->id) }}" class="action-link edit-btn">Edit</a>
                            @if ($degree->students_count == 0)
                                <button type="button" class="delete-btn" onclick="deleteDegree({{ $degree->id }})">Delete</button>
                            @else
                                <span class="in-use-text">In use</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

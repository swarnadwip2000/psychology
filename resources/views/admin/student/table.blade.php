@if (count($students) > 0)
    @foreach ($students as $key => $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->phone }}</td>
            <td>{{ $student->city }}</td>
            <td>{{ $student->country }}</td>
            <td>{{ $student->address }}</td>
            <td>
                <div class="button-switch">
                    <input type="checkbox" id="switch-orange" class="switch toggle-class" data-id="{{ $student['id'] }}"
                        {{ $student['status'] ? 'checked' : '' }} />
                    <label for="switch-orange" class="lbl-off"></label>
                    <label for="switch-orange" class="lbl-on"></label>
                </div>
            </td>
            <td>
                <div class="edit-1 d-flex align-items-center justify-content-center">
                    <a title="Edit Student" href="{{ route('students.edit', $student->id) }}">
                        <span class="edit-icon"><i class="ph ph-pencil-simple"></i></span></a>
                    <a title="Delete Student" data-route="{{ route('students.delete', $student->id) }}"
                        href="javascipt:void(0);" id="delete"> <span class="trash-icon"><i
                                class="ph ph-trash"></i></span></a>
                </div>
            </td>

        </tr>
    @endforeach
    {{-- pagination --}}
    <tr>
        <td colspan="8">
            <div class="d-flex justify-content-center">
                {!! $students->links() !!}
            </div>
        </td>
    </tr>
    @else
    <tr>
        <td colspan="8" class="text-center">No Data Found</td>
    </tr>
@endif

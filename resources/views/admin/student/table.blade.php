@if (count($students) > 0)
    @foreach ($students as $key => $student)
        <tr>
            <td>{{ $student->name ?? 'N/A' }}</td>
            <td>{{ $student->email ?? 'N/A' }}</td>
            <td>{{ $student->phone ?? 'N/A' }}</td>
            <td>{{ $student->city ? $student->city->name : 'N/A' }}</td>
            <td>{{ $student->country ? $student->country->name : 'N/A' }}</td>
            <td>{{ $student->address ?? 'N/A' }}</td>
            <td>{{ $student->student_age ?? 'N/A' }}</td>
            <td>
                {{-- Display the class name from the config --}}
                {{ config('class.school_class')[$student->student_class] ?? 'N/A' }}
            </td>
            <td>{{ $student->institute_name ?? 'N/A' }}</td>
            <td>
                @php
                    $registerAsLabels = [1 => 'School', 2 => 'College', 3 => 'Other'];
                @endphp
                {{ $registerAsLabels[$student->register_as] ?? 'N/A' }}
            </td>
            <td>
                <div class="button-switch">
                    <input type="checkbox" id="switch-{{ $student->id }}" class="switch toggle-class"
                        data-id="{{ $student->id }}" {{ $student->status ? 'checked' : '' }} />
                    <label for="switch-{{ $student->id }}" class="lbl-off"></label>
                    <label for="switch-{{ $student->id }}" class="lbl-on"></label>
                </div>
            </td>
            <td>
                <div class="edit-1 d-flex align-items-center justify-content-center">
                    <a title="Edit Student" href="{{ route('students.edit', $student->id) }}">
                        <span class="edit-icon"><i class="ph ph-pencil-simple"></i></span>
                    </a>
                    <a title="Delete Student" data-route="{{ route('students.delete', $student->id) }}"
                        href="javascript:void(0);" id="delete">
                        <span class="trash-icon"><i class="ph ph-trash"></i></span>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    {{-- Pagination --}}
    @if ($students->hasPages())
        <tr>
            <td colspan="12">
                <div class="d-flex justify-content-center">
                    {!! $students->links() !!}
                </div>
            </td>
        </tr>
    @endif
@else
    <tr>
        <td colspan="12" class="text-center">No Data Found</td>
    </tr>
@endif

@if (count($faculty) > 0)
    @foreach ($faculty as $key => $faculties)
        <tr>
            <td>{{ $faculties->name ?? 'N/A' }}</td>
            <td>{{ $faculties->email ?? 'N/A' }}</td>
            <td>{{ $faculties->phone ?? 'N/A' }}</td>
            <td>{{ $faculties->city ? $faculties->city->name : 'N/A' }}</td>
            <td>{{ $faculties->country ? $faculties->country->name : 'N/A' }}</td>
            <td>{{ $faculties->address ?? 'N/A' }}</td>

            <td>
                {{-- Display the class name from the config --}}
                {{ config('class.fuclaty_degree')[$faculties->degree] ?? 'N/A' }}
            </td>

            {{--  <td>
                @php
                    $registerAsLabels = [1 => 'School', 2 => 'College', 3 => 'Other'];
                @endphp
                {{ $registerAsLabels[$student->register_as] ?? 'N/A' }}
            </td>  --}}
            <td>
                <div class="button-switch">
                    <input type="checkbox" id="switch-{{ $faculties->id }}" class="switch toggle-class"
                        data-id="{{ $faculties->id }}" {{ $faculties->status ? 'checked' : '' }} />
                    <label for="switch-{{ $faculties->id }}" class="lbl-off"></label>
                    <label for="switch-{{ $faculties->id }}" class="lbl-on"></label>
                </div>
            </td>
            <td>
                <div class="edit-1 d-flex align-items-center justify-content-center">
                    <a title="Edit Faculty" href="{{ route('faculty.edit', $faculties->id) }}">
                        <span class="edit-icon"><i class="ph ph-pencil-simple"></i></span>
                    </a>
                    <a title="Delete Faculty" data-route="{{ route('faculty.delete', $faculties->id) }}"
                        href="javascript:void(0);" id="delete">
                        <span class="trash-icon"><i class="ph ph-trash"></i></span>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    {{-- Pagination --}}
    @if ($faculty->hasPages())
        <tr>
            <td colspan="12">
                <div class="d-flex justify-content-center">
                    {!! $faculty->links() !!}
                </div>
            </td>
        </tr>
    @endif
@else
    <tr>
        <td colspan="12" class="text-center">No Data Found</td>
    </tr>
@endif

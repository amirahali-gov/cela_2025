
<hr>

<div class="h5 modal-title mb-3">
    <h4 class="mt-2">
        <div>{{ $title }}</div>
    </h4>
    <h6>Cycle 3 Applications - August 2025</h6>
</div>


@if (count($applications) == 0 || empty($applications))
    <div class="position-relative form-group d-flex justify-content-center">
        <i>No applicants</i>
    </div>
@else
    <div class="table-responsive">
        
        <table class="table table-hover table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Nominee Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>City/Town</th>
            </tr>
            <tbody>

                @foreach ($applications as $application)
                    <tr class="cursor" onClick="window.location.href='{{ route('profile', $application->APL_ID) }}'">
                        <td>{{ $application->APL_ID }}</td>
                        <td>{{ $application->APL_FName }} {{ $application->APL_Mname }}
                            {{ $application->APL_LName }}</td>
                        <td>{{ $application->APL_PPhone }} <br>
                            {{ $application->APL_APhone }}</td>
                        <td>{{ $application->APL_Email }}</td>
                        <td>{{ $application->APL_Address_3 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($title != 'Duplicate Applications')
        <div class="d-flex justify-content-center">
            {{ $applications->links() }}
        </div>
    @endif
@endif

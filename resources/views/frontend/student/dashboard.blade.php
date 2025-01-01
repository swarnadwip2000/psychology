@extends('layouts.student_app')
@section('content')
<section class="dshboard p-3" style="height: 700px">
    <div class="dshboard-contain">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header d-flex justify-content-between">
                          <div class="header-title">
                            <h4 class="card-title">Upcoming Schedule</h4>
                          </div>
                      </div>
                      <div class="card-body table-fixed p-0">
                        <div class="table-responsive mt-4">
                            <table id="basic-table" class="table table-striped mb-0" role="grid">
                              <thead>
                                  <tr>
                                    <th>Faculty Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Meeting Id</th>
                                    <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($teacher as $var)
                                  <tr>
                                    <td>
                                        {{ $var -> teacher_name }}
                                    </td>
                                    <td>
                                        {{ $var-> date }}
                                    </td>
                                    <td> {{ $var-> time }}</td>
                                    <td> {{ $var -> zoom_id??"N/A" }} </td>
                                    <td><a href="{{ route('front.live_class', ['meeting_id' => $var -> zoom_id]) }}" class="btn btn-success">{{ $var -> zoom_id?'Join Now':'Not Started'}}</a></td>
                                  </tr>
                                @endforeach

                              </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('script')
@endsection

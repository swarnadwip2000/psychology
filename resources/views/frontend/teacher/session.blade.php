@extends('frontend.layouts.teacher_app')
@section('title')
    {{ ucwords(str_replace('_', ' ', env('APP_NAME'))) }}
@endsection
@section('content')
    <section class="dshboard p-3"  style="height: 700px">
        <div class="dshboard-contain">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          <div class="card-header d-flex justify-content-between">
                              <div class="header-title">
                                <h4 class="card-title">My upcoming Slots (EST time zone)</h4>
                              </div>

                              <div><span class="">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                                    Add New
                                  </button>
                            </span></div>

                          </div>
                          <div class="card-body table-fixed p-0">
                            <div class="table-responsive">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                  <thead>
                                      <tr>
                                        <th>Topic</th>
                                        <th>Date (mm-dd-yyy)</th>
                                        <th>Slot</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($slots as $val)
                                      <tr>
                                        <td>
                                            {{$val->topic ?? ''}}
                                        </td>
                                        <td>
                                            {{ date('m-d-Y', strtotime($val->slot_date)) }}
                                        </td>
                                        <td> {{ date('H:i', strtotime($val->slot_time))  }}</td>

                                        <td><a href="{{ route('delete_teacher_session', ['id'=> $val->id]) }}">Delete</a></td>

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


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Manage Slot</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('add_teacher_session') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="formGroupExampleInput">Topic</label>
                            <input type="text" name="topic" id="topic" class="form-control" required/>
                          </div>
                          <div class="col">
                            <label for="formGroupExampleInput">Date</label>
                            <input
                                type="date"
                                name="slot_date"
                                id="slot_date"
                                class="form-control"
                                required
                                min="{{ date('Y-m-d') }}"
                            />
                        </div>
                      <div class="col">
                        <label for="formGroupExampleInput">Time</label>
                        <input type="time" name="slot_time" id="slot_time" class="form-control" required/>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="save" id="save" value="Save" />
                      </div>
                  </form>
            </div>

          </div>
        </div>
    </div>

@endsection

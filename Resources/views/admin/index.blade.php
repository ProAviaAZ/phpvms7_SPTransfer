@extends('sptransfer::layouts.admin')
@section('title', 'HUB Transfer')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card border-blue-bottom">
        <div class="content">
          <div class="row">
            <form method="POST" action="{{ route('admin.sptransfer.storeSettings') }}">
              @csrf
              <div class="col-lg-12">
                <span style="float:right"><button type="submit" class="btn btn-success">Save</button></span>
                <h5>Hub Transfer Settings</h5>
                <div class="content table-responsive table-full-width">
                  <div class="row">
                    <table class="table table-hover table-responsive" id="spsettings">
                      <tbody>
                        <tr>
                          <td>
                            <p>Price per request</p>
                            <p style="float:left; margin-right: 10px; margin-left: 2px;"><i class="fas fa-info-circle text-primary"></i> The amount the pilot gets charged for every request (0 = disabled)</p>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="sp_price" step="1" min="0" max="100000" placeholder="0" value="{{ $settings->price }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Limit per request</p>
                            <p style="float:left; margin-right: 10px; margin-left: 2px;"><i class="fas fa-info-circle text-primary"></i> The limit in days the pilot has to wait until he can make another request (0 = disabled)</p>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="sp_days" step="1" min="0" max="1000" placeholder="0" value="{{ $settings->limit }}">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card border-blue-bottom">
        <div class="content">
          <div class="row">
            <div class="col-lg-12">
              <h5>Hub Transfer Requests</h5>
              <div class="row">
                <table class="table table-hover table-responsive" id="sptransfer">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th class="text-center">Current</th>
                      <th class="text-center">Request</th>
                      <th>Reason</th>
                      <th class="text-right">Date</th>
                      <th class="text-right">Status</th>
                      <th class="text-right">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($requests as $request)
                    <tr>
                      <td>{{ $request->id }}</td>
                      <td><a href="{{ route('admin.users.edit', [$request->user_id]) }}">{{ $request->user->name }}</a></td>
                      <td class="text-center">{{ $request->hub_initial_id }}</td>
                      <td class="text-center">{{ $request->hub_request_id }}</td>
                      <td style="word-break: break-word">{{ $request->reason }}</td>
                      <td class="text-right">{{ $request->created_at->format('d. F Y - H:i') }} UTC</td>
                      <td class="text-right">
                        @if($request->state === 0)
                          <span class="label label-default">{{ $request->statusLabel }}</span>
                        @elseif($request->state === 1)
                          <span class="label label-success">{{ $request->statusLabel }}</span>
                        @elseif($request->state === 2)
                          <span class="label label-warning">{{ $request->statusLabel }}</span>
                        @endif
                      </td>
                      <td class="text-right">
                        <form method="POST" action="{{ route('admin.sptransfer.update') }}" style="display:inline;">
                          @csrf
                          <input type="hidden" name="id" value="{{ $request->id }}">
                          <button type="submit" name="decision" value="ack" class="btn btn-success">Approve</button>
                          <button type="submit" name="decision" value="rej" class="btn btn-warning">Reject</button>
                          <button type="submit" name="decision" value="del" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            {{ $requests->withQueryString()->links('admin.pagination.default') }}
          </div>
        </div>
      </div>
      <p class="text-center">Crafted with <i class="fas fa-heart text-danger"></i> by <a href="https://github.com/PaintSplasher/phpvms7_sptransfer" target="_blank">Sass-Projects</p>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app', ['activePage' => 'User-Management', 'titlePage' => __('User List')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Users</h4>
              <p class="card-category"> Here you can manage users</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form method="post" action="{{ route('user.search') }}">
                    @csrf
                    <input type="text" name="search" class="col-md-2" placeholder="Search...">
                    <button type="submit" class="btn btn-white btn-round btn-just-icon btn-success">
                      <i class="material-icons">search</i>
                      <div class="ripple-container"></div>
                    </button>
                    <a data-toggle = "modal"  style="float:right;color:white" data-target = "#add_user" class="btn btn-sm btn-primary">Add User</a>
                  </form>         
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
                        Name
                    </th>
                    <th>
                      Email
                    </th>
                    <th>
                      Creation date
                    </th>
                    <th class="text-right">
                      Actions
                    </th>
                  </tr></thead>
                  <tbody>
                      @foreach($users as $user)
                        <tr>
                          <td>{{$user->name}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{$user->created_at}}</td>
                          <td class="td-actions text-right">
                            <form method="post" action="{{ route('user.destroy', $user->id) }}">
                              <a rel="tooltip" class="btn btn-success btn-link" data-target = "#update_user" onclick="update_user({{$user}})" data-original-title="" title="">
                                <i class="material-icons">edit</i>
                              </a>
                              @csrf
                              @method('DELETE')
                              <a rel="tooltip" data-original-title="" title="" class="btn btn-success btn-link" class="btn btn-danger btn-fab btn-fab-mini btn-round"  onclick="confirm('{{ __('Are you sure you want to delete?') }}') ? this.parentElement.submit() : ''">
                                <i class="material-icons">delete</i>
                              </a>
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
    </div>
  </div>
</div>

<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="ml-auto mr-auto w-75">
        <form class="form" method="post" action="{{ route('user.store') }}">
          @csrf

          <div class="card card-login card-hidden mb-3">
            <div class="card-body ">
              <p class="card-description text-center">{{ __('Add User') }}</p>
              <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="material-icons">face</i>
                    </span>
                  </div>
                  <input type="text" name="name" class="form-control" placeholder="{{ __('Name...') }}" value="{{ old('name') }}" required>
                </div>
                @if ($errors->has('name'))
                  <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                    <strong>{{ $errors->first('name') }}</strong>
                  </div>
                @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">email</i>
                    </span>
                  </div>
                  <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
                </div>
                @if ($errors->has('email'))
                  <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                    <strong>{{ $errors->first('email') }}</strong>
                  </div>
                @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" required>
                </div>
                @if ($errors->has('password'))
                  <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                    <strong>{{ $errors->first('password') }}</strong>
                  </div>
                @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password...') }}" required>
                </div>
                @if ($errors->has('password_confirmation'))
                  <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="card-footer justify-content-center">
              <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Add User') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>  

<!-- update user -->

<div class="modal fade" id="update_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="ml-auto mr-auto w-75">
        <form class="form" method="post" action="{{ route('user.store') }}">
          @csrf

          <div class="card card-login card-hidden mb-3">
            <div class="card-body ">
              <p class="card-description text-center">{{ __('Add User') }}</p>
              <input type="hidden" id="userId" name='id' />
              <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="material-icons">face</i>
                    </span>
                  </div>
                  <input type="text" name="name" id="userName" class="form-control" placeholder="{{ __('Name...') }}" value="{{ old('name') }}" required>
                </div>
                @if ($errors->has('name'))
                  <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                    <strong>{{ $errors->first('name') }}</strong>
                  </div>
                @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">email</i>
                    </span>
                  </div>
                  <input type="email" name="email" id="userEmail" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
                </div>
                @if ($errors->has('email'))
                  <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                    <strong>{{ $errors->first('email') }}</strong>
                  </div>
                @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('New Password...') }}" required>
                </div>
                @if ($errors->has('password'))
                  <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                    <strong>{{ $errors->first('password') }}</strong>
                  </div>
                @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password...') }}" required>
                </div>
                @if ($errors->has('password_confirmation'))
                  <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="card-footer justify-content-center">
              <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Update User') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>  

@endsection


@extends('layouts.app')
@section('styles')
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="row">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Success!</h4>
                            <p>{{ Session::get('success') }}</p>

                            <button type="button" class="close" data-dismiss="alert aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (Session::has('errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Error!</h4>
                            <p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </p>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="container py-3">
                        <div class="modal" tabindex="-1" role="dialog" id="editCategoryModal">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Edit Category</h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form action="" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">
                                  <div class="form-group">
                                    <input type="text" name="name" class="form-control" value="" placeholder="Category Name" required>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </div>
                              </form>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">

                              <div class="card">
                                <div class="card-header">
                                  <h3>Categories</h3>
                                </div>
                                <div class="card-body">
                                  <ul class="list-group">
                                    @foreach ($categories as $category)
                                      <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                          {{ $category->name }}

                                          <div class="button-group d-flex">
                                            <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</button>

                                            <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                              @csrf
                                              @method('DELETE')

                                              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                          </div>
                                        </div>

                                        @if ($category->children)
                                          <ul class="list-group mt-2">
                                            @foreach ($category->children as $child)
                                              <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                  {{ $child->name }}

                                                  <div class="button-group d-flex">
                                                    <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $child->id }}" data-name="{{ $child->name }}">Edit</button>

                                                    <form action="{{ route('category.destroy', $child->id) }}" method="POST">
                                                      @csrf
                                                      @method('DELETE')

                                                      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                  </div>
                                                </div>
                                              </li>
                                            @endforeach
                                          </ul>
                                        @endif
                                      </li>
                                    @endforeach
                                  </ul>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="card">
                                <div class="card-header">
                                  <h3>Create Category</h3>
                                </div>

                                <div class="card-body">
                                  <form action="{{ route('category.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                      <select class="form-control" name="parent_id">
                                        <option value="">Select Parent Category</option>

                                        @foreach ($categories as $category)
                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>

                                    <div class="form-group">
                                      <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Category Name" required>
                                    </div>

                                    <div class="form-group">
                                      <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <!-- Scripts -->
        <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
        <script type="text/javascript">
            $(document).on('click','.close', function(){
                $('.alert-success').hide();
            })
          $('.edit-category').on('click', function() {
            console.log('Clicked');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var url = "{{ url('category') }}/" + id;

            $('#editCategoryModal form').attr('action', url);
            $('#editCategoryModal form input[name="name"]').val(name);
          });
        </script>
@endsection

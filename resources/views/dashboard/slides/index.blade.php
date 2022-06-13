@extends('dashboard.layout.index')

@section('content')
<style>
    .table-longText{
        width: 65%;
    }
    .titleSection{
        width: 15%;
        -webkit-line-clamp: 2;
    }
    .thumbnail{
        width: 100px;
    }
</style>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header w-100">
                                            <div class="card-title">
                                                <p class="mb-0">Slides</p>
                                            </div>
                                            <div class="section-right">
                                                <a href="{{ route('dashboard.slides.create') }}" class="btn btn-secondary">Create</a>
                                            </div>
                                            <hr class="w-100 my-1">
                                        </div>
                            <div class="card-body card-dashboard">
                                {{-- <p class="card-text">
                                    There is 40 doctor added
                                </p> --}}
                             
                                <div class="table-responsive">
                                    @can('See Slide')
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Title En</th>
                                                    <th>Title Ar</th>
                                                    <th>Description En</th>
                                                    <th>Description Ar</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                        <tr>
                                                         
                                                            <td><img class="thumbnail" src="{{ $item->image }}"></td>
                                                            <td>{{ $item->getTranslations('title')['en'] }}</td>
                                                            <td>{{ $item->getTranslations('title')['ar'] }}</td>
                                                            <td>{{ $item->getTranslations('description')['en'] }}</td>
                                                            <td>{{ $item->getTranslations('description')['ar'] }}</td>
                                                            
                                                            <td>
                                                                @can('Edit Slide')
                                                                    <a class="btn btn-secondary" href="{{ route('dashboard.slides.edit',$item->id) }}">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('Delete Slide')
                                                                    <button class="btn btn-danger" onclick="openModal('{{ $item->id }}','{{ $item->getTranslations('title')['en'] }}')">
                                                                        <i class="bx bx-trash buttonIcon"></i>
                                                                    </button>
                                                                @endcan

                                                            </td>
                                                        
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endcan
                                </div>
                            </div>
                            @can('See Slide')
                            {{ $data->links() }}
                            @endcan
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="slideModel" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Slide!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="slideName"></span>' slide ?</p>
            </div>
            <div class="modal-footer">
              <button onclick="deleteApi()" type="button" class="btn btn-primary">Delete</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')

<script>
    let role_id = null;

    function openModal(id,name)
    {
        role_id = id;
        $('#slideName').empty();
        $('#slideName').append(name);
        $('#slideModel').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.slides.delete",":id") }}';
        let updatedUrl = url.replace(':id',role_id);
        $.ajax({
            type:'GET',
            url:updatedUrl,
            success:(res)=>{
                if(!res.err)
                {
                    location.reload();
                }
              
            },
            error:(err)=>{
                console.log('delete faq Error')
            }
        });
    }
</script>

@endsection

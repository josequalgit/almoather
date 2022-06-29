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
                            <div class="card-header pb-0">
                                <div class="card-title">
                                    <p class="mb-0">Faq</p>
                                </div>
                                
                                <div class="section-right">
                                    <a href="{{ route('dashboard.faqs.create') }}" class="btn btn-secondary">Create</a>
                                </div>
                                <hr class="w-100 my-1">
                            <div class="w-100 card-dashboard">                             
                                <div class="table-responsive">
                                    @can('See Faq')
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                        <tr>
                                                         
                                                            <td>{{ $item->getTranslation('question','ar') }}</td>
                                                            <td>{{ $item->getTranslation('answer','ar') }}</td>
                                                            
                                                            <td>
                                                                @can('Edit Faq')
                                                                    <a class="btn btn-secondary" href="{{ route('dashboard.faqs.edit',$item->id) }}">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('Delete Faq')
                                                                    <button class="btn btn-danger" onclick="openModal('{{ $item->id }}','{{ $item->question }}')">
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
                            {{-- @can('See Faq')
                            {{ $data->links() }}
                            @endcan --}}
                            @can('See Faq')
                            <div class="p-1">
                                {{ $data->links('pagination::bootstrap-5') }}
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="faqModel" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Faq!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="faqName"></span>' faq ?</p>
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
        $('#faqName').empty();
        $('#faqName').append(name);
        $('#faqModel').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.faqs.delete",":id") }}';
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

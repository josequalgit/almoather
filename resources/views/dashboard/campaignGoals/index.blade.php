@extends('dashboard.layout.index')

@section('content')

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
                                    <p class="mb-0">Campaign Goal</p>
                                </div>
                                
                                <div class="section-right">
                                    <a href="{{ route('dashboard.campaignGoals.create') }}" class="btn btn-secondary">Create</a>
                                </div>
                                <hr class="w-100 my-1">
                            </div>
                            
                            <div class="card-body card-dashboard">                             
                                <div class="table-responsive">
                                    @can('See Category')
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Text Ar</th>
                                                    <th>Text En</th>
                                                    <th>Profitable</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                        <tr>
                                                            @if($item->getTranslations('title'))
                                                            
                                                             <td>{{ $item->getTranslations('title')['ar'] }}</td>
                                                             <td>{{ $item->getTranslations('title')['en'] }}</td>
                                                             <td>
                                                                <i class="money-icon bx bx-{{ $item->profitable?'money':'donate-heart' }}" data-icon="desktop"></i>
                                                            </td>
                                                             
                                                             <td>
                                                                 @can('Edit Campaign Goal')
                                                                     <a class="btn btn-secondary" href="{{ route('dashboard.campaignGoals.edit',$item->id) }}">
                                                                         <i class="bx bx-edit"></i>
                                                                     </a>
                                                                 @endcan
                                                                 @can('Delete Campaign Goal')
                                                                     <button class="btn btn-danger" onclick="openModal('{{ $item->id }}','{{ $item->en }}')">
                                                                         <i class="bx bx-trash buttonIcon"></i>
                                                                     </button>
                                                                 @endcan
 
                                                             </td>
                                                            @endif
                                                        
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endcan
                                </div>
                            </div>
                            {{-- @can('See Category')
                            {{ $data->links() }}
                            @endcan --}}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Campaign Goal!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="CampaignGoal"></span>' Campaign Goal ?</p>
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
        $('#CampaignGoal').empty();
        $('#CampaignGoal').append(name);
        $('#deleteModal').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.campaignGoals.delete",":id") }}';
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
            error:(res)=>{
                 alert(res.responseJSON.err)
                 $('#deleteModal').modal('toggle');
                console.log('error response: ',res.responseJSON.err)
            }
        });
    }
</script>

@endsection

    <div class="table-responsive">
        <input class="form-control mb-3" type="text" wire:model="search" placeholder="Search" aria-label="search">
        <table class="table table-striped table-responsive-lg align-middle">
            <thead>
                <tr class="align-middle">
                    <th scope="col">Username</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $data)
                <tr>
                    <th>{{$data->username}}</th>
                    <th>
                        @if($data->role != 'admin')
                        <form method="post" action="{{route('user.destroy',$data->id)}}">
                            @method('delete')
                            @csrf
                            <button type="submit" style="background-color: transparent; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line></svg>

                            </button>
                        </form>
                        @endif
                    </th>
                </tr>
                @endforeach

            </tbody>
        </table>
        <div class="text-end">
            {{ $users->links() }}
        </div>
    </div>

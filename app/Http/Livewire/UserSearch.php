<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use App\Models\User;
use Livewire\Component;

class UserSearch extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.user-search', [
            'users' => User::where('username', 'like', '%' . $this->search . '%')->paginate(5)
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
}

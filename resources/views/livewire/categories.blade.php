<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form>
        <div class=" add-input">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Name" wire:model="name.0">
                        @error('name.0') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="email" class="form-control" wire:model="email.0" placeholder="Enter Email">
                        @error('email.0') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <x-link wire:click.prevent="add({{$i}})">Add</x-link>
                </div>
            </div>
        </div>

        @foreach($inputs as $key => $value)
            <div class=" add-input">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Name" wire:model="name.{{ $value }}">
                            @error('name.'.$value) <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="email" class="form-control" wire:model="email.{{ $value }}" placeholder="Enter Email">
                            @error('email.'.$value) <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <x-link class="btn btn-danger btn-sm" wire:click.prevent="remove({{$key}})">remove</x-link>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-12">
                <x-link wire:click.prevent="store()" class="btn btn-success btn-sm">Save</x-link>
            </div>
        </div>
    </form>
</div>

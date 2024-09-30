@extends('back.layouts.layout')
@section('title','All Contact')
@section('content')


@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>email</th>
                    <th>subject</th>
                    <th>message</th>
                    <th>Create Date</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>email</th>
                    <th>subject</th>
                    <th>message</th>
                    <th>Create Date</th>
                    <th>Options</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($contacts as $contact)
                <tr>
                    <td>{{$contact->name}}</td>
                    <td>{{$contact->email}}</td>
                    <td>{{$contact->subject}}</td>
                    <td>{{$contact->message}}</td>
                    <td>{{$contact->created_at}}</td>
                    <td>
                        <a href="{{route('admin.contact.index',$contact->contact_id)}}" title="Edit" class="btn btn-sm btn-primary"><i class="fa fa-pen px-1"></i></a>
                        {{-- <a href="{{route('admin.contact.deleteContact', $contact->contact_id) }}" title="Delete" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contact?');">
                            <i class="fa fa-trash px-1"></i>
                        </a> --}}
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
</div>


@endsection
@section('headScript')
<style>
    /* The switch - the box around the slider */
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* The slider */
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    
</style>
@endsection

@section('scipt')
    <script>
        $(function() {
            $('.switch').change(function(){
            id = $(this)[0].getAttribute('contact-id');
            })
    </script>
@endsection
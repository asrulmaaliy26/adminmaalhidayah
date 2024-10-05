@extends('back.layouts.layout')
@section('title', 'All Contact')
@section('content')


    @if (session('status'))
        <div class="row">{{-- Alert --}}
            <div class="col-12 text-center">
                <div class="alert alert-success mt-4">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
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
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->message }}</td>
                            <td>{{ $contact->created_at }}</td>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <!-- Tombol Edit di Kiri -->

                                    <button class="btn btn-secondary float-end" data-bs-toggle="modal"
                                        data-bs-target="#replyModal{{ $contact->contact_id }}"><i
                                            class="fa fa-pen px-1"></i></button>

                                    <!-- Tombol Delete di Kanan -->
                                    <form action="{{ route('admin.contacts.delete', $contact->contact_id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash px-1"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal untuk balas -->
                        <div class="modal fade" id="replyModal{{ $contact->contact_id }}" tabindex="-1"
                            aria-labelledby="replyModalLabel{{ $contact->contact_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="replyModalLabel{{ $contact->contact_id }}">Balas Pesan ke
                                            {{ $contact->email }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.contacts.reply', $contact->contact_id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="replyMessage{{ $contact->contact_id }}" class="form-label">Balas
                                                    Pesan</label>
                                                <textarea class="form-control" id="replyMessage{{ $contact->contact_id }}" name="replyMessage" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
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
                    $('.switch').change(function() {
                        id = $(this)[0].getAttribute('contact-id');
                    })
    </script>
@endsection

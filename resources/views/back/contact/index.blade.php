@extends('back.layouts.layout')
@section('title', 'All Contact')

@section('content')
    @if (session('status'))
        <div class="row">
            {{-- Alert --}}
            <div class="col-12 text-center">
                <div class="alert alert-success mt-4">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-end">
        <button class="btn btn-primary mb-2">
            <a href="https://mail.google.com/mail/#sent" class="text-light" style="text-decoration: none;" target="_blank">Gmail</a>
        </button>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            {{-- Tabel pertama --}}
            @include('back.contact.contact_table', ['contacts' => $contacts, 'tableId' => 'datatablesSimple'])
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            {{-- Tabel kedua --}}
            @include('back.contact.kunjungan_table', ['kunjungan' => $kunjungan, 'tableId' => 'datatablesSimpleSecond'])
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
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
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
                const id = $(this).attr('contact-id');
                console.log('Switch toggled for contact ID:', id);
            });
        });

        $(document).ready(function() {
            // Inisialisasi DataTables untuk tabel pertama
            $('#datatablesSimple').DataTable();

            // Inisialisasi DataTables untuk tabel kedua
            $('#datatablesSimpleSecond').DataTable();
        });
    </script>
@endsection

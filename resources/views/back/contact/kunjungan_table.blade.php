
<table id="{{ $tableId }}" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Penanggung Jawab</th>
            <th>Lembaga</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Nomor</th>
            <th>Jumlah Guru</th>
            <th>Jumlah Siswa</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Create Date</th>
            <th>Options</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Penanggung Jawab</th>
            <th>Lembaga</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Nomor</th>
            <th>Jumlah Guru</th>
            <th>Jumlah Siswa</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Create Date</th>
            <th>Options</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($kunjungan as $contact)
            @if ($contact->pendidikan == 'kunjungan')
            <tr>
                <td>{{ $contact->penanggungJawab }}</td>
                <td>{{ $contact->lembaga }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->subject }}</td>
                <td>{{ $contact->nomor }}</td>
                <td>{{ $contact->jumlahGuru }}</td>
                <td>{{ $contact->jumlahSiswa }}</td>
                <td>{{ $contact->tanggal }}</td>
                <td>{{ $contact->keterangan }}</td>
                <td>{{ $contact->status }}</td>
                <td>{{ $contact->created_at }}</td>
                <td>
                    <div class="d-flex justify-content-around">
                        <!-- Tombol Preview -->
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#previewKunjunganModal{{ $contact->contact_id }}">
                            <i class="fa fa-eye px-1"></i>
                        </button>

                        <button class="btn btn-secondary float-end" data-bs-toggle="modal"
                            data-bs-target="#replyKunjunganModal{{ $contact->contact_id }}"><i
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


            <!-- Modal untuk preview message -->
            <div class="modal fade" id="previewKunjunganModal{{ $contact->contact_id }}" tabindex="-1"
                aria-labelledby="previewKunjunganModalLabel{{ $contact->contact_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewKunjunganModalLabel{{ $contact->contact_id }}">
                                Pesan dari {{ $contact->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{!! nl2br(e($contact->keterangan)) !!}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal untuk balas -->
            <div class="modal fade" id="replyKunjunganModal{{ $contact->contact_id }}" tabindex="-1"
                aria-labelledby="replyKunjunganModalLabel{{ $contact->contact_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyKunjunganModalLabel{{ $contact->contact_id }}">Balas Pesan
                                ke
                                {{ $contact->email }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.contacts.replykunjungan', $contact->contact_id) }}"
                                method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="replykunjungan{{ $contact->contact_id }}"
                                        class="form-label">Balas
                                        Form Kunjungan</label>
                                    <textarea class="form-control" id="replykunjungan{{ $contact->contact_id }}" name="replykunjungan" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </tbody>
</table>


<table id="{{ $tableId }}" class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Pendidikan</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Create Date</th>
            <th>Options</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Pendidikan</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Create Date</th>
            <th>Options</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->pendidikan }}</td>
                <td>{{ $contact->subject }}</td>
                <td>{!! nl2br(e($contact->message)) !!}</td>
                <td>{{ $contact->created_at }}</td>
                <td>
                    <div class="d-flex justify-content-around">
                        <!-- Tombol Edit di Kiri -->

                        <button class="btn btn-secondary float-end" data-bs-toggle="modal"
                            data-bs-target="#replyContactModal{{ $contact->contact_id }}"><i
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
            <div class="modal fade" id="replyContactModal{{ $contact->contact_id }}" tabindex="-1"
                aria-labelledby="replyContactModalLabel{{ $contact->contact_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyContactModalLabel{{ $contact->contact_id }}">Balas Pesan
                                ke
                                {{ $contact->email }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.contacts.reply', $contact->contact_id) }}"
                                method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="replyMessage{{ $contact->contact_id }}"
                                        class="form-label">Balas
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
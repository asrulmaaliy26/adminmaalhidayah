<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Pesan Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        h1, p {
            color: #333;
        }
        blockquote {
            border-left: 4px solid #ccc;
            padding-left: 10px;
            color: #555;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Yth. {{ $name }},</h1>
    <p>Kami telah menerima pesan mengenai kunjungan anda disini dengan rincian sebagai berikut:</p>
    <blockquote>
        "{{ $originalMessage }}"
    </blockquote>

    <p>Berikut adalah tanggapan resmi kami:</p>
    <blockquote>
        "{{ $replykunjungan }}"
    </blockquote>

    <p>Apabila Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk <a href="https://maalhidayahkauman.sch.id/contact.php">menghubungi kami</a>. Terima kasih atas perhatian dan kerjasama Anda.</p>

    <p>Hormat kami,</p>
    <p><strong>LPI Al Hidayah</strong></p>
    <p>Kauman, Kec. Kauman, Kabupaten Tulungagung, Jawa Timur</p>
    <p><a href="https://wa.me/+6282234639615">(+62)-8223-4639-615</a></p>
</body>
</html>

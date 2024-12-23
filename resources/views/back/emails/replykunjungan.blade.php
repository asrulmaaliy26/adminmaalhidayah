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
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #444;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
        }
        h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            margin: 10px 0;
            color: #555;
        }
        ul {
            padding-left: 20px;
            margin: 10px 0;
        }
        li {
            margin-bottom: 8px;
        }
        blockquote {
            border-left: 4px solid #2ecc71;
            padding-left: 15px;
            color: #666;
            font-style: italic;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
            color: #888;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Halo {{ $penanggungJawab }},</h1>
        <p>Terima kasih atas kunjungan Anda dari <strong>{{ $lembaga }}</strong>.</p>

        <p><strong>Detail Kunjungan:</strong></p>
        <ul>
            <li><strong>Nomor:</strong> {{ $nomor }}</li>
            <li><strong>Jumlah Guru:</strong> {{ $jumlahGuru }}</li>
            <li><strong>Jumlah Siswa:</strong> {{ $jumlahSiswa }}</li>
            <li><strong>Tanggal:</strong> {{ $tanggal }}</li>
            <li><strong>Keterangan:</strong> {{ $keterangan }}</li>
        </ul>

        <p><strong>Balasan Kami:</strong></p>
        <blockquote>{{ $replykunjungan }}</blockquote>

        <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk <a href="https://maalhidayahkauman.sch.id/contact.php">menghubungi kami</a>. Kami akan dengan senang hati membantu Anda.</p>

        <div class="footer">
            <p>Hormat kami,</p>
            <p><strong>LPI Al Hidayah</strong></p>
            <p>Kauman, Kec. Kauman, Kabupaten Tulungagung, Jawa Timur</p>
            <p><a href="https://wa.me/+6282234639615">(+62)-8223-4639-615</a></p>
            <p><a href="https://maalhidayahkauman.sch.id">maalhidayahkauman.sch.id</a></p>
        </div>
    </div>
</body>
</html>

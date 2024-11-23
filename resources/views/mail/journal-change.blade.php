@component('mail::message')
<h2>Pengumuman Pengajuan Jurnal</h2>
<br>
<p>Halo, {{ $details['name'] }}</p>
<p>Kami ingin mengabari bahwasanya jurnal anda dengan : </p>
<ul>
    <li>Nama Projek : {{ $details['project_name'] }}</li>
    <li>Judul : {{ $details['journal_name'] }}</li>
    <li>Tanggal : {{ $details['journal_date'] }}</li>
</ul>
<p>telah berhasil dipindahkan ke bagian diproses.</p>

<p>Mohon ditunggu hingga proses verifikasi jurnal selesai dilaksanakan oleh bagian keuangan.</p>

@component('mail::button', ['url' => 'http://localhost:8000'])
Check Your Journal.
@endcomponent

Thanks,<br>
Kodig.id
@endcomponent

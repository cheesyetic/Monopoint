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
<p>telah mengalami perubahan dan sudah tersimpan ke dalam sistem.</p>

<p>Apabila anda merasa ini bukan perubahan yang anda lakukan, silakan segera lakukan perubahan password pada akun anda.</p>

@component('mail::button', ['url' => 'http://localhost:8000'])
Check Your Journal.
@endcomponent

Thanks,<br>
Kodig.id
@endcomponent

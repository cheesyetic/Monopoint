@component('mail::message')
<h2>Pengumuman Pengajuan Jurnal</h2>
<br>
<p>Halo, {{ $details['name'] }}</p>
<p>Kami ingin mengabari bahwasanya jurnal anda dengan : </p>
<ul>
    <li>ID : {{ $details['journal_id'] }}</li>
    <li>Judul : {{ $details['journal_name'] }}</li>
    <li>Tanggal : {{ $details['journal_date'] }}</li>
</ul>
<p>telah selesai diproses oleh tim keuangan.</p>

<p>Hasil dari proses tim keuangan adalah jurnal anda dinyatakan TERVERIFIKASI. Silakan kunjungi website untuk melihat detil lebih lanjut.</p>

@component('mail::button', ['url' => {{ $details['url'] }}])
Check Your Journal.
@endcomponent

Thanks,<br>
Monopoint
@endcomponent

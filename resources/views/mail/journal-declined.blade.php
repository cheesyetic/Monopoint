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
<p>telah selesai diproses oleh tim keuangan.</p>

<p>Hasil dari proses tim keuangan adalah jurnal anda dinyatakan TERTOLAK. Silakan kunjungi website untuk melihat detil lebih lanjut mengenai alasan penolakan jurnal anda.</p>

@component('mail::button', ['url' => 'http://localhost:8000'])
Check The Detail Now.
@endcomponent

Thanks,<br>
Kodig.id
@endcomponent

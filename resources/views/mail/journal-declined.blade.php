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

<p>Hasil dari proses tim keuangan adalah jurnal anda dinyatakan TERTOLAK. Silakan kunjungi website untuk melihat detil lebih lanjut mengenai alasan penolakan jurnal anda.</p>

@component('mail::button', ['url' => {{ $details['url'] }}])
Check The Detail Now.
@endcomponent

Thanks,<br>
Monopoint
@endcomponent

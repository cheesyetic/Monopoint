@component('mail::message')
<h2>Pengumuman Mengenai Pengajuan Jurnal Baru</h2>
<br>
<p>Halo, {{ $details['name'] }}</p>
<p>Kami ingin mengabari bahwasanya terdapat jurnal dengan detil </p>
<ul>
    <li>ID : {{ $details['journal_id'] }}</li>
    <li>Judul : {{ $details['journal_name'] }}</li>
    <li>Tanggal : {{ $details['journal_date'] }}</li>
    <li>Nama Pengaju : {{ $details['user_name'] }}
</ul>
<p>telah diajukan untuk diproses lebih lanjut.</p>

<p>Mohon bagi tim keuangan untuk segera melakukan proses terhadap pengajuan tersebut.</p>

@component('mail::button', ['url' => 'http://localhost:8000'])
Process Now.
@endcomponent

Thanks,<br>
Monopoint
@endcomponent

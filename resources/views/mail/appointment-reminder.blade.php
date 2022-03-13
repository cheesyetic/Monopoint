@component('mail::message')
<h2>Notifikasi Pengingat Pertemuan</h2>
<br>
<p>Halo, {{ $details['user_name'] }}</p>
<p>Kami ingin mengingatkan bahwasanya anda memiliki jadwal pertemuan dengan detil :</p>
<ul>
    <li>Nama Pertemuan : {{ $details['name'] }}</li>
    <li>Tanggal : {{ $details['date'] }}</li>
</ul>

<p>Dimohon untuk dapat menghadiri pertemuan tersebut sesuai dengan jadwal yang tertera, selamat beraktivitas!</p>

Thanks,<br>
Kodig.id
@endcomponent

@component('mail::message')
# Permintaan Reset Password

<p style="font-size: 16px; color: #333;">Halo,</p>

<p style="font-size: 16px; color: #333;">
    Kami menerima permintaan untuk mereset password Anda. Klik tombol di bawah ini untuk mengatur ulang password Anda:
</p>

@component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
Reset Password
@endcomponent

<p style="font-size: 16px; color: #555;">
    Jika Anda tidak meminta reset password, abaikan pesan ini. Link ini akan kedaluwarsa dalam <strong>10 menit</strong>.
</p>

<br>
Terima kasih,<br>
**Ciputra Mitra Hospital**

<table width="100%" style="margin-top: 10px; font-size: 12px; color: #aaa;">
    <tr>
        <td align="center">
            <p>Jl. Ahmad Yani, KM 6,7, Perumahan Citra Land, Banjar, Kalimantan Selatan</p>
            <p>Email: <a href="mailto:auth@ciputramitrahospital" style="color: #17a2b8;">auth@ciputramitrahospital</a> | Telp: +628787878</p>
        </td>
    </tr>
</table>
@endcomponent
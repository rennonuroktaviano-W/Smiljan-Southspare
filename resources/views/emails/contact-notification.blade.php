<!DOCTYPE html>
<html lang="id">
<head><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background-color:#f4f1eb;font-family:Georgia,serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f1eb;padding:40px 20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background-color:#fff;border:1px solid #e0ddd4;">
<tr><td style="padding:48px 40px;">
    <p style="font-size:12px;letter-spacing:0.3em;text-transform:uppercase;color:#8a8578;margin:0 0 32px;">{{ config('app.name') }}</p>
    <h1 style="font-size:28px;font-weight:normal;margin:0 0 24px;color:#171714;">Pesan Baru</h1>
    <p style="font-size:15px;line-height:1.8;color:#4a4740;margin:0 0 8px;">Anda menerima pesan baru dari formulir kontak:</p>
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:16px 0 24px;">
        <tr><td style="padding:12px 16px;background-color:#f9f7f3;border-left:3px solid #8a6d4b;">
            <p style="font-size:14px;color:#4a4740;margin:0 0 4px;"><strong>{{ $name }}</strong> &lt;{{ $email }}&gt;</p>
            <p style="font-size:14px;line-height:1.7;color:#4a4740;margin:0;white-space:pre-line;">{{ $body }}</p>
        </td></tr>
    </table>
    <p style="margin:0 0 32px;">
        <a href="{{ route('admin.messages.index') }}" style="display:inline-block;padding:14px 32px;background-color:#171714;color:#e9e4d8;text-decoration:none;font-size:13px;letter-spacing:0.15em;text-transform:uppercase;">Lihat Pesan</a>
    </p>
</td></tr>
<tr><td style="padding:24px 40px;border-top:1px solid #e0ddd4;">
    <p style="font-size:11px;color:#b5b0a4;margin:0;">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
</td></tr>
</table>
</td></tr></table>
</body>
</html>

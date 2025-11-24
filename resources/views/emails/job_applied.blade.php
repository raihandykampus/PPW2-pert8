<!DOCTYPE html>
<html>
<head>
    <title>Lamaran Terkirim</title>
</head>
<body>
    <h2>Halo {{ $application->user->name }},</h2>
    
    <p>Terima kasih telah melamar <b>{{ $application->job->title }}</b>.</p>
    
    <p>Kami telah menerima berkas CV Anda:</p>
    
    <a href="{{ asset('storage/' . $application->cv) }}" 
       style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
       Lihat / Download CV Saya
    </a>

    <br><br>
    <p>Salam,<br>Tim Job Portal</p>
</body>
</html>
</html>
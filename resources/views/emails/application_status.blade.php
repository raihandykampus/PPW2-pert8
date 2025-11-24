<!DOCTYPE html>
<html>
<body>
    <h2>Halo {{ $application->user->name }},</h2>
    
    <p>Status lamaran Anda untuk posisi <b>{{ $application->job->title }}</b> telah diperbarui menjadi:</p>
    
    <h3 style="color: {{ $application->status == 'Accepted' ? 'green' : 'red' }}">
        {{ $application->status == 'Accepted' ? 'DITERIMA 🎉' : 'DITOLAK' }}
    </h3>

    <p>Silakan cek dashboard akun Anda untuk info lebih lanjut.</p>
</body>
</html>
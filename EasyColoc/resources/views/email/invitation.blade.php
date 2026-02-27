<!DOCTYPE html>
<html>
<head>
    <title>Invitation à rejoindre une colocation</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2563eb;">Invitation à rejoindre une colocation</h2>
    <p>Bonjour,</p>
    <p>Vous avez été invité à rejoindre une colocation sur <strong>EasyColoc</strong>.</p>
    <p>Cliquez sur le bouton ci-dessous pour accepter l'invitation :</p>
    <p style="margin-top: 2rem;">
        <a href="{{ route('acceptInvitation', $token) }}" 
           style="background-color: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold;">
            Accepter l'invitation
        </a>
    </p>
</body>
</html>
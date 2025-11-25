<div style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px;">
    <div
        style="max-width: 500px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h1 style="color: #333; text-align: center; margin-bottom: 20px;">Confirmação de Email</h1>
        <p style="font-size: 16px; color: #555;">Olá <strong>{{ $nome }}</strong>,</p>
        <p style="font-size: 16px; color: #555;">
            Valeu por criar sua conta! Para ativar tudo certinho, é só clicar no botão abaixo:
        </p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="http://127.0.0.1/validar?email={{ urlencode($email) }}"
                style="background: #4a7dfc; color: #fff; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-size: 16px; font-weight: bold; display: inline-block;">
                Validar Email
            </a>
        </div>
        <p style="font-size: 14px; color: #777;">
            Se você não criou uma conta, pode ignorar este email — nada será feito.
        </p>
        <p style="font-size: 14px; color: #777; margin-top: 30px;">
            Abraços,<br>
            <strong>Equipe do Site</strong>
        </p>
    </div>
</div>
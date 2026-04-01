<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMS Smart Tracking - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { margin: 0; font-family: 'Montserrat', Arial, sans-serif; background: #f8f8ff; }
        .login-container { display: flex; min-height: 100vh; }
        .login-left { flex: 1; background: #c97af1; color: #fff; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; padding: 60px 50px; }
        .logo-title { display: flex; align-items: center; font-size: 1.3rem; font-weight: 700; margin-bottom: 30px; }
        .logo-icon { font-size: 2rem; margin-right: 10px; }
        .logo-text { letter-spacing: 1px; }
        .headline { font-size: 2.7rem; font-weight: 800; margin: 0 0 20px 0; line-height: 1.1; }
        .highlight { background: #2ee6ff; color: #000; padding: 0 8px; border-radius: 4px; }
        .desc { font-size: 1.05rem; margin-bottom: 40px; color: #f3eaff; }
        .features { display: flex; gap: 40px; margin-top: 40px; }
        .feature-with-bar { display: flex; align-items: flex-start; gap: 12px; }
        .vertical-bar { width: 5px; height: 40px; background: #2ee6ff; border-radius: 6px; margin-right: 8px; }
            .feature-value { font-size: 1.3rem; font-weight: 800; color: #2ee6ff; letter-spacing: 1px; }
            .feature-with-bar div { color: #fff; font-size: 1.08rem; font-weight: 600; text-transform: uppercase; }
        .login-right { flex: 1; background: #fff; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 60px 50px; position: relative; }
        .welcome { font-size: 2rem; font-weight: 800; margin-bottom: 10px; color: #222; }
        .subtitle { color: #444; margin-bottom: 30px; }
        .role-tabs { display: flex; gap: 0; margin-bottom: 30px; }
        .tab { flex: 1; padding: 16px 0; border: 2.5px solid #222; background: #f8f8ff; color: #222; font-weight: 700; font-size: 1.08rem; cursor: pointer; border-right: none; border-radius: 10px 10px 0 0; box-shadow: 0 4px 12px #0001; transition: background 0.2s, color 0.2s; position: relative; z-index: 1; }
            .tab { flex: 1; padding: 18px 0 18px 0; border: 3px solid #111; border-right: none; background: #fff; color: #111; font-weight: 800; font-size: 1.13rem; cursor: pointer; border-radius: 0; box-shadow: 3px 3px 0 #111; display: flex; align-items: center; justify-content: center; gap: 10px; letter-spacing: 0.5px; transition: background 0.2s, color 0.2s; position: relative; z-index: 1; }
        .tab:last-child { border-right: 2.5px solid #222; }
        .tab.active { background: #2ee6ff; color: #000; border-bottom: 2.5px solid #2ee6ff; z-index: 2; }
        .login-form { width: 100%; max-width: 400px; display: flex; flex-direction: column; gap: 18px; }
        .form-label { font-weight: 700; color: #222; margin-bottom: 4px; display: flex; justify-content: space-between; align-items: center; }
        .input-group { display: flex; align-items: center; background: #f3f3f3; border: 1.5px solid #bbb; border-radius: 6px; padding: 0 12px; margin-bottom: 8px; }
        .input-icon { font-size: 1.1rem; margin-right: 8px; color: #888; }
        input[type="text"], input[type="password"] { border: none; background: transparent; outline: none; font-size: 1rem; padding: 14px 0; width: 100%; color: #222; }
        .btn-login { background: #c97af1; color: #fff; font-weight: 700; font-size: 1.1rem; border: none; border-radius: 6px; padding: 14px 0; margin-top: 10px; cursor: pointer; box-shadow: 3px 3px 0 #222; transition: background 0.2s; }
        .btn-login:hover { background: #a85ed1; }
        .forgot { color: #c97af1; font-size: 0.95rem; text-decoration: none; float: right; }
        .divider { border-top: 1px dashed #bbb; margin: 30px 0 18px 0; width: 100%; }
        .no-account { text-align: center; color: #222; margin-bottom: 20px; }
        .btn-contact { background: #fff; color: #222; border: 2px solid #222; border-radius: 6px; padding: 8px 18px; font-weight: 700; margin-left: 10px; cursor: pointer; transition: background 0.2s; }
        .btn-contact:hover { background: #f3eaff; }
        .login-footer { position: absolute; bottom: 18px; left: 0; right: 0; text-align: center; color: #888; font-size: 0.95rem; }
        @media (max-width: 900px) {
            .login-container { flex-direction: column; }
            .login-left, .login-right { flex: unset; width: 100%; min-height: 350px; padding: 40px 20px; }
            .login-footer { position: static; margin-top: 30px; }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>

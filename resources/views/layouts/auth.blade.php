<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMS Smart Tracking – Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Montserrat', Arial, sans-serif; background: #f8f8ff; }
        .login-container { display: flex; min-height: 100vh; }
        .login-left  { flex: 1; background: #c97af1; color: #fff; display: flex; flex-direction: column; justify-content: center; padding: 60px 50px; }
        .logo-title  { display: flex; align-items: center; font-size: 1.3rem; font-weight: 700; margin-bottom: 30px; }
        .logo-icon   { font-size: 2rem; margin-right: 10px; }
        .headline    { font-size: 2.7rem; font-weight: 800; margin: 0 0 20px; line-height: 1.1; }
        .highlight   { background: #2ee6ff; color: #000; padding: 0 8px; border-radius: 4px; }
        .desc        { font-size: 1.05rem; color: #f3eaff; }
        .login-right { flex: 1; background: #fff; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 60px 50px; }
        .welcome     { font-size: 2rem; font-weight: 800; margin-bottom: 6px; color: #222; }
        .subtitle    { color: #666; margin-bottom: 24px; font-size: 0.95rem; }
        /* Tab role */
        .role-tabs   { display: flex; width: 100%; max-width: 400px; margin-bottom: 24px; border: 2px solid #222; border-radius: 8px; overflow: hidden; }
        .tab         { flex: 1; padding: 12px 0; text-align: center; text-decoration: none; font-weight: 700; font-size: 0.82rem; color: #444; background: #fff; border-right: 1px solid #ddd; transition: background 0.2s; }
        .tab:last-child { border-right: none; }
        .tab.active  { background: #c97af1; color: #fff; }
        /* Form */
        .login-form  { width: 100%; max-width: 400px; display: flex; flex-direction: column; gap: 14px; }
        .form-label  { font-weight: 700; color: #222; font-size: 0.9rem; }
        .input-group { display: flex; align-items: center; background: #f3f3f3; border: 1.5px solid #bbb; border-radius: 6px; padding: 0 12px; }
        .input-icon  { font-size: 1.1rem; margin-right: 8px; color: #888; }
        input[type="email"],
        input[type="password"],
        input[type="text"]  { border: none; background: transparent; outline: none; font-size: 1rem; padding: 13px 0; width: 100%; color: #222; font-family: inherit; }
        .btn-login   { background: #c97af1; color: #fff; font-weight: 700; font-size: 1.05rem; border: none; border-radius: 6px; padding: 14px 0; cursor: pointer; transition: background 0.2s; font-family: inherit; }
        .btn-login:hover { background: #a85ed1; }
        .divider     { border-top: 1px dashed #ddd; margin: 20px 0; width: 100%; max-width: 400px; }
        @media (max-width: 768px) {
            .login-container { flex-direction: column; }
            .login-left, .login-right { padding: 30px 20px; }
            .headline { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
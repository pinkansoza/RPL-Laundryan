<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - Laundry Admin</title>
    <link rel="manifest" href="/manifest.json">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #1f2937;
        }
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            max-width: 90%;
            width: 400px;
        }
        .icon {
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
        }
        .icon svg {
            width: 80px;
            height: 80px;
            color: #0ea5e9;
        }
        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
            margin-top: 0;
        }
        p {
            color: #4b5563;
            line-height: 1.5;
            margin-bottom: 24px;
        }
        button {
            background-color: #0ea5e9;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            width: 100%;
        }
        button:hover {
            background-color: #0284c7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
            </svg>
        </div>
        <h1>Koneksi Terputus</h1>
        <p>Silakan hubungkan kembali ke internet untuk melanjutkan pengelolaan laundry.</p>
        <button onclick="window.location.reload()">Coba Muat Ulang</button>
    </div>
</body>
</html>
